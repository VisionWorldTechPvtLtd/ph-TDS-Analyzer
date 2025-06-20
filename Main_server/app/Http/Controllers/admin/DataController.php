<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PumpData;
use App\Models\PumpHistoryData;
use App\Models\STP_Data;
use App\Models\STP;
use App\Models\STP_History_Data;
use App\Models\Pump;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DataController extends Controller
{

    public function __construct()
    {

        DB::statement("SET time_zone = 'Asia/Kolkata';");
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

        $this->stpData = DB::table('s_t_p__data')->leftJoin('s_t_p_s', 's_t_p__data.stp_id', '=', 's_t_p_s.id')->leftJoin('users', 's_t_p_s.user_id', '=', 'users.id')->select(
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
            's_t_p__data.updated_at',
            'users.first_name',
            'users.last_name'

        )->get();
    }

    public function pumpData(){
        // dd($this->pumpData);
        return view('admin.pump-data', ['pumpData' => $this->pumpData]);
    }

    public function stpData(){

        return view('admin.stp-data', ['stpData' => $this->stpData]);
    }

    public function insertPumpData(Request $request){

        $data = [];
        $data['ID'] =  $request->get('ID');
        $data['CF'] =   $request->get('CF');
        $data['FF'] =   $request->get('FF');
        $data['RF'] =   $request->get('RF');
        $data['GWL'] =   $request->get('GWL');

        //return $data;
        DB::statement("SET time_zone = 'Asia/Kolkata';");
        $pumpData = PumpData::where('pump_id', $data['ID'])->first();

        $pumpData->forward_flow = $data['FF'];
        $pumpData->reverse_flow = $data['RF'];
        $pumpData->current_flow = $data['CF'];
        $pumpData->ground_water_level = $data['GWL'];
        $pumpData->created_at =now();
        $pumpData->updated_at = now();
  
        $pumpData->update();


        $pumpHistoryData = new PumpHistoryData();

        $pumpHistoryData->pump_id = $data['ID'];
        $pumpHistoryData->forward_flow = $data['FF'];
        $pumpHistoryData->reverse_flow = $data['RF'];
        $pumpHistoryData->current_flow = $data['CF'];
        $pumpHistoryData->ground_water_level = $data['GWL'];
        $pumpHistoryData->created_at =now();
        $pumpHistoryData->updated_at = now();
        DB::statement("SET time_zone = 'Asia/Kolkata';");
        $pumpHistoryData->save();

        //  return 89;
        return $this->unitData($data['ID']);
        
    }

    protected function unitData($id){
        try {
            $data = Pump::where('id', $id)->first();
            $returnString = '';
            $returnString .= $data->auto_manual;
            $returnString .= $data->live_data;
            $returnString .= ",";
    
            $zero = 0;
            $num = $data->flow_limit;
            $str_arr = explode('.', $num);
            $numlength = strlen((string) $str_arr[0]);
           
    
            if ($numlength == 1) {
                if ($num > 0 && $num < 1) {
                    $returnString .= $zero;
                }
                $returnString .= $zero . $zero . ($num * 1000);
            } elseif ($numlength == 2) {
                // $returnString .= $zero . ($num * 1000);
                $returnString .= $zero . ((float)$num * 1000);

            } else {
                $returnString .= ($num * 1000);
            }
    
            $returnString .= ",";
            $returnString .= str_pad(date("d"), 2, "0", STR_PAD_LEFT) . "-";
            $returnString .= str_pad(date("H"), 2, "0", STR_PAD_LEFT) . "-";
            $returnString .= str_pad(date("i"), 2, "0", STR_PAD_LEFT) . ",";
            
            return $returnString;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // public function insertSTPData(Request $request){

    //     $data = [];
    //     $data['A'] =   $request->get('A');
    //     $data['B'] =   $request->get('B');
    //     $data['C'] =   $request->get('C');
    //     $data['D'] =   $request->get('D');
    //     $data['E'] =   $request->get('E');
    //     $data['F'] =   $request->get('F');
    //     $data['G'] =   $request->get('G');
    //     $data['H'] =   $request->get('H');
    //     $data['I'] =   $request->get('I');



    //     $stpData = STP_Data::where('stp_id', $data['A'])->first();
      
    //     $stpData->cod = $data['B'];
    //     $stpData->bod = $data['C'];
    //     $stpData->toc = $data['D'];
    //     $stpData->tss = $data['E'];
    //     $stpData->ph = $data['F'];
    //     $stpData->temperature = $data['G'];
    //     $stpData->h = $data['H'];
    //     $stpData->i = $data['I'];
    //     $stpData->created_at = now();
    //     $stpData->updated_at = now();

    //     $stpData->update();


    //     $stpHistoryData = new STP_History_Data();

    //     $stpHistoryData->stp_id = $data['A'];
    //     $stpHistoryData->cod = $data['B'];
    //     $stpHistoryData->bod = $data['C'];
    //     $stpHistoryData->toc = $data['D'];
    //     $stpHistoryData->tss = $data['E'];
    //     $stpHistoryData->ph = $data['F'];
    //     $stpHistoryData->temperature = $data['G'];
    //     $stpHistoryData->h = $data['H'];
    //     $stpHistoryData->i = $data['I'];
    //     $stpHistoryData->created_at = now();
    //     $stpHistoryData->updated_at = now();
    //     $stpHistoryData->save();

    //     return 1;
    // }
    public function insertSTPData(Request $request){

        $data = [];
        $data['A'] =   $request->get('A');
        $data['B'] =   $request->get('B');
        $data['C'] =   $request->get('C');
        $data['D'] =   $request->get('D');
        $data['E'] =   $request->get('E');
        $data['F'] =   $request->get('F');
        $data['G'] =   $request->get('G');
        $data['H'] =   $request->get('H');
        $data['I'] =   $request->get('I');
        $data['user_key'] =   $request->get('user_key');


        $stp = STP::where('user_key', $data['user_key'])->first();
        if (!$stp) {
            return response()->json(['error' => ' User key mismatch'], 404);
        }
        $stpData = STP_Data::where('stp_id', $data['A'])->first();

        if (!$stpData) {
            return response()->json(['error' => 'STP Data not found'], 404);
        }
        $stpData->cod = $data['B'];
        $stpData->bod = $data['C'];
        $stpData->toc = $data['D'];
        $stpData->tss = $data['E'];
        $stpData->ph = $data['F'];
        $stpData->temperature = $data['G'];
        $stpData->h = $data['H'];
        $stpData->i = $data['I'];
        $stpData->created_at = now();
        $stpData->updated_at = now();

        $stpData->update();


        $stpHistoryData = new STP_History_Data();

        $stpHistoryData->stp_id = $data['A'];
        $stpHistoryData->cod = $data['B'];
        $stpHistoryData->bod = $data['C'];
        $stpHistoryData->toc = $data['D'];
        $stpHistoryData->tss = $data['E'];
        $stpHistoryData->ph = $data['F'];
        $stpHistoryData->temperature = $data['G'];
        $stpHistoryData->h = $data['H'];
        $stpHistoryData->i = $data['I'];
        $stpHistoryData->created_at = now();
        $stpHistoryData->updated_at = now();
        $stpHistoryData->save();

        return 1;
    }

    

    public function showPumpDataLive(){
        return  $this->pumpData;
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

    return view('admin.offline', compact('pumpData'));
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
        Mail::send('admin.offlineemail', [
            'user' => $user,
            'offlinePumps' => $offlinePumps,
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->cc('vwtplcgwa@gmail.com') 
                    ->subject('Borewell Offline Alert');
        });

        return back()->with('success', 'Offline email sent to ' . $user->email);
    }

    return back()->with('warning', 'No offline pumps found for this user today.');
}



}
