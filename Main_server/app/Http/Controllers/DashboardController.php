<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountPasswordUpdateRequest;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\SinglePumpReportRequest;
use App\Http\Requests\UserPumpReportRequest;
use App\Models\Pump;
use App\Models\User;
use App\Models\PumpMorningData;
use App\Models\PumpData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Requests\DatePumpReportRequest;
use App\Http\Requests\annualreportclient;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $allPumps = Pump::where('user_id', Auth::user()->id)->get();
    //     $allPumpsPlanExpires = Pump::where('user_id', Auth::user()->id)->whereMonth('plan_end_date', '<=', date('m'))->whereYear('plan_end_date', '<=', date('Y'))->get();
    //     return view('dashboard', ['allPumps' => $allPumps, 'allPumpsPlanExpires' => $allPumpsPlanExpires]);
    // }

    public function pumps()
    {
        $allPumps = Pump::with('plan')->where('user_id', Auth::user()->id)->get();
        return view('pumps', ['pumps' => $allPumps]);
    }

    public function pump($id)
    {
        $pump = Pump::with('plan')->findOrFail($id);
        return view('pump', ['pump' => $pump]);
    }

    // public function data()
    // {
    //     $pumpData = Pump::leftJoin('pump_data', 'pumps.id', '=', 'pump_data.pump_id')->where('user_id', Auth::user()->id)->leftJoin('pump_morning_data', function($join){
    //          $join->on('pumps.id', '=', 'pump_morning_data.pump_id')
    //          ->whereDate('pump_morning_data.created_at', '=', date('Y-m-d'));
    //         })->select(
    //             'pumps.id',
    //             'pumps.serial_no',
    //             'pumps.pump_title',
    //             'pumps.plan_status',
    //             'pump_data.forward_flow',
    //             'pump_morning_data.forward_flow as morning_flow',
    //             'pump_data.reverse_flow',
    //             'pump_data.current_flow',
    //             'pump_data.ground_water_level',
    //             'pump_data.updated_at'
    //         )->get();
    //     return view('data', ['pumpData' => $pumpData]);
    // }
    public function data()
    {
        $user_id = Auth::user()->id;
        $pumpData = Pump::leftJoin('pump_data', 'pumps.id', '=', 'pump_data.pump_id')
            ->where('pumps.user_id', $user_id)
            ->where('pumps.piezometer', 0) 
            ->leftJoin('pump_morning_data', function ($join) {
                $join->on('pumps.id', '=', 'pump_morning_data.pump_id')
                    ->whereDate('pump_morning_data.created_at', '=', date('Y-m-d'));
            })
            ->select(
                'pumps.id',
                'pumps.serial_no',
                'pumps.pump_title',
                'pumps.plan_status',
                'pump_data.forward_flow',
                'pump_morning_data.forward_flow as morning_flow',
                'pump_data.reverse_flow',
                'pump_data.current_flow',
                'pump_data.ground_water_level',
                'pump_data.updated_at'
            )
            ->get();
        $piezometerData = Pump::leftJoin('pump_data', 'pumps.id', '=', 'pump_data.pump_id')
            ->where('pumps.user_id', $user_id)
            ->where('pumps.piezometer', 1) 
            ->select('pumps.id','pumps.serial_no','pumps.pump_title','pumps.plan_status','pump_data.ground_water_level','pump_data.updated_at')
            ->get();
    
        return view('data', ['pumpData' => $pumpData,'piezometerData' => $piezometerData,'piezometer' => $piezometerData->isNotEmpty()]);  
    }
    public function liveData()
    {
        $allPumps = Pump::where('user_id', Auth::user()->id)->get();
        return view('data', ['allPumps' => $allPumps]);
    }

    public function account()
    {
        return view('account');
    }

    public function infoUpdate(AccountRequest $request, $id){
        $validated_data = $request->validated();

        $account_data = User::findOrFail($id);

        $account_data->first_name = $validated_data['first_name'];
        $account_data->last_name = $validated_data['last_name'];
        $account_data->contact_no = $validated_data['contact_no'];

        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $path = 'uploads/customers/profile-pics/';
            $ext = $file->getClientOriginalExtension();
            $file_name = time().'.'.$ext;
            $file->move($path, $file_name);
            $account_data->profile_pic = $path.$file_name;
       }

       $account_data->update();

       return redirect()->route('user.account')->with('success', 'Info updated !');

    }
    public function passwordUpdate(AccountPasswordUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $user = User::findOrFail($id);
        if (!Hash::check($validatedData['oldpassword'], $user->password)) {
            return redirect()->route('user.account')->with('error', 'The old password is incorrect.');
        }
        $user->password = Hash::make($validatedData['password']);
        if ($user->save()) {
            return redirect()->route('user.account')->with('success', 'Password updated!');
        } else {
            return redirect()->route('user.account')->with('error', 'Failed to update password!');
        }
    }

    public function contactIndex(){
        return view('contact');
    }

    public function contactRequest(ContactRequest $request){

        $validated_data = $request->validated();
        return $validated_data;
    }
    
    public function index()
    {
        $currentDate = Carbon::now();
        $userId = Auth::user()->id;
        $elevenMonthsAgo = $currentDate->copy()->addDays(30);

        $allPumps = Pump::where('user_id', $userId)->get();
        $piezometerPumps = Pump::where('user_id', $userId)
                                ->where('piezometer', 1)
                                ->get();
        $nonPiezometerPumps = Pump::where('user_id', $userId)
                                ->where('piezometer', 0)
                                ->get();
        $allPumpsPlanExpires11Months = Pump::select('pumps.id', 'users.id as user_id','users.company',
            'pumps.plan_end_date', 'pumps.pump_title','pumps.last_calibration_date','sims.sim_end','sims.sim_number'  
        )
        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
        ->leftJoin('sims', 'pumps.id', '=', 'sims.pump_id')
        ->where('pumps.user_id', $userId)
        ->where(function ($query) use ($elevenMonthsAgo) {
            $query->whereDate('pumps.plan_end_date', '<=', $elevenMonthsAgo)
                  ->orWhereDate('sims.sim_end', '<=', $elevenMonthsAgo);
        })
        ->get();
        $pumps = Pump::with('pumpData')->where('user_id', $userId)->get();
        $pumpCount = $pumps->count();
        $forward_flow = 0;
        $onlineCount = 0;
        $offlineCount = 0;
    
        if ($pumpCount > 0 && $pumps->isNotEmpty()) {
            $pumpId = $pumps->first()->id;
    
            $forward_flow_data = PumpData::select('pump_data.pump_id', 'pump_data.forward_flow','pump_data.ground_water_level')
                ->where('pump_data.pump_id', $pumpId)
                ->get();
            $forward_flow = $forward_flow_data->sum('forward_flow');
    
            foreach ($pumps as $pump) {
                $latestPumpData = PumpData::where('pump_id', $pump->id)
                    ->whereDate('updated_at', Carbon::today())
                    ->exists();
    
                if ($latestPumpData) {
                    $onlineCount++;
                } else {
                    $offlineCount++;
                }
            }
        }
        $todayFlows = [];
        foreach ($allPumps as $pump) {
            $pumpId = $pump->id;
    
            $morningFlow = PumpMorningData::where('pump_id', $pumpId)
                ->latest('created_at')
                ->value('forward_flow');
            $pumpData = PumpData::where('pump_id', $pumpId)
                ->latest('created_at')
                ->value('forward_flow');
            $todayFlows[$pumpId] = ($pumpData ?? 0) - ($morningFlow ?? 0);
        }
        return view('dashboard', compact('allPumps', 'pumps', 'piezometerPumps','nonPiezometerPumps','forward_flow',
            'pumpCount','todayFlows','allPumpsPlanExpires11Months','onlineCount', 'offlineCount' ));
    }
    
public function getForwardFlow($pumpId)
{
    $pump = Pump::find($pumpId);

    if (!$pump) {
        return response()->json(['message' => 'Pump not found'], 404);
    }
    $forwardFlowData = PumpData::where('pump_id', $pumpId)->get();
    $latestFlowData = PumpData::where('pump_id', $pumpId)->latest('created_at')->value('forward_flow');
    $morningFlowData = PumpMorningData::where('pump_id', $pumpId)->latest('created_at')->value('forward_flow');
    $groundWaterLevels = $forwardFlowData->pluck('ground_water_level')->filter();

    if ($groundWaterLevels->isEmpty()) {
        $groundWaterLevels = collect([0]);
    }
    $forwardFlowTotal = $forwardFlowData->sum('forward_flow');
    $todayFlow = ($latestFlowData) - ($morningFlowData);

    return response()->json([
        'piezometer' => $pump->piezometer,
        'groundWaterLevels' => $groundWaterLevels->values(),
        'totalizer' => $forwardFlowTotal,
        'todayFlow' => $todayFlow,
    ]);
}

  
  
    // public function index()
    // {
    //     $currentDate = Carbon::now();
    //     $userId = Auth::user()->id;
    //     $elevenMonthsAgo = $currentDate->copy()->addDays(30);
    //     $daysDifference = Carbon::now()->diffInDays($elevenMonthsAgo);
    
    //     $allPumps = Pump::where('user_id', $userId)->get();
    //     $allPumpsPlanExpires11Months = Pump::select('pumps.id','users.id as user_id','users.company','pumps.plan_end_date','pumps.pump_title','pumps.last_calibration_date','sims.sim_end', 'sims.sim_number')
    //         ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
    //         ->leftJoin('sims', 'pumps.id', '=', 'sims.pump_id') 
    //         ->where('pumps.user_id', $userId)
    //         ->where(function ($query) use ($elevenMonthsAgo) {
    //             $query->whereDate('pumps.plan_end_date', '<=', $elevenMonthsAgo)
    //                   ->orWhereDate('sims.sim_end', '<=', $elevenMonthsAgo);   
    //         })
    //         ->get();
    
    //     // Count all pumps
    //     $pumpCount = $allPumps->count();
    //     $pumps = Pump::with('pumpData')->where('user_id', $userId)->get();
    
    //     // Forward flow calculation
    //     $forward_flow = null;
    //     if ($pumps->isNotEmpty()) {
    //         $pumpId = $pumps->first()->id;
    //         $forward_flow_data = PumpData::select('pump_data.pump_id', 'pump_data.forward_flow')
    //             ->leftJoin('users', 'pump_data.pump_id', '=', 'users.id')
    //             ->where('pump_data.pump_id', $pumpId)
    //             ->get();
    //         $forward_flow = $forward_flow_data->sum('forward_flow');
    //     }
    
    //     // Today flow calculation
    //     $todayFlows = [];
    //     foreach ($allPumps as $pump) {
    //         $pumpId = $pump->id;
    //         $morningFlow = PumpMorningData::where('pump_id', $pumpId)
    //             ->latest('created_at')
    //             ->value('forward_flow');
    //         $pumpData = PumpData::where('pump_id', $pumpId)
    //             ->latest('created_at')
    //             ->value('forward_flow');
            
    //         $todayFlows[$pumpId] = $pumpData - $morningFlow;
    //     }
    
    //     return view('dashboard', ['allPumps' => $allPumps,'pumps' => $pumps,'forward_flow' => $forward_flow,'pumpCount' => $pumpCount,'todayFlows' => $todayFlows,'allPumpsPlanExpires11Months' => $allPumpsPlanExpires11Months,'daysDifference' => $daysDifference]);
    // }  

    // public function getForwardFlow($pumpId)
    // {
    //     $latestFlowData = PumpData::where('pump_id', $pumpId)
    //         ->latest('created_at')
    //         ->value('forward_flow');
    //     $morningFlowData = PumpMorningData::where('pump_id', $pumpId)
    //         ->latest('created_at')
    //         ->value('forward_flow');

    //     $forwardFlowData = PumpData::select('forward_flow', 'ground_water_level')
    //         ->where('pump_id', $pumpId)
    //         ->get();
    //     if ($forwardFlowData->isEmpty() || $latestFlowData === null || $morningFlowData === null) {
    //         return response()->json(['message' => 'No forward flow data found for this pump.'], 404);
    //     }
    //     $forwardFlowTotal = $forwardFlowData->sum('forward_flow');
    //     $todayFlow = $latestFlowData - $morningFlowData;
    //     $groundWaterLevels = $forwardFlowData->pluck('ground_water_level')->filter();
    //     if ($groundWaterLevels->isEmpty()) {
    //         $groundWaterLevels = [0];
    //              }
    //     return response()->json(['totalizer' => $forwardFlowTotal,'todayFlow' => $todayFlow,'groundWaterLevels' => $groundWaterLevels]);
    // }

    public function pumpReport(){
        $pumps = Pump::with('pumpData')->where('user_id', Auth::user()->id)->get();
        return view('pump-report', ['pumps' => $pumps, "month" => ""]); 
    }

    public function pumpReportData(UserPumpReportRequest $request)
    {
        $validated_data = $request->validated();
        $reportData = ['piezometer' => [], 'non_piezometer' => []];
        $requestedYear = date('Y', strtotime($validated_data['month']));
        $requestedMonth = date('m', strtotime($validated_data['month']));
        $tableName = 'year_' . $requestedYear;

        foreach ($validated_data['pump_id'] as $pumpId) {
            $pump = DB::table('pumps')->where('id', $pumpId)->first();
    
            if ($pump) {
                $report_data = DB::table('pumps')
                    ->join('users', 'pumps.user_id', '=', 'users.id')
                    ->rightJoin($tableName, 'pumps.id', '=', $tableName . '.pump_id')
                    ->where('pumps.user_id', Auth::id())
                    ->where('pumps.id', $pumpId)
                    ->whereMonth($tableName . '.created_at', '=', $requestedMonth)
                    ->whereYear($tableName . '.created_at', '=', $requestedYear)
                    ->select(
                        'pumps.id',
                        'pumps.pump_title',
                        'pumps.serial_no', 
                        'users.profile_pic' ,
                        $tableName . '.forward_flow',
                        $tableName . '.reverse_flow',
                        $tableName . '.ground_water_level',
                        $tableName . '.created_at',
                        $tableName . '.totalizer'
                    )
                    ->orderBy($tableName . '.created_at', 'asc')
                    ->get();
    
                if ($report_data->isNotEmpty()) {
                    if ($pump->piezometer == 1) {
                        $reportData['piezometer'][] = $report_data;
                    } else {
                        $reportData['non_piezometer'][] = $report_data;
                    }
                }
            }
        }
    
        return redirect()->back()->with(['report_data' => $reportData, 'month' => $validated_data['month']]); 
    }
    
    public function datewise()
    {
        $pumps = Pump::with('pumpData')->where('user_id', Auth::user()->id)->get();
        return view('datewisereport', ['pumps' => $pumps, "month" => ""]);


    }

public function datewisereport(DatePumpReportRequest $request)
{
    $validated_data = $request->validated();
    $reportData = [
        'piezometer' => [],
        'non_piezometer' => []
    ];

    $selectedYear = $validated_data['year'];
    $startDate = $validated_data['start_date'];
    $endDate = $validated_data['end_date'];
    $startDate = Carbon::parse($startDate)->startOfDay();
    $endDate = Carbon::parse($endDate)->endOfDay();
    session(['startDate' => $startDate, 'endDate' => $endDate]);
    $userId = Auth::user()->id;
    $pumpId = $validated_data['pump_id'];

    $pump = DB::table('pumps')
        ->where('id', $pumpId)
        ->where('user_id', $userId)
        ->first();
    $tableName = 'year_' . $selectedYear;
    $yearlyData = DB::table('pumps')
        ->join('users', 'pumps.user_id', '=', 'users.id')
        ->leftJoin($tableName, "$tableName.pump_id", '=', 'pumps.id')
        ->where('pumps.user_id', $userId)
        ->where('pumps.id', $pumpId)
        ->whereBetween("$tableName.created_at", [$startDate, $endDate])
        ->select(
            'pumps.id',
            'pumps.pump_title',
            'pumps.serial_no',
            'users.profile_pic',
            "$tableName.forward_flow",
            "$tableName.reverse_flow",
            "$tableName.ground_water_level",
            "$tableName.totalizer",
            "$tableName.created_at"
        )
        ->orderBy($tableName . '.created_at', 'asc')
        ->get();
    if ($pump->piezometer == 1) {
        $reportData['piezometer'] = $yearlyData;
    } else {
        $reportData['non_piezometer'] = $yearlyData;
    }
    return view('datewisereport')->with(['report_data' => $reportData,'requestedYear' => $selectedYear,'requestedStartDate' => $startDate->format('Y-m-d'),'requestedEndDate' => $endDate->format('Y-m-d'),'pumps' => Pump::where('user_id', $userId)->get()]); 
}

public function annual(){
    $pumps = Pump::with('pumpData')->where('user_id', Auth::user()->id)->get();
    return view('annual-report', ['pumps' => $pumps, "month" => ""]);
}

public function annualreport(AnnualReportClient $request)
{
    $validatedData = $request->validated();
    $reportData = ['piezometer' => [], 'non_piezometer' => []];
    $requestedYear = $validatedData['year'];
    $tableName = 'year_' . $requestedYear;

    foreach ($validatedData['pump_id'] as $pumpId) {
        $pump = DB::table('pumps')->where('id', $pumpId)->first();
        if ($pump) {
            $reportDataQuery = DB::table('pumps')
                ->join('users', 'pumps.user_id', '=', 'users.id')
                ->leftJoin($tableName, 'pumps.id', '=', $tableName . '.pump_id')
                ->where('pumps.user_id', Auth::id())
                ->where('pumps.id', $pumpId)
                ->whereYear($tableName . '.created_at', '=', $requestedYear)
                ->select(
                    'pumps.id',
                    'pumps.pump_title',
                    'pumps.serial_no',
                    'users.profile_pic',
                    $tableName . '.forward_flow',
                    $tableName . '.reverse_flow',
                    $tableName . '.ground_water_level',
                    $tableName . '.created_at',
                    $tableName . '.totalizer'
                )
                ->orderBy($tableName . '.created_at', 'asc')
                ->get();

            if ($reportDataQuery->isNotEmpty()) {
                if ($pump->piezometer == 1) {
                    $reportData['piezometer'][] = $reportDataQuery;
                } else {
                    $reportData['non_piezometer'][] = $reportDataQuery;
                }
            }
        }
    }

    return redirect()->back()->with([ 'report_data' => $reportData, 'year' => $validatedData['year']]);
}

public function contact(){
    return view('contact_us');
 }



}












