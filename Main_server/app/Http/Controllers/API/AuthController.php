<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\PumpData;
use App\Models\Pump;
use App\Models\PumpMorningData;
use App\Models\alert;
use App\Models\product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('client-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }



    public function data(Request $request): JsonResponse
    {
        $user_id = $request->input('user_id', Auth::id());
    
        $pumpData = Pump::leftJoin('pump_data', 'pumps.id', '=', 'pump_data.pump_id')
            ->leftJoin('pump_morning_data', function ($join) {
                $join->on('pumps.id', '=', 'pump_morning_data.pump_id')
                    ->whereDate('pump_morning_data.created_at', '=', date('Y-m-d'));
            })
            ->where('pumps.user_id', $user_id)
            ->where('pumps.piezometer', 0)
            ->select(
                'pumps.id',
                'pumps.serial_no',
                'pumps.pump_title',
                'pumps.plan_status',
                'pump_data.forward_flow',
                'pump_morning_data.forward_flow as morning_flow',
                'pump_data.reverse_flow',
                'pump_data.current_flow',
                'pump_data.ground_water_level',
                'pump_data.updated_at'
            )
            ->get();
    
        $piezometerData = Pump::leftJoin('pump_data', 'pumps.id', '=', 'pump_data.pump_id')
            ->where('pumps.user_id', $user_id)
            ->where('pumps.piezometer', 1)
            ->select(
                'pumps.id',
                'pumps.serial_no',
                'pumps.pump_title',
                'pumps.plan_status',
                'pump_data.ground_water_level',
                'pump_data.updated_at'
            )
            ->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully.',
            'data' => [
                'pumpData' => $pumpData,
                'piezometerData' => $piezometerData,
                'piezometer' => $piezometerData->isNotEmpty(),
            ],
        ]);
    }

    public function pumps(Request $request)
    {
        $user_id = $request->input('user_id', Auth::id());
        $user = User::find($user_id);
        $allPumps = Pump::with('plan')
            ->where('user_id', $user_id)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Pumps fetched successfully.',
            'company' => $user->company,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'profile_pic' => $user->profile_pic,
            'data' => $allPumps
        ]);
    }

public function dashboard(Request $request)
{
    try {
        $userId = $request->input('user_id');
        $user = User::find($userId);
        $userFlowLimit = $user->user_flow_limit;
        $currentDate = Carbon::now();
        $elevenMonthsLater = $currentDate->copy()->addDays(30);
        $allPumps = Pump::where('user_id', $userId)->get();
        $allPumpsPlanExpires11Months = Pump::select(
                'pumps.id',
                'users.id as user_id',
                'users.company',
                'pumps.plan_end_date',
                'pumps.pump_title',
                'pumps.last_calibration_date',
                'sims.sim_end',
                'sims.sim_number'
            )
            ->leftJoin('users', 'pumps.user_id', '=', 'users.id')
            ->leftJoin('sims', 'pumps.id', '=', 'sims.pump_id')
            ->where('pumps.user_id', $userId)
            ->where(function ($query) use ($elevenMonthsLater) {
                $query->whereDate('pumps.plan_end_date', '<=', $elevenMonthsLater)
                      ->orWhereDate('sims.sim_end', '<=', $elevenMonthsLater);
            })
            ->get();

     $pumps = Pump::with('pumpData')->where('user_id', $userId)->get();
        $pumpCount = $pumps->count();
        $onlineCount = 0;
        $offlineCount = 0;
        $totalFlow = 0;
        $flowLimitPercentage = 0;
        foreach ($pumps as $pump) {
            $hasDataToday = PumpData::where('pump_id', $pump->id)
                ->whereDate('updated_at', Carbon::today())
                ->exists();
            if ($hasDataToday) {
                $onlineCount++;
            } else {
                $offlineCount++;
            }
        }
        $todayFlows = [];
        foreach ($allPumps as $pump) {
            $pumpId = $pump->id;

            $morningFlow = PumpMorningData::where('pump_id', $pumpId)
                ->latest('created_at')
                ->value('forward_flow') ?? 0;
            $pumpFlow = PumpData::where('pump_id', $pumpId)
                ->latest('created_at')
                ->value('forward_flow') ?? 0;
            $todayFlow = $pumpFlow - $morningFlow;
            $todayFlows[$pumpId] = $todayFlow;
            $totalFlow += $todayFlow;
        }

        if ($userFlowLimit > 0) {
            $flowLimitPercentage = ($totalFlow / $userFlowLimit) * 100;
        }
        return response()->json([
            // 'allPumps' => $allPumps,
            'pumps' => $pumps,
            'pumpCount' => $pumpCount,
            'allPumpsPlanExpires11Months' => $allPumpsPlanExpires11Months,
            'onlineCount' => $onlineCount,
            'offlineCount' => $offlineCount,
            'userFlowLimit'   =>$userFlowLimit,
            'flowLimitPercentage' => round($flowLimitPercentage, 2),
        ]);
    } catch (\Exception $e) {
        Log::error('Dashboard error: ' . $e->getMessage());

        return response()->json([
            'error' => 'Internal Server Error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function report(Request $request)
{
    try {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|date_format:Y-m',
            'pump_id' => 'required|exists:pumps,id', 
        ]);

        $userId = $validatedData['user_id'];
        $month = $validatedData['month'];
        $pumpId = $validatedData['pump_id'];

        $requestedYear = date('Y', strtotime($month));
        $requestedMonth = date('m', strtotime($month));
        $tableName = 'year_' . $requestedYear;

        $pump = Pump::where('id', $pumpId)->where('user_id', $userId)->firstOrFail();

        $reportData = DB::table('pumps')
            ->join('users', 'pumps.user_id', '=', 'users.id')
            ->rightJoin($tableName, 'pumps.id', '=', $tableName . '.pump_id')
            ->where('pumps.user_id', $userId)
            ->where('pumps.id', $pumpId)
            ->whereMonth($tableName . '.created_at', '=', $requestedMonth)
            ->whereYear($tableName . '.created_at', '=', $requestedYear)
            ->select(
                'pumps.id',
                'pumps.pump_title',
                'pumps.serial_no',
                'users.profile_pic',
                'users.company',
                $tableName . '.forward_flow',
                $tableName . '.reverse_flow',
                $tableName . '.ground_water_level',
                $tableName . '.created_at',
                $tableName . '.totalizer'
            )
            ->orderBy($tableName . '.created_at', 'asc')
            ->get();

        return response()->json([
            'pump_id' => $pumpId,
            'reportData' => $reportData,
        ]);
    } catch (\Illuminate\Validation\ValidationException $ve) {
        return response()->json(['errors' => $ve->errors()], 422);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Internal Server Error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function account(Request $request)
{
    $user_id = $request->input('user_id', Auth::id());
    $user = User::find($user_id);

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $user, 
    ]);
}


public function accountUpdate(Request $request)
{
    $id = $request->query('id');  

    if (!$id) {
        return response()->json(['status' => false, 'message' => 'ID is required'], 400);
    }

    $validated_data = $request->validate([
        'first_name' => 'required|string|min:3|max:100',
        'last_name' => 'required|string|min:3|max:100',
        'contact_no' => 'required|numeric',
        'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    $account_data = User::findOrFail($id);
    $account_data->first_name = $validated_data['first_name'];
    $account_data->last_name = $validated_data['last_name'];
    $account_data->contact_no = $validated_data['contact_no'];

    if ($request->hasFile('profile_pic')) {
        $file = $request->file('profile_pic');
        $path = 'uploads/customers/profile-pics/';
        $ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $ext;
        $file->move(public_path($path), $file_name);
        $account_data->profile_pic = $path . $file_name;
    }

    $account_data->save();

    return response()->json([
        'status' => true,
        'message' => 'User information updated successfully.',
        'user' => $account_data,
    ]);
}

public function alert(Request $request)
{
    $user_id = $request->input('user_id', Auth::id());
    $user = User::find($user_id);

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => []
        ], 404);
    }
    $allalert = Alert::all(); 
    return response()->json([
        'status' => true,
        'message' => 'Alerts fetched successfully.',
        'data' => $allalert
    ]);
}

public function product(Request $request)
{
    $user_id = $request->input('user_id', Auth::id());
    $user = User::find($user_id);

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => []
        ], 404);
    }
  $allproduct = product::all();
    return response()->json([
        'status' => true,
        'message' => 'Product fetched successfully.',
        'data' => $allproduct
    ]);
}

public function pumpdata(Request $request)
{
    $user_id = $request->input('user_id', Auth::id());
    $pump_id = $request->input('pump_id');
    $user = User::find($user_id);
    if ($pump_id) {
        $pump = Pump::with('plan')
            ->where('user_id', $user_id)
            ->where('id', $pump_id)
            ->first();
        return response()->json([
            'status' => true,
            'message' => 'Pump fetched successfully.',
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'data' => $pump
        ]);
    } 
    }
    

}
