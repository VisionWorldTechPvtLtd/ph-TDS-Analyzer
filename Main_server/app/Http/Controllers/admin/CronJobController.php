<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PumpDailyFlowData;
use App\Models\PumpEveningData;
use App\Models\PumpMorningData;
use App\Models\PumpData;
use App\Models\Pump;
use App\Models\PumpDailyFlowTempData;
use App\Models\STP;
use App\Models\STP_Data;
use App\Models\StpDailydata;
use App\Models\PumpHistoryData;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use App\Models\User;
use Mail;
use PharIo\Manifest\Email;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Schema\Blueprint;
use App\Models\overflow;

class CronJobController extends Controller
{

    public function pumpMorningFlow()
    {
        $currentYear = date('Y');
        $tableName = 'year_' . $currentYear;
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pump_id');
                $table->foreign('pump_id')->references('id')->on('pumps')->onDelete('cascade');
                $table->float('forward_flow')->default(0);
                $table->float('reverse_flow')->default(0);
                $table->float('ground_water_level')->default(0);
                $table->float('totalizer')->default(0);
                $table->timestamps();
            });

            echo "Table $tableName created successfully for the year $currentYear.";
        } else {
            echo "Table $tableName already exists for the year $currentYear.";
        }

        $currentData = PumpData::all();

        foreach ($currentData as $data) {

            $morningData = new PumpMorningData();
            $morningData->pump_id = $data->pump_id;
            $morningData->forward_flow = $data->forward_flow;
            $morningData->reverse_flow = $data->reverse_flow;
            $morningData->ground_water_level = $data->ground_water_level;
            $morningData->save();
        }
        

        return true;
    }

    public function datatable()
    {
        
            $currentYear = date('Y');
            $tableName = 'stp_year_' . $currentYear;
            if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stp_id')->comment('A');
            $table->foreign('stp_id')->references('stp_id')->on('s_t_p__data')->onDelete('cascade');
            $table->float('cod')->default(0)->comment('B');
            $table->float('bod')->default(0)->comment('C');
            $table->float('toc')->default(0)->comment('D');
            $table->float('tss')->default(0)->comment('E');
            $table->float('ph')->default(0)->comment('F');
            $table->float('temperature')->default(0)->comment('G');
            $table->string('h')->default(0)->comment('H');
            $table->string('i')->default(0)->comment('I');
            $table->timestamps();
                });
    
                echo "Table $tableName created successfully for the year $currentYear.";
            } else {
                echo "Table $tableName already exists for the year $currentYear.";
            }
    }
    public function dailydata()
    {

        $currentYear = date('Y');
       $tableName = 'stp_year_' . $currentYear;
       $stps = STP::all(); 
        $insertData = [];
        foreach ($stps as $stp) {
            $stp_data = STP_Data::where('stp_id', $stp->id)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
    
            $insertData[] = [
                "stp_id" => $stp->id,
                "cod" => $stp_data->cod ?? 0,
                "bod" => $stp_data->bod ?? 0,
                "toc" => $stp_data->toc ?? 0,
                "tss" => $stp_data->tss ?? 0,
                "ph" => $stp_data->ph ?? 0,
                "temperature" => $stp_data->temperature ?? 0,
                "h" => $stp_data->h ?? 0,
                "i" => $stp_data->i ?? 0,
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }
        DB::table($tableName)->insert($insertData);
    
        return response()->json([
            'success' => true,
            'message' => 'Data inserted successfully.',
        ]);
    }

   

    public function pumpEveningFlow()
    {
        $current_data = PumpData::all();
        foreach ($current_data as $data) {

            $evening_data = new PumpEveningData();
            $evening_data->pump_id = $data->pump_id;
            $evening_data->forward_flow = $data->forward_flow;
            $evening_data->reverse_flow = $data->reverse_flow;
            $evening_data->ground_water_level = $data->ground_water_level;
            $evening_data->created_at = now();
            $evening_data->updated_at = now(); 
            $evening_data->save();
        }

        return true;
    }

   

    public function pumpDailyFlow()
    {

        $pumps = Pump::all();
        $currentYear = date('Y');
        $tableName = 'year_' . $currentYear;

        foreach ($pumps as $pump) {

            $morning_data = PumpMorningData::where('pump_id', $pump->id)->whereDate('created_at', date("Y-m-d"))->first();
            $evening_data = PumpEveningData::where('pump_id', $pump->id)->whereDate('created_at', date("Y-m-d"))->first();

            if (!empty($morning_data) && !empty($evening_data)) {

                $row = [
                    "pump_id" => $pump->id,
                    "forward_flow" => $evening_data->forward_flow - $morning_data->forward_flow,
                    "reverse_flow" => $evening_data->reverse_flow,
                    "ground_water_level" => $evening_data->ground_water_level,
                    "totalizer"=>$evening_data->forward_flow,
                    "created_at" => now()
                ];

                DB::table($tableName)->insert($row);

            } else {

                $row = [
                    "pump_id" => $pump->id,
                    "forward_flow" => 0,
                    "reverse_flow" => 0,
                    "ground_water_level" => 0,
                    "totalizer" => 0,
                    "created_at" => now()
                ];

                DB::table($tableName)->insert($row);
            }

        }


        return true;
    }
 
  
    public function email()
    {
        $users = User::with('pumps')->get();
    
        foreach ($users as $user) {
            $userMail = $user->email;
            $ccMails = $user->cc_email;
            $status = $user->status;
            $userFlowLimit = $user->user_flow_limit;
    
            if ($status == 0) {
                continue; // Skip inactive users
            }
    
            $pumpsData = [];
            $sendEmail = true;
            $totalFlow = 0;
            $flowLimitPercentage = 0;
    
            foreach ($user->pumps as $pump) {
                $pumpId = $pump->id;
                $planEndDate = $pump->plan_end_date;
    
                // Skip pump if plan is not valid
                if ($planEndDate === null || $planEndDate->isPast() || $planEndDate->isToday()) {
                    $sendEmail = false;
                    break;
                }
    
                $morningFlow = PumpMorningData::where('pump_id', $pumpId)->latest('created_at')->value('forward_flow');
                $latestPumpData = PumpData::where('pump_id', $pumpId)->latest('created_at')->first();
    
                if ($morningFlow === null || $latestPumpData === null) {
                    continue;
                }
    
                $pumpData = $latestPumpData->forward_flow;
                $groundWaterLevel = $latestPumpData->ground_water_level;
                $todayFlow = $pumpData - $morningFlow;
                $totalFlow += $todayFlow;
    
                $flowStatus = $latestPumpData->created_at->isToday() ? 'online' : 'offline';
    
                $pumpsData[] = [
                    'company' => $user->company,
                    'pump_title' => $pump->pump_title,
                    'address' => $user->address,
                    'today_flow' => $todayFlow,
                    'ground_water_level' => $groundWaterLevel,
                    'flow_status' => $flowStatus,
                ];
            }
    
            if ($userFlowLimit > 0) {
                $flowLimitPercentage = ($totalFlow / $userFlowLimit) * 100;
            }
    
            if ($sendEmail && !empty($pumpsData)) {
                $data = [
                    'pumps' => $pumpsData,
                    'flowLimitPercentage' => $flowLimitPercentage,
                    'totalFlow' => $totalFlow,
                ];
    
                try {
                    Mail::send('admin.email', $data, function ($message) use ($userMail, $ccMails) {
                        $message->to($userMail)->subject('Daily Borewell Report');
    
                        if (!empty($ccMails)) {
                            $ccEmailsArray = array_map('trim', explode(',', $ccMails));
                            $message->cc($ccEmailsArray);
                        }
                    });
                } catch (\Exception $e) {
                    \Log::error('Email sending failed: ' . $e->getMessage());
                }
            }
        }
    
        return true;
    }


    public function todayflow()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $pumps = Pump::all();
    
        foreach ($pumps as $pump) {
            $pumpId = $pump->id;
            Pump::where('id', $pumpId)
                ->whereDate('updated_at', $yesterday)
                ->update(['today_flow' => 0]);
            $morningFlow = PumpMorningData::where('pump_id', $pumpId)
                ->whereDate('created_at', $today)
                ->latest('created_at')
                ->value('forward_flow') ?? 0;
            $pumpData = PumpData::where('pump_id', $pumpId)
                ->whereDate('created_at', $today)
                ->latest('created_at')
                ->value('forward_flow') ?? 0;
            if ($morningFlow > 0 && $pumpData > 0) {
                $todayflow = $pumpData - $morningFlow;
    
                Pump::where('id', $pumpId)->update([
                    'today_flow' => $todayflow
                ]);
            }
        }
    
        return "Flow data has been updated: yesterday's flow set to 0, and today's flow updated for all pumps.";
    }


    public function planemail()
    {
        $users = User::with('pumps')->get();
    
        foreach ($users as $user) {
            $userMail = $user->email;
            $ccEmail = 'vwtplcgwa@gmail.com'; 
            $pumps = $user->pumps;
    
            foreach ($pumps as $pump) {
                $planEndDate = $pump->plan_end_date;
    
                if ($planEndDate && $planEndDate->isFuture()) {
                    $daysLeft = $planEndDate->diffInDays(now());
                    if ($daysLeft > 0 && $daysLeft <= 30) {
                        $data = [
                            'user' => $user,
                            'pump' => $pump,
                        ];
    
                        Mail::send('admin.planemail', $data, function ($message) use ($userMail,$ccEmail) {
                            $message->to($userMail)
                                   ->cc($ccEmail) 
                                    ->subject('Your Plan is Expiring Soon');
                        });
                    }
                }
            }
        }
    
        return 1;
    }

//     public function allplanend()
// {
//     $users = User::with('pumps')->get();
//     $userMail = 'admin@visionworldtech.com'; 
//     $ccEmail =  'vachan@visionworldtech.com '; 
  
//     $expiringPlans = [];

//     // Collect all expiring plans
//     foreach ($users as $user) {
//         foreach ($user->pumps as $pump) {
//             $planEndDate = Carbon::parse($pump->plan_end_date);
//             if ($planEndDate->isFuture()) {
//                 $daysLeft = now()->diffInDays($planEndDate);
//                 if ($daysLeft > 0 && $daysLeft <= 30) {
//                     $expiringPlans[] = [
//                         'user_name' => $user->first_name . ' ' . $user->last_name,
//                         'company' => $user->company,
//                         'plan_end_date' => $planEndDate->format('F d, Y'),
//                     ];
//                 }
//             }
//         }
//     }

//     if (!empty($expiringPlans)) {
//         try {
//             Mail::send('admin.allplanend', ['expiringPlans' => $expiringPlans], function ($message) use ($ccEmail, $userMail) {
//                 $message->to($userMail)
//                         ->cc($ccEmail)
//                         ->subject('This Month Plan Expirations');
//             });
//         } catch (\Exception $e) {
//         }
//     }

//     return 1;
// }
public function allplanend()
{
    $users = User::with('pumps')->get();
     $userMail = 'admin@visionworldtech.com'; 
     $ccEmail =  'vachan@visionworldtech.com '; 
  
    $expiringPlans = [];

    foreach ($users as $user) {
        foreach ($user->pumps as $pump) {
            if (!$pump->plan_end_date) continue;
            $planEndDate = Carbon::parse($pump->plan_end_date);
            $daysLeft = now()->diffInDays($planEndDate, false); 
            if ($planEndDate->isPast() || ($planEndDate->isFuture() && $daysLeft <= 30)) {
                $expiringPlans[] = [
                    'user_name' => $user->first_name . ' ' . $user->last_name,
                    'company' => $user->company,
                    'plan_end_date' => $planEndDate->format('F d, Y'),
                ];
            }
        }
    }
    if (!empty($expiringPlans)) {
        try {
            Mail::send('admin.allplanend', ['expiringPlans' => $expiringPlans], function ($message) use ($ccEmail, $userMail) {
                $message->to($userMail)
                        ->cc($ccEmail)
                        ->subject('Plans Expired or Expiring Soon');
            });
        } catch (\Exception $e) {
            \Log::error('Plan expiry email failed: ' . $e->getMessage());
        }
    }
    return 1;
}



 public function dailyhistorydatadelete(){
            try{
                PumpHistoryData::whereDate( 'created_at', '<=', now()->subDays(3))->delete();
            }catch(Exception $e){
                Log::error('Daily Totalizer before 3 days data delete error : '. $e->getMessage().' : Line No. '.$e->getLine());
            }
        }

public function overflow(){
       $users = User::with('pumps')->get();
       foreach ($users as $user) {
        $userId = $user->id;
        $userFlowLimit = $user->user_flow_limit ?? 0;

        $totalFlow = 0;
        foreach ($user->pumps as $pump) {
            $pumpId = $pump->id;

            $morningFlow = PumpMorningData::where('pump_id', $pumpId)
                ->latest('created_at')
                ->value('forward_flow') ?? 0;

            $pumpFlow = PumpData::where('pump_id', $pumpId)
                ->latest('created_at')
                ->value('forward_flow') ?? 0;

            $todayFlow = $pumpFlow - $morningFlow;
            $totalFlow += $todayFlow;
        }
        if ($totalFlow > $userFlowLimit) {
            $overflowAmount = $totalFlow - $userFlowLimit;

            DB::table('overflows')->insert([
                'user_id'     => $userId,
                'user_limit'  => $userFlowLimit,
                'today_flow'  => $totalFlow,
                'overflow'    => $overflowAmount,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    return response()->json(['message' => 'Overflow data inserted where applicable.']);
}  

 
}
