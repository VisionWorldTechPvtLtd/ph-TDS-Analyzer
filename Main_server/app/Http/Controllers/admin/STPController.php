<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\STPRequest;
use App\Models\Plan;
use App\Models\STP;
use App\Models\STP_Data;
use App\Models\User;
use Illuminate\Http\Request;

class STPController extends Controller
{
    public function __construct()
    {
        $this->stps = STP::with('user')->get();
        $this->allPlans = Plan::all();
        $this->allCustomers = User::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stps.index', ['stps' => $this->stps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stps.create', ['customers' => $this->allCustomers, 'plans' => $this->allPlans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(STPRequest $request)
    {
        $validatedData = $request->validated();

        $stp = new STP();

        $stp->user_id = $request->user_id;
        $stp->title = $validatedData['title'];
        $stp->serial_no = $validatedData['serial_no'];
        $stp->manufacturer = $validatedData['manufacturer'];
        $stp->longitude = $request->longitude;
        $stp->latitude = $request->latitude;
        $stp->imei_no = $validatedData['imei_no'];
        $stp->mobile_no = $validatedData['mobile_no'];
        $stp->on_off_status = $request->on_off_status == 'on' ? 1 : 0;
        $stp->tested = $request->tested == 'on' ? 1 : 0;
        $stp->visiable = $request->visiable == 'on' ? 1 : 0;
        $stp->address = $request->address;
        $stp->plan_id = $validatedData['plan_id'];
        $stp->user_key = $validatedData['user_key'];

        $planDetails = Plan::findOrFail($validatedData['plan_id']);

        $stp->plan_start_date = date('Y-m-d');
        $stp->plan_end_date = date('Y-m-d', strtotime("+".$planDetails->duration." months", strtotime(date('Y-m-d'))));
        $stp->plan_status =0;

        $stp->save();

        $stpData = new STP_Data();
        $stpData->stp_id = $stp->id;
        $stpData->cod = 0;
        $stpData->bod = 0;
        $stpData->toc = 0;
        $stpData->tss = 0;
        $stpData->ph = 0;
        $stpData->temperature = 0;
        $stpData->h = 0;
        $stpData->i = 0;

        $stpData->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $stp = STP::with(['user','plan'])->findOrFail($id);
        return view('admin.stps.show', ['stp' => $stp]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stp = STP::with(['user','plan'])->findOrFail($id);
        return view('admin.stps.edit', ['customers' => $this->allCustomers, 'plans' => $this->allPlans, 'stp' => $stp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(STPRequest $request, $id)
    {
        $validatedData = $request->validated();

        $stp = STP::findOrFail($id);

        $stp->user_id = $request->user_id;
        $stp->title = $validatedData['title'];
        $stp->serial_no = $validatedData['serial_no'];
        $stp->manufacturer = $validatedData['manufacturer'];
        $stp->longitude = $request->longitude;
        $stp->latitude = $request->latitude;
        $stp->imei_no = $validatedData['imei_no'];
        $stp->mobile_no = $validatedData['mobile_no'];
        $stp->on_off_status = $request->on_off_status == 'on' ? 1 : 0;
        $stp->tested = $request->tested == 'on' ? 1 : 0;
        $stp->visiable = $request->visiable == 'on' ? 1 : 0;
        $stp->address = $request->address;
        $stp->plan_id = $validatedData['plan_id'];
        $stp->user_key = $validatedData['user_key'];

        $planDetails = Plan::findOrFail($validatedData['plan_id']);

        $stp->plan_start_date = date('Y-m-d');
        $stp->plan_end_date = date('Y-m-d', strtotime("+".$planDetails->duration." months", strtotime(date('Y-m-d'))));
        $stp->plan_status =0;

        $stp->update();

        return redirect()->route('stps.show', $stp->id)->with('success', 'STP Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stp = STP::findOrFail($id);
        $stp->delete();

        return redirect()->back()->with('success', 'STP Deleted successfully !');
    }
}
