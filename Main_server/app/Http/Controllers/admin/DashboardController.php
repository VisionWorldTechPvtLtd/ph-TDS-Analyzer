<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Pump;
use App\Models\PumpData;
use App\Models\User;
use App\Models\SimModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function __construct()
    {
        $this->allCustomers = User::all();
        $this->allPlans = Plan::all();
        $this->allPumps = Pump::all();
        $this->allPumpsPlanExpires = Pump::with('user')->whereMonth('plan_end_date', '<=', date('m'))->whereYear('plan_end_date', '<=', date('Y'))->get();
        $this->pumpdata=PumpData::with('pump')->wheredate('updated_at', Carbon::today())->get();
        $this->pumpoffline = PumpData::with('pump') ->whereDate('updated_at', '<', Carbon::today())->get();
    }

    public function index()
    {
        return view('admin.dashboard', [
           'allCustomers' => $this->allCustomers,
           'allPumps' => $this->allPumps,
           'allPumpsPlanExpires' => $this->allPumpsPlanExpires,
           'allPlans' =>  $this->allPlans,
           'pumpdata' => $this->pumpdata,
           'pumpoffline' => $this->pumpoffline

        ]);
    }

public function nabl()
{
    $elevenMonthsAgo = Carbon::now()->subMonths(11)->format('Y-m-d');
    $daysDifference = Carbon::now()->diffInDays($elevenMonthsAgo);
    $nablePlanExpires = Pump::select('pumps.id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'pumps.last_calibration_date', 'pumps.created_at')
        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
        ->whereDate('pumps.last_calibration_date', '<=', $elevenMonthsAgo)
        ->get();
    return view('admin.nabl', ['allPumpsPlanExpires' => $nablePlanExpires,'daysDifference' =>$daysDifference]);
}

public function planend()
{
    $currentDate = Carbon::now();
    $thirtyDaysFromNow = $currentDate->copy()->addDays(30);
    $allPumpsPlanExpires = Pump::select(
            'pumps.id', 
            'users.first_name', 
            'users.last_name', 
            'users.id as user_id', 
            'users.company', 
            'users.contact_no', 
            'pumps.plan_end_date', 
            'pumps.plan_start_date', 
            'sims.sim_end',
            'sims.sim_number'
        )
        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
        ->leftJoin('sims', 'pumps.id', '=', 'sims.pump_id') 
        ->where(function ($query) use ($thirtyDaysFromNow) {
            $query->whereDate('pumps.plan_end_date', '<=', $thirtyDaysFromNow)
                  ->orWhereDate('sims.sim_end', '<=', $thirtyDaysFromNow);
        })
        ->get();

    foreach ($allPumpsPlanExpires as $pump) {
        $planEndDate = Carbon::parse($pump->plan_end_date);
        $pump->remaining_days = $planEndDate->diffInDays($currentDate, false);
        $pump->message = "Plan ends in {$pump->remaining_days} days.";
    }
    
    return view('admin.planend', ['allPumpsPlanExpires' => $allPumpsPlanExpires]);
}
public function amc_cmc(){
    return view('admin.amc_cmc');
}
public function nableedit($id){
    $pump = Pump::with(['user','plan'])->findOrFail($id);
    $sim = SimModel::where('pump_id', $id)->first();
     return view('admin.nabl-edit', ['pump' => $pump, 'sim'=>$sim, 'customers' => $this->allCustomers, 'plans' => $this->allPlans]);
}


  
public function update(Request $request, $id)
{
    $pump = Pump::findOrFail($id);
    $sim = SimModel::where('pump_id', $pump->id)->first();

    $request->merge([
        'panel_lock' => filter_var($request->input('panel_lock'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        'external' => filter_var($request->input('external'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
    ]);

    $validatedData = $request->validate([
        'user_id' => 'required',
        'last_calibration_date' => 'nullable|date',
        'plan_start_date' => 'nullable|date',
        'plan_end_date' => 'nullable|date|after_or_equal:plan_start_date',
        'panel_lock' => 'required|boolean',
        'external' => 'nullable|boolean',
        'sim_start' => 'nullable|date',
        'sim_end' => 'nullable|date',
    ]);

    $nablUpdated = false;
    $planUpdated = false;
    
    if ($request->filled('last_calibration_date') && $pump->last_calibration_date != $validatedData['last_calibration_date']) {
        $pump->last_calibration_date = $validatedData['last_calibration_date'];
        $nablUpdated = true;
    }

    if (($request->filled('plan_start_date') && $pump->plan_start_date != $validatedData['plan_start_date']) ||
        ($request->filled('plan_end_date') && $pump->plan_end_date != $validatedData['plan_end_date'])) {
        $pump->plan_start_date = $validatedData['plan_start_date'];
        $pump->plan_end_date = $validatedData['plan_end_date'];
        $planUpdated = true;
    }

    if ($pump->user_id != $validatedData['user_id']) {
        $pump->user_id = $validatedData['user_id'];
    }

    if ($pump->panel_lock != $validatedData['panel_lock']) {
        $pump->panel_lock = $validatedData['panel_lock'];
    }

    if ($request->has('external') && $pump->external != $validatedData['external']) {
        $pump->external = $validatedData['external'];
    }

    $pump->save();

    if ($sim) {
        $sim->sim_start = $request->has('sim_start') ? $validatedData['sim_start'] : null;
        $sim->sim_end = $request->has('sim_end') ? $validatedData['sim_end'] : null;
        $sim->save();
    }

    if ($nablUpdated && $planUpdated) {
        $message = 'NABL and PLAN details updated successfully!';
    } elseif ($nablUpdated) {
        $message = 'NABL details updated successfully!';
    } elseif ($planUpdated) {
        $message = 'PLAN details updated successfully!';
    } else {
        $message = 'No details updated!';
    }

    return redirect()->back()->with('success', $message);
}
public function setting(){
    return view('admin.setting');
}

public function getNotificationCount()
{
    $currentDate = Carbon::now();
    $thirtyDaysFromNow = $currentDate->copy()->addDays(30);
    $currentYear = date('Y');
    $tableName = 'year_' . $currentYear;
    if (!DB::connection()->getSchemaBuilder()->hasTable($tableName)) {
        return response()->json(['hasExpiringPlan' => false, 'hasExpiringSim' => false, 'hasNegativeFlow' => false]); 
    }
    $hasExpiringPlan = DB::table('pumps')
        ->whereDate('plan_end_date', '<=', $thirtyDaysFromNow)
        ->exists();
    $hasExpiringSim = DB::table('sims')
        ->whereDate('sim_end', '<=', $thirtyDaysFromNow)
        ->exists();
    $hasNegativeFlow = DB::table($tableName)
        ->where('forward_flow', '<', 0)
        ->exists();
    return response()->json(['hasExpiringPlan' => $hasExpiringPlan, 'hasExpiringSim' => $hasExpiringSim,'hasNegativeFlow' => $hasNegativeFlow]);
}

}
