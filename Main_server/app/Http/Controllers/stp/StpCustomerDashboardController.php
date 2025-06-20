<?php

namespace App\Http\Controllers\stp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\STP;
use App\Models\User;
use App\Models\STP_Data;
use App\Models\StpDailydata;
use App\Http\Requests\STPReportRequest;
use App\Http\Requests\dailystpreport;
use App\Http\Requests\annualstpreport;



class StpCustomerDashboardController extends Controller
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

     public function contact(){
        return view('stp.contact_us');
     }
     
   public function index()
{
    $pumps = STP::where('user_id', Auth::id())->get();
    return view('stp.dashboard', compact('pumps'));
}

public function getStpData($stpId)
{
    $data = DB::table('s_t_p__data')
        ->select('bod', 'cod', 'toc', 'tss', 'ph', 'temperature', 'h', 'i', 'updated_at')
        ->where('stp_id', $stpId)
        ->orderByDesc('updated_at')
        ->first();
    return response()->json($data);
}

    public function stp()
    {
        $allStp = STP::with('plan')->where('user_id', Auth::user()->id)->get();
        return view('stp.stppump', ['pumps' => $allStp]);
    }
    public function stps($id)
    {
        $pump = STP::with('plan')->findOrFail($id);
        return view('stp.stps', ['pump' => $pump]);
    }

 
    public function stpdata()
    {
        $user_id = Auth::user()->id;
        $StpData = STP::leftJoin('s_t_p__data', 's_t_p_s.id', '=', 's_t_p__data.stp_id')
            ->where('s_t_p_s.user_id', $user_id)
            ->select(
                's_t_p_s.id',
                's_t_p_s.serial_no',
                's_t_p_s.title',
                's_t_p_s.plan_status',
                's_t_p__data.cod',
                's_t_p__data.bod',
                's_t_p__data.toc',
                's_t_p__data.tss',
                's_t_p__data.ph',
                's_t_p__data.temperature',
                's_t_p__data.h',
                's_t_p__data.i',
                's_t_p__data.updated_at'
            )
            ->get();
        return view('stp.stpdata', ['StpData' => $StpData]);  
    }
  

public function stpReport()
{
    $stps = STP::with('stpData') ->where('user_id', Auth::id()) ->get();
    return view('stp.stp-report', ['stps' => $stps, 'month' => '']);
}
public function stpReportdata(STPReportRequest $request)
{
    $validated = $request->validated();

    $requestedYear = date('Y', strtotime($validated['month']));
    $requestedMonth = date('m', strtotime($validated['month']));
    $tableName = 'stp_year_' . $requestedYear;

    $pumpIds = $validated['stp_id'];
    $report_data = \DB::table('users')
        ->leftJoin('s_t_p_s', 'users.id', '=', 's_t_p_s.user_id')
        ->leftJoin($tableName, 's_t_p_s.id', '=', $tableName . '.stp_id')
        ->whereIn('s_t_p_s.id', $pumpIds)
        ->whereYear($tableName . '.created_at', $requestedYear)
        ->whereMonth($tableName . '.created_at', $requestedMonth)
        ->select(
            's_t_p_s.id',
            's_t_p_s.title',
            's_t_p_s.serial_no',
            'users.profile_pic' ,
            $tableName . '.cod',
            $tableName . '.bod',
            $tableName . '.toc',
            $tableName . '.tss',
            $tableName . '.ph',
            $tableName . '.temperature',
            $tableName . '.i',
            $tableName . '.h',
            $tableName . '.created_at'
        )
        ->orderBy($tableName . '.created_at', 'asc')
        ->get();

    return redirect()->back()->with('report_data', $report_data)->with('month', $validated['month']);
}
public function stpdailyreport(){
    $stps = STP::with('stpData') ->where('user_id', Auth::id()) ->get();
    return view('stp.stpdailyreport', ['stps' => $stps]);
   
}
public function stpdailyreportdata(dailystpreport $request)
{
    $validated = $request->validated();
    $startDate = Carbon::parse($validated['from'])->startOfDay();
    $endDate = Carbon::parse($validated['to'])->endOfDay();
    $requestedStartYear = $startDate->year;
    $requestedEndYear = $endDate->year;
    $reportData = collect(); 
    session(['from_date' => $startDate->format('Y-m-d'), 'to_date' => $endDate->format('Y-m-d')]);

    for ($year = $requestedStartYear; $year <= $requestedEndYear; $year++) {
        $tableName = 'stp_year_' . $year;
        if (Schema::hasTable($tableName)) {
            $yearlyData = DB::table('users')
                ->leftJoin('s_t_p_s', 'users.id', '=', 's_t_p_s.user_id')
                ->leftJoin($tableName, 's_t_p_s.id', '=', $tableName . '.stp_id')
                ->whereIn('s_t_p_s.id', $validated['stp_id'])
                ->whereBetween($tableName . '.created_at', [$startDate, $endDate])
                ->select(
                    's_t_p_s.id',
                    's_t_p_s.title',
                    's_t_p_s.serial_no',
                    'users.profile_pic',
                    $tableName . '.cod',
                    $tableName . '.bod',
                    $tableName . '.toc',
                    $tableName . '.tss',
                    $tableName . '.ph',
                    $tableName . '.temperature',
                    $tableName . '.i as tds',
                    $tableName . '.h as ec',
                    $tableName . '.created_at'
                )
                ->orderBy($tableName . '.created_at', 'asc')
                ->get();
            $reportData = $reportData->merge($yearlyData);
        }
    }
    if ($reportData->isEmpty()) {
        return redirect()->back()->withErrors(['month' => 'No report data found for the selected date range.']);
    }

    return redirect()->back()->with(['report_data' => $reportData, 'month' => $requestedStartYear, 'stps' => STP::all()]);
}

public function annualstpreport(){
    $stps = STP::with('stpData') ->where('user_id', Auth::id()) ->get();
    return view('stp.annualstpreport', ['stps' => $stps]);
}

public function annualstpreportdata(annualstpreport $request)
{
    $validated = $request->validated();
    $requestedYear = $validated['year'];
    $tableName = 'stp_year_' . $requestedYear;
    $pumpIds = $validated['stp_id'];
    session(['year' => $request->year]);
    $report_data = DB::table('users')
        ->leftJoin('s_t_p_s', 'users.id', '=', 's_t_p_s.user_id')
        ->leftJoin($tableName, 's_t_p_s.id', '=', $tableName . '.stp_id')
        ->whereIn('s_t_p_s.id', $pumpIds)
        ->whereYear($tableName . '.created_at', $requestedYear)
        ->select(
            's_t_p_s.id',
            's_t_p_s.title',
            's_t_p_s.serial_no',
            'users.profile_pic',
            $tableName . '.cod',
            $tableName . '.bod',
            $tableName . '.toc',
            $tableName . '.tss',
            $tableName . '.ph',
            $tableName . '.temperature',
            $tableName . '.i',
            $tableName . '.h',
            $tableName . '.created_at'
        )
        ->orderBy($tableName . '.created_at', 'asc')
        ->get();

    $stps = STP::all();
    return view('stp.annualstpreport', compact('report_data', 'stps'));
}

}
