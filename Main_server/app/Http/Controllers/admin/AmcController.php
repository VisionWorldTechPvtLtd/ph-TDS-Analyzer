<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Pump;
use App\Models\PumpData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AmcController extends Controller
{
    public function amc(){
        $panel_lock = 1;
        $users = User::with('pumps')->get();
        $allPumps = Pump::where('user_id', Auth::user()->id)
                        ->where('panel_lock', $panel_lock)
                        ->get();
        $AMCPumps = Pump::select('pumps.id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'pumps.panel_lock', 'pumps.created_at')
                        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
                        ->where('pumps.panel_lock', $panel_lock)
                        ->get();
        return view('admin.amc.amc', ['allPumps' => $allPumps, 'allPumpsPlanExpires' => $AMCPumps, 'user' => $users]);
    }

    public function cmc(){
        $external = 1;
        $users = User::with('pumps')->get();
        $allPumps = Pump::where('user_id', Auth::user()->id)
                        ->where('external', $external)
                        ->get();
        $CMCPumps = Pump::select('pumps.id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'pumps.external', 'pumps.created_at')
                        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
                        ->where('pumps.external', $external)
                        ->get();
        return view('admin.amc.cmc', ['allPumps' => $allPumps, 'allPumpsPlanExpires' => $CMCPumps, 'user' => $users]);

    }
    public function nothing(){
        $external = 0;
        $panel_lock = 0;
        $users = User::with('pumps')->get();
        $allPumps = Pump::where('user_id', Auth::user()->id)
                        ->where('external', $external)
                        ->where('panel_lock', $panel_lock)
                        ->get();
        $CMCPumps = Pump::select('pumps.id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'pumps.external', 'pumps.panel_lock', 'pumps.created_at')
                        ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
                        ->where('pumps.external', $external)
                        ->where('pumps.panel_lock', $panel_lock)
                        ->get();
        return view('admin.amc.nothing', [ 'allPumps' => $allPumps,'allPumpsPlanExpires' => $CMCPumps,'user' => $users]);
    }

}
