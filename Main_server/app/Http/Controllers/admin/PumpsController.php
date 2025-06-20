<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\pumps;
use App\Http\Requests\Pumps as RequestsPumps;
use App\Models\Plan;
use App\Models\Pump;
use App\Models\PumpData;
use App\Models\PumpMorningData;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SimModel;

class PumpsController extends Controller
{

    public function __construct()
    {
        $this->allCustomers = User::all();
        $this->allPlans = Plan::all();
        $this->allPumps = Pump::with('user')->get();
        $this->allSim =SimModel::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //    return view('admin.pumps.index', ['pumps' => $this->allPumps]);
    // }
    public function index()
    {
        $currentDate = Carbon::now();
    
        foreach ($this->allPumps as $pump) {
            // Calibration Date Calculation
            $lastCalibrationDate = Carbon::parse($pump->last_calibration_date);
            $nextCalibrationDate = $lastCalibrationDate->copy()->addMonths(12);
            $calibrationRemainingDays = $currentDate->diffInDays($nextCalibrationDate, false);
            $pump->show_calibration_alarm = ($calibrationRemainingDays > 0 && $calibrationRemainingDays <= 30);
            $pump->calibration_remaining_days = $calibrationRemainingDays;
            $pump->calibration_message = "Calibration due in {$calibrationRemainingDays} days.";
           // plan_end Date Calculation
            $planEndDate = Carbon::parse($pump->plan_end_date);
            $thirtyDaysFromNow = $currentDate->copy()->addDays(30);
            $remainingDays = $planEndDate->diffInDays($currentDate, true); 
            $pump->show_alarm = ($remainingDays <= 30);
            $pump->remaining_days = $remainingDays;
            $pump->message = "Plan ends in {$pump->remaining_days} days.";
        }      
        return view('admin.pumps.index', [ 'pumps' => $this->allPumps ]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        $sim = SimModel::whereNull('pump_id')->get();
        return view('admin.pumps.create', ['customers' => $this->allCustomers,'plans' => $this->allPlans,'sim' => $sim]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsPumps $request)
    {
        $validatedData = $request->validated();

        $pump = new Pump();

        $pump->user_id = $request->user_id;
        $pump->pump_title = $validatedData['pump_title'];
        $pump->serial_no = $validatedData['serial_no'];
        $pump->last_calibration_date = $validatedData['last_calibration_date'];
        $pump->pipe_size = $validatedData['pipe_size'];
        $pump->manufacturer = $validatedData['manufacturer'];
        $pump->longitude = $request->longitude;
        $pump->latitude = $request->latitude;
        $pump->flow_limit = $request->flow_limit;
        $pump->imei_no = $validatedData['imei_no'];
        $pump->mobile_no = $validatedData['mobile_no'];
        $pump->u_key = $request->u_key;
        $pump->panel_lock = $request->panel_lock == 'on' ? 1 : 0;
        $pump->on_off_status = $request->on_off_status == 'on' ? 1 : 0;
        $pump->external = $request->external == 'on' ? 1 : 0;
        $pump->auto_manual = $request->auto_manual == 'on' ? 1 : 0;
        $pump->tested = $request->tested == 'on' ? 1 : 0;
        $pump->visiable = $request->visiable == 'on' ? 1 : 0;
        $pump->live_data = $request->live_data == 'on' ? 1 : 0;
        $pump->piezometer = $request->piezometer== 'on' ? 1 : 0;
        $pump->address = $request->address;
        $pump->plan_id = $validatedData['plan_id'];

        $planDetails = Plan::findOrFail($validatedData['plan_id']);

        $pump->plan_start_date = date('Y-m-d');
        $pump->plan_end_date = date('Y-m-d', strtotime("+".$planDetails->duration." months", strtotime(date('Y-m-d'))));
        $pump->plan_status =0;

        $pump->save();

        $pumpData = new PumpData();
        $pumpData->pump_id = $pump->id;
        $pumpData->forward_flow = 0;
        $pumpData->reverse_flow = 0;
        $pumpData->current_flow = 0;
        $pumpData->ground_water_level = 0;

        $pumpData->save();

        $pumpData = new PumpMorningData();
        $pumpData->pump_id = $pump->id;
        $pumpData->forward_flow = 0;
        $pumpData->reverse_flow = 0;
        $pumpData->ground_water_level = 0;

        $pumpData->save();

        return redirect()->route('pumps.show', $pump->id)->with('success', 'New pump registered successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pump = Pump::with(['user', 'plan'])->findOrFail($id);
        return view('admin.pumps.show', ['pump' => $pump]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $pump = Pump::with(['user','plan'])->findOrFail($id);
    //     return view('admin.pumps.edit', ['pump' => $pump, 'customers' => $this->allCustomers, 'plans' => $this->allPlans]);
    // }
    public function edit($id)
    {
        $pump = Pump::with(['user', 'plan', 'sim'])->findOrFail($id);
        $sim = SimModel::whereNull('pump_id')->get(); 
        return view('admin.pumps.edit', ['pump' => $pump,'customers' => $this->allCustomers,'plans' => $this->allPlans,'sim' => $sim]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(RequestsPumps $request, $id)
    {
        $validatedData = $request->validated();
        $pump = Pump::findOrFail($id);
    
        $pump->user_id = $request->user_id;
        $pump->pump_title = $validatedData['pump_title'];
        $pump->serial_no = $validatedData['serial_no'];
        $pump->last_calibration_date = $validatedData['last_calibration_date'];
        $pump->pipe_size = $validatedData['pipe_size'];
        $pump->manufacturer = $validatedData['manufacturer'];
        $pump->longitude = $request->longitude;
        $pump->latitude = $request->latitude;
        $pump->flow_limit = $request->flow_limit;
        $pump->imei_no = $validatedData['imei_no'];
        $pump->mobile_no = $validatedData['mobile_no'];
        $pump->u_key = $request->u_key;
        $pump->panel_lock = $request->panel_lock === 'on' ? 1 : 0;
        $pump->on_off_status = $request->on_off_status === 'on' ? 1 : 0;
        $pump->external = $request->external === 'on' ? 1 : 0;
        $pump->auto_manual = $request->auto_manual === 'on' ? 1 : 0;
        $pump->tested = $request->tested === 'on' ? 1 : 0;
        $pump->visiable = $request->visiable === 'on' ? 1 : 0;
        $pump->live_data = $request->live_data === 'on' ? 1 : 0;
        $pump->piezometer = $request->piezometer === 'on' ? 1 : 0;
        $pump->address = $request->address;
    
        if ($request->has('plan_start_date') && $request->has('plan_end_date')) {
            $pump->plan_start_date = $request->plan_start_date;
            $pump->plan_end_date = $request->plan_end_date;  
    
            if ($request->has('plan_id')) {
                $planDetails = Plan::findOrFail($request->plan_id);
                if ($planDetails && $planDetails->duration) {
                    $pump->plan_end_date = $request->plan_end_date;
                }
            }                                                           
            $pump->plan_status = 0; 
        }
        if ($request->filled('sim_number')) {
            $sim = SimModel::find($request->sim_number); 
            if ($sim) {
                $sim->pump_id = $pump->id; 
                $sim->save();
            }
        }
        $pump->plan_id = $request->plan_id;
        $pump->save();
    
        return redirect()->back()->with('success', 'Pump details updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pump = Pump::findOrFail($id);
        $pump->delete();


        return redirect()->back()->with('success', 'Pump deleted successfully !');
    }

    public function piezometer()
{
    $piezometer = 1;
    $users = User::with('pumps')->get();
    $allPumps = Pump::where('piezometer', $piezometer)->get();
    return view('admin.pumps.piezometer', ['pumps' => $allPumps,  'users' => $users ]);
}

public function flowmeter(){
    $piezometer = 0;
    $users = User::with('pumps')->get();
    $allPumps = Pump::where('piezometer', $piezometer)->get();
    return view('admin.pumps.flowmeter', ['pumps' => $allPumps,  'users' => $users ]);
    
}
}
