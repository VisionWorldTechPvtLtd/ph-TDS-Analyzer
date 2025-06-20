<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Pump;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PoPAlert extends Component
{
    public $allPumpsPlanExpires11Months;
    public $allPumpsPlanExpires12Months;

    // public function __construct()
    // {
    //     $currentDate = Carbon::now();
    //     $thirtyDaysFromNow = $currentDate->copy()->addDays(30);
    //     $twelveMonthsAgo = Carbon::now()->subMonths(12);
    //     $this->allPumpsPlanExpires11Months = Pump::select('pumps.id','users.first_name','users.last_name', 'users.id as user_id','users.company','users.contact_no', 'pumps.plan_end_date','pumps.plan_start_date')
    //         ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
    //         ->where('pumps.plan_end_date', '<=', $thirtyDaysFromNow)
    //         ->get();
    //     $this->allPumpsPlanExpires12Months = Pump::select('pumps.id','users.first_name','users.last_name','users.id as user_id','users.company','users.contact_no','pumps.plan_end_date','pumps.plan_start_date')
    //         ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
    //         ->where('pumps.plan_end_date', '<=', $twelveMonthsAgo->format('Y-m-d'))
    //         ->where('pumps.plan_end_date', '>', $thirtyDaysFromNow)
    //         ->get();
    // }
    public function __construct()
    {
        $userId = Auth::id();
        $currentDate = Carbon::now();
        $thirtyDaysFromNow = $currentDate->copy()->addDays(30);
        $twelveMonthsAgo = Carbon::now()->subMonths(12);

        $this->allPumpsPlanExpires11Months = Pump::select('pumps.id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'pumps.plan_end_date', 'pumps.plan_start_date', 'pumps.pump_title', 'pumps.last_calibration_date', 'pumps.serial_no')
            ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
            ->where('pumps.user_id', $userId)
            ->whereDate('pumps.plan_end_date', '<=', $thirtyDaysFromNow->format('Y-m-d'))
            ->get();

        $this->allPumpsPlanExpires12Months = Pump::select(
            'pumps.id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'users.company', 'users.contact_no', 'pumps.plan_end_date', 'pumps.plan_start_date' )
            ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
            ->where('pumps.user_id', $userId) 
            ->where('pumps.plan_end_date', '<=', $currentDate->format('Y-m-d'))
            ->where('pumps.plan_end_date', '>', $twelveMonthsAgo->format('Y-m-d'))
            ->get();

        $this->calculateRemainingDays($this->allPumpsPlanExpires11Months, $currentDate);
        $this->calculateRemainingDays($this->allPumpsPlanExpires12Months, $currentDate);
    }

    protected function calculateRemainingDays($pumps, $currentDate)
    {
        foreach ($pumps as $pump) {
            $planEndDate = Carbon::parse($pump->plan_end_date);
            $pump->remaining_days = $currentDate->diffInDays($planEndDate);
        }
    }

    public function render()
    {
        return view('components.pop-alert');
    }

}
