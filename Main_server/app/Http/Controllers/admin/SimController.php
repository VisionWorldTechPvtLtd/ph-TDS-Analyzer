<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SimModel;
use App\Models\User;
use App\Models\Pump;
use App\Http\Requests\Sims as RequestSims;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimController extends Controller
{
    protected $customers;
    protected $pumps;
    public function __construct()
    {
        $this->customers = User::with(['pumps'])->get();
        $this->pumps = Pump::with(['user'])->get();
        $this->sims = SimModel::whereNull('pump_id')->select('sim_number')->get();
    }
    public function index()
    {
        return view('admin.sim.create');
    }

    public function create()
    {
        return view('admin.sim.attach', ['customers' => $this->customers, 'pumps' => $this->pumps, 'sims' => $this->sims]);
    }

    public function connect(Request $request)
    {
        $request->validate([
            'pump_id' => 'required|exists:pumps,id',
            'sim_number' => 'required|string',
        ]);

        $pump_id = $request->input('pump_id');
        $sim_number = $request->input('sim_number');
        $existingSim = SimModel::where('pump_id', $pump_id)->first();
        if ($existingSim) {
            return redirect()->back()->with('error', 'This Borewell  is already connected to another SIM.');
        }
        $simModel = SimModel::where('sim_number', $sim_number)->first();
        if ($simModel) {
            $simModel->pump_id = $pump_id;
            $simModel->save();
        } else {
            return redirect()->back()->with('error', 'SIM not found');
        }
        return redirect()->back()->with('success', 'SIM connected to Borewell successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(RequestSims $request)
    {
        $validatedData = $request->validated();
        $sims = new SimModel();

        $sims->sim_company = $validatedData['sim_company'];
        $sims->sim_imei = $validatedData['sim_imei'];
        $sims->sim_number = $validatedData['sim_number'];
        $sims->sim_name = $validatedData['sim_name'];
        $sims->sim_type = $request->sim_type;
        $sims->sim_active = $request->sim_active;
        $sims->sim_purchase = $validatedData['sim_purchase'];
        $sims->sim_start = $validatedData['sim_start'];
        $sims->sim_end = $validatedData['sim_end'];

        $sims->save();
        return redirect()->route('viewindex')->with('success', 'New SIM registered successfully!');
    }

    public function report()
    {
        return view('admin.sim.report');
    }

    public function viewindex()
    {
        $sims = SimModel::select('sims.id', 'pumps.id as pump_id', 'users.company', 'users.first_name','users.last_name', 'sims.sim_imei', 'sims.sim_number', 'sims.sim_purchase', 'sims.sim_start', 'sims.sim_end')
            ->leftJoin('pumps', 'sims.pump_id', '=', 'pumps.id')
            ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
            ->get();
        return view('admin.sim.index', ['sims' => $sims]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $sim = SimModel::with(['user', 'pump'])->findOrFail($id);
        $sims = SimModel::all();
        return view('admin.sim.update', ['sim' => $sim, 'sims' => $sims]);
    }

    public function show($id)
    {
        $sim = SimModel::with(['user', 'pump'])->findOrFail($id);
        $sims = SimModel::all();
        return view('admin.sim.show', ['sim' => $sim, 'sims' => $sims]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sim_start' => 'required|date',
            'sim_end' => 'required|date',
        ]);
        $sim = SimModel::find($id);
        if (!$sim) {
            return redirect()->route('viewindex')->with('error', 'SIM not found');
        }
        $sim->sim_start = $request->input('sim_start');
        $sim->sim_end = $request->input('sim_end');
        $sim->save();

        return redirect()->route('viewindex')->with('success', 'SIM updated successfully');
    }

    public function destroy($id)
    {
        $sim = SimModel::findOrFail($id);
        $sim->delete();
        return redirect()->back()->with('success', 'Sim  deleted successfully !');
    }
    public function deattach($id)
    {
        $sim = SimModel::findOrFail($id);
        $sim->pump_id = null;
        $sim->save();
        return redirect()->back()->with('success', 'SIM de-attach from Borewell successfully!');
    }

    public function active()
    {
        $sims = SimModel::select('sims.id', 'pumps.id as pump_id', 'users.company', 'users.first_name', 'users.last_name', 'sims.sim_imei', 'sims.sim_number', 'sims.sim_purchase', 'sims.sim_start', 'sims.sim_end')
            ->leftJoin('pumps', 'sims.pump_id', '=', 'pumps.id')
            ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
            // ->where('sims.sim_active', 1)
            ->whereNotNull('sims.pump_id')
            ->get();
        return view('admin.sim.active', ['sims' => $sims]);
    }
    public function remaining()
    {
        $sims = SimModel::select('sims.id', 'pumps.id as pump_id', 'users.company', 'sims.sim_imei', 'sims.sim_number', 'users.first_name', 'users.last_name', 'sims.sim_purchase', 'sims.sim_start', 'sims.sim_end')
            ->leftJoin('pumps', 'sims.pump_id', '=', 'pumps.id')
            ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
            ->where('sims.pump_id', null)
            ->get();
        return view('admin.sim.remaining', ['sims' => $sims]);
    }


}
