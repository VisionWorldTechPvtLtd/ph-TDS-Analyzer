<?php

namespace App\Console\Commands;

use App\Models\PumpData;
use App\Models\PumpMorningData;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pump;
use Mail;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Email;
class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to all users by vision world tech ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::with('pumps')->get();
        foreach ($users as $user) {
            $userMail = $user->email;
            $pumps = $user->pumps;
            $status = $user->status;

            // Skip inactive users
            if ($status == 0) {
                continue;
            }

            $pumpsData = [];
            $sendEmail = true;
            foreach ($pumps as $pump) {
                $pumpId = $pump->id;
                $planEndDate = $pump->plan_end_date;
                if ($planEndDate === null || $planEndDate->isPast() || $planEndDate->isToday()) {
                    $sendEmail = false;
                    break;
                }
                // Calculate today's flow if plan is in the future
                $morningFlow = PumpMorningData::where('pump_id', $pumpId)
                    ->latest('created_at')
                    ->value('forward_flow');
                $pumpData = PumpData::where('pump_id', $pumpId)
                    ->latest('created_at')
                    ->value('forward_flow');

                if ($morningFlow !== null && $pumpData !== null) {
                    $todayFlow = $pumpData - $morningFlow;
                    $pumpsData[] = [
                        'first_name' => $user->first_name,
                        'pump_title' => $pump->pump_title,
                        'address' => $user->address,
                        'today_flow' => $todayFlow,
                    ];
                } else {

                }
            }
            if ($sendEmail && !empty($pumpsData)) {
                $data = [
                    'pumps' => $pumpsData,
                ];
                Mail::send('admin.email', $data, function ($message) use ($userMail) {
                    $message->to($userMail)->subject('Daily Borewell Report');
                });
            } else {

            }
        }

        return 0;
    }


}





