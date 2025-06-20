<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Models\Pump;
use App\Models\User;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public $allCustomers, $allPlans, $allPumps;

    public function __construct()
    {
        $this->allCustomers = User::all();
        $this->allPlans = Plan::with('pumps')->get();
        $this->allPumps = Pump::with('user')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.plans.index', ['plans' => $this->allPlans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        $validated_data = $request->validated();

        $plan = new Plan();
        $plan->title = $validated_data['title'];
        $plan->price = $validated_data['price'];
        $plan->duration = $validated_data['duration'];
        $plan->description = $validated_data['description'];

        $plan->save();

        return redirect()->route('plans.show', $plan->id)->with('success', 'New Plan created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.show', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
    {
        $validated_data = $request->validated();

        $plan = Plan::findOrFail($id);
        $plan->title = $validated_data['title'];
        $plan->price = $validated_data['price'];
        $plan->duration = $validated_data['duration'];
        $plan->description = $validated_data['description'];

        $plan->update();

        return redirect()->route('plans.show', $plan->id)->with('success', 'Plan Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();


        return redirect()->back()->with('success', 'Plan deleted successfully !');
    }
}
