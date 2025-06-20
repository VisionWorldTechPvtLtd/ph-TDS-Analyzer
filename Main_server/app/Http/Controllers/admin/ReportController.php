<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Http\Requests\SinglePumpReportRequest;
use App\Http\Requests\STPReportRequest;
use App\Http\Requests\UpdateReportDataRequest;
use App\Http\Requests\overflowRequestdata;
use App\Http\Requests\negativeReportdata;
use App\Http\Requests\garbageDataRequest;
use App\Models\Pump;
use App\Models\PumpDailyFlowData;
use App\Models\STP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ReportController extends Controller
{

    public function __construct()
    {
        $this->customers = User::with(['pumps'])->get();
        $this->pumps = Pump::with(['user'])->get();
        $this->stps = STP::with(['user'])->get();
    }

    public function pumpReportIndex(){
        return view('admin.pump-report', ['customers' => $this->customers, 'pumps' => $this->pumps]);
    }

    public function pumpReportdata(SinglePumpReportRequest $request){
        $validated_data = $request->validated();
        //return $validated_data;
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

    public function stpReportIndex(){
        return view('admin.stp-report', ['customers' => $this->customers, 'stps' => $this->stps]);
    }

    // public function stpReportdata(STPReportRequest $request){
    //     $validated_data = $request->validated();
    //     $report_data = DB::table('users')
    //                 ->leftJoin('s_t_p_s', 'users.id', '=', 's_t_p_s.user_id')
    //                 ->leftJoin('s_t_p__history__data', 's_t_p_s.id', '=', 's_t_p__history__data.stp_id')
    //                 ->whereDate('s_t_p__history__data.created_at', '>=', date('Y-m-d', strtotime($validated_data['from'])))
    //                 ->whereYear('s_t_p__history__data.created_at', '<=', date('Y-m-d', strtotime($validated_data['to'])))
    //                 ->select(
    //                     'users.first_name',
    //                     'users.last_name',
    //                     's_t_p_s.id',
    //                     's_t_p_s.title',
    //                     's_t_p_s.serial_no',
    //                     's_t_p__history__data.cod',
    //                     's_t_p__history__data.bod',
    //                     's_t_p__history__data.toc',
    //                     's_t_p__history__data.tss',
    //                     's_t_p__history__data.ph',
    //                     's_t_p__history__data.temperature',
    //                     's_t_p__history__data.i',
    //                     's_t_p__history__data.h',
    //                     's_t_p__history__data.created_at'
    //                     )
    //                 ->get();
    //     return redirect()->back()->with([ 'report_data' => $report_data]);
    // }
    public function stpReportdata(STPReportRequest $request)
{
    $validated_data = $request->validated();

    $startDate = Carbon::parse($validated_data['from'])->startOfDay();
    $endDate = Carbon::parse($validated_data['to'])->endOfDay();

    $requestedStartYear = $startDate->year;
    $requestedEndYear = $endDate->year;

    $reportData = collect();

    session([
        'from_date' => $startDate->format('Y-m-d'),
        'to_date' => $endDate->format('Y-m-d')
    ]);

    for ($year = $requestedStartYear; $year <= $requestedEndYear; $year++) {
        $tableName = 'stp_year_' . $year;

        if (!Schema::hasTable($tableName)) {
            continue; // skip if table does not exist
        }

        $data = DB::table('users')
            ->leftJoin('s_t_p_s', 'users.id', '=', 's_t_p_s.user_id')
            ->leftJoin($tableName, 's_t_p_s.id', '=', "{$tableName}.stp_id")
            ->whereDate("{$tableName}.created_at", '>=', $startDate)
            ->whereDate("{$tableName}.created_at", '<=', $endDate)
            ->select(
                'users.first_name',
                'users.last_name',
                's_t_p_s.id',
                's_t_p_s.title',
                's_t_p_s.serial_no',
                "{$tableName}.cod",
                "{$tableName}.bod",
                "{$tableName}.toc",
                "{$tableName}.tss",
                "{$tableName}.ph",
                "{$tableName}.temperature",
                "{$tableName}.i",
                "{$tableName}.h",
                "{$tableName}.created_at"
            )
            ->get();

        $reportData = $reportData->merge($data);
    }

    return redirect()->back()->with(['report_data' => $reportData]);
}
  
    public function editReportData($pump_id)
    {
        $report_data = PumpDailyFlowData::findOrFail($pump_id);
        $startDate = isset($report_data->created_at) ? Carbon::parse($report_data->created_at)->startOfMonth() : Carbon::now()->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $monthlyData = PumpDailyFlowData::where('pump_id', $report_data->pump_id)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->get();
        return view('admin.edit-report-data', compact('report_data', 'monthlyData', 'startDate', 'endDate','pump_id'));
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
    
        return redirect()->route('reports.data.edit', $pumpId)->with('success', 'Report data updated successfully!');
    }

    public function negative(){
        return view('admin.negative');
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

    public function overflow()
{
   return view('admin.overflow');
} 

public function overflowReportData(OverflowRequestData $request)
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
 public function garbage(){
    return view('admin.garbage');
 }


 public function garbageData(garbageDataRequest $request)
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
    ->where(DB::raw("{$tableName}.forward_flow > 999 OR {$tableName}.reverse_flow < 0 OR {$tableName}.ground_water_level < 0 OR {$tableName}.totalizer < 0"))
    
    ->select( 'users.company','pumps.id as pump_id', $tableName . '.id as pdfd_id', $tableName . '.forward_flow',$tableName . '.reverse_flow',$tableName . '.ground_water_level',$tableName . '.totalizer', $tableName . '.created_at')
    ->orderBy($tableName . '.created_at', 'asc')
    ->get();
    return redirect()->back()->with(['report_data' => $report_data,'month' => $validated_data['month']]);
    }


}
