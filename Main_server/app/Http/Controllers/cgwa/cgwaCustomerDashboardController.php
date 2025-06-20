<?php

namespace App\Http\Controllers\cgwa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SinglePumpReportRequest;
use App\Http\Requests\overflowRequestdata;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pump;
use App\Models\PumpDailyFlowData;
use App\Models\Plan;
use App\Models\PumpData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateReportDataRequest;
use App\Http\Requests\negativeReportdata;

class cgwaCustomerDashboardController extends Controller
{
      public function __construct()
    {
        $this->allCustomers = User::all();
        $this->customers = User::with(['pumps'])->get();
        $this->pumps = Pump::with(['user'])->get();
        $this->allPlans = Plan::all();
        $this->allPumps = Pump::all();
        $this->allPumpsPlanExpires = Pump::with('user')->whereMonth('plan_end_date', '<=', date('m'))->whereYear('plan_end_date', '<=', date('Y'))->get();
        $this->pumpdata=PumpData::with('pump')->wheredate('updated_at', Carbon::today())->get();
        $this->pumpoffline = PumpData::with('pump') ->whereDate('updated_at', '<', Carbon::today())->get();
       
        $this->pumpData = DB::table('pump_data')->leftJoin('pumps', 'pump_data.pump_id', '=', 'pumps.id')->leftJoin('users', 'pumps.user_id', '=', 'users.id')
        ->leftJoin('pump_morning_data', function($join){
             $join->on('pumps.id', '=', 'pump_morning_data.pump_id')
             ->whereDate('pump_morning_data.created_at', '=', date('Y-m-d'));
        })
        ->select(
            'pumps.id',
            'pumps.serial_no',
            'pumps.pump_title',
            'pumps.plan_status',
            'pumps.external',
            'pumps.tested',
            'pump_morning_data.forward_flow as morning_flow',
            'pump_data.forward_flow',
            'pump_data.reverse_flow',
            'pump_data.current_flow',
            'pump_data.ground_water_level',
            'pump_data.updated_at',
            'users.first_name',
            'users.last_name',
            'users.company'
        )
        ->orderBy('pumps.id', 'asc')
        ->get();
    }

public function liveData(){
    return view('cgwa.live-data', ['pumpData' => $this->pumpData]);
}

    public function index()
    {
        return view('cgwa.dashborad', [
           'allCustomers' => $this->allCustomers,
           'allPumps' => $this->allPumps,
           'allPumpsPlanExpires' => $this->allPumpsPlanExpires,
           'allPlans' =>  $this->allPlans,
           'pumpdata' => $this->pumpdata,
           'pumpoffline' => $this->pumpoffline

        ]);
    }

    public function cgwacustomer(){
        return view('cgwa.cgwacustomer',['customers' => $this->allCustomers]);
    }

    public function customershow($id){
        $customer = User::with(['pumps'])->findOrFail($id);
        return view('cgwa.customershow', ['customer' => $customer]);
    }

    public function cgwapumpReport(){
          return view('cgwa.pumpreport', ['customers' => $this->customers, 'pumps' => $this->pumps]);
    }

     public function cgwapumpReportData(SinglePumpReportRequest $request)
     {
        $validated_data = $request->validated();
        $requestedYear = date('Y', strtotime($validated_data['month']));
        $requestedMonth = date('m', strtotime($validated_data['month']));
        $tableName = 'year_' . $requestedYear;
        $report_data = DB::table('users')
                    ->leftJoin('pumps', 'users.id', '=', 'pumps.user_id')
                    ->leftJoin($tableName, 'pumps.id', '=', $tableName.'.pump_id')
                    ->where('pumps.id', $validated_data['pump_id'])
                    ->whereMonth($tableName.'.created_at', '=', $requestedMonth)
                    ->whereYear($tableName.'.created_at', '=', $requestedYear)
                    ->select(
                        'users.first_name',
                        'users.last_name',
                        'pumps.id',
                        'pumps.pump_title',
                        'pumps.serial_no',
                        $tableName .'.id as pdfd_id',
                        $tableName . '.forward_flow',
                        $tableName .'.reverse_flow',
                        $tableName .'.ground_water_level',
                        $tableName .'.totalizer',
                        $tableName .'.created_at'
                        )
                    ->orderBy($tableName .'.created_at', 'asc')
                    ->get();
                    return redirect()->back()->with([ 'report_data' => $report_data]);
    }

    

     public function editReportData($pump_id)
    {
        $report_data = PumpDailyFlowData::findOrFail($pump_id);
        $startDate = isset($report_data->created_at) ? Carbon::parse($report_data->created_at)->startOfMonth() : Carbon::now()->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $monthlyData = PumpDailyFlowData::where('pump_id', $report_data->pump_id)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->get();
        return view('cgwa.editreport', compact('report_data', 'monthlyData', 'startDate', 'endDate','pump_id'));
    }
    
    public function updateReportData(UpdateReportDataRequest $request, $pumpId)
    {
        $validated_data = $request->validated();
        foreach ($validated_data['forward_flow'] as $dataId => $forward_flow) {
            $report_data = PumpDailyFlowData::find($dataId);
    
            if ($report_data) {
                $report_data->forward_flow = $validated_data['forward_flow'][$dataId];
                $report_data->reverse_flow = $validated_data['reverse_flow'][$dataId];
                $report_data->ground_water_level = $validated_data['ground_water_level'][$dataId];
                $report_data->totalizer = $validated_data['totalizer'][$dataId];
                $report_data->update();   
            }
        }
    
        return redirect()->route('cgwa.data.edit', $pumpId)->with('success', 'Report data updated successfully!');
    }
    
    
public function overflowcgwa()
{
   return view('cgwa.overflowcgwa');
} 

public function overflowcgwaReportData(OverflowRequestData $request)
{
    $validated_data = $request->validated();

    $requestedYear = date('Y', strtotime($validated_data['month']));
    $requestedMonth = date('m', strtotime($validated_data['month']));

    $report_data = DB::table('overflows')
        ->join('users', 'overflows.user_id', '=', 'users.id')
        ->whereMonth('overflows.created_at', $requestedMonth)
        ->whereYear('overflows.created_at', $requestedYear)
        ->select(
            'users.company',
            'users.id as user_id',
            'users.contact_no',
            'overflows.user_limit',
            'overflows.today_flow',
            'overflows.overflow',
            'overflows.created_at'
        )
        ->orderBy('overflows.created_at', 'asc')
        ->get();
    return redirect()->back()->with([
        'report_data' => $report_data,
        'month' => $validated_data['month']
    ]);
}




public function offline()
{
    $pumps = DB::table('pump_data')
        ->leftJoin('pumps', 'pump_data.pump_id', '=', 'pumps.id')
        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
        ->leftJoin('pump_morning_data', function ($join) {
            $join->on('pumps.id', '=', 'pump_morning_data.pump_id')
                ->whereDate('pump_morning_data.created_at', '=', date('Y-m-d'));
        })
        ->whereDate('pump_data.updated_at', '!=', Carbon::today())
        ->select(
            'pumps.id as pump_id',
            'pumps.serial_no',
            'pumps.pump_title',
            'pumps.plan_status',
            'pump_data.updated_at',
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.company',
            'users.email'
        )
        ->orderBy('users.id', 'asc')
        ->get();

    
    $pumpData = $pumps->groupBy('user_id');

    return view('cgwa.offline', compact('pumpData'));
}


public function offlineemail($userId)
{
    $user = User::with('pumps')->findOrFail($userId);
    $today = Carbon::today();

    $offlinePumps = [];

    foreach ($user->pumps as $pump) {
        $hasTodayData = PumpData::where('pump_id', $pump->id)
            ->whereDate('updated_at', $today)
            ->exists();

        if (!$hasTodayData) {
            $offlinePumps[] = $pump;
        }
    }

    if (!empty($offlinePumps)) {
        Mail::send('cgwa.offlineemail', [
            'user' => $user,
            'offlinePumps' => $offlinePumps,
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->cc('vwtplcgwa@gmail.com ') 
                    ->subject('Borewell Offline Alert');
        });

        return back()->with('success', 'Offline email sent to ' . $user->email);
    }

    return back()->with('warning', 'No offline pumps found for this user today.');
}

public function negative(){
    return view('cgwa.negative');
}

  public function negativeReportData(NegativeReportdata $request)
    {
        $validated_data = $request->validated();
        $requestedYear = date('Y', strtotime($validated_data['month']));
        $requestedMonth = date('m', strtotime($validated_data['month']));
        $tableName = 'year_' . $requestedYear;

    $report_data = DB::table('users')
    ->leftJoin('pumps', 'users.id', '=', 'pumps.user_id')
    ->leftJoin($tableName, 'pumps.id', '=', $tableName . '.pump_id')
    ->whereMonth($tableName . '.created_at', '=', $requestedMonth)
    ->whereYear($tableName . '.created_at', '=', $requestedYear)
    ->where(DB::raw("{$tableName}.forward_flow < 0 OR {$tableName}.reverse_flow < 0 OR {$tableName}.ground_water_level < 0 OR {$tableName}.totalizer < 0"))
    
    ->select( 'users.company','pumps.id as pump_id', $tableName . '.id as pdfd_id', $tableName . '.forward_flow',$tableName . '.reverse_flow',$tableName . '.ground_water_level',$tableName . '.totalizer', $tableName . '.created_at')
    ->orderBy($tableName . '.created_at', 'asc')
    ->get();
    return redirect()->back()->with(['report_data' => $report_data,'month' => $validated_data['month']]);
    }

}
