<?php

use App\Http\Controllers\admin\APIController;
use App\Http\Controllers\admin\HaryanaapiController;
use App\Http\Controllers\admin\DataController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/site-api", [APIController::class, "siteApi"]);
Route::get("/hwra-api", [HaryanaapiController::class, "hwraApi"]);
Route::get("/hwra-piezometer", [HaryanaapiController::class, "piezometer"]);
Route::post('/insert_stp_data', [DataController::class, 'insertSTPData']);

Route::post('/client-login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/client-user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->post('/client-logout', [AuthController::class, 'logout']);
// Route::get('/data', [AuthController::class, 'data'])->name('user.data');
Route::get('/data', [AuthController::class, 'data']);
// Route::get('/pumps', [AuthController::class, 'pumps'])->name('user.pumps');
Route::get('/pumps', [AuthController::class, 'pumps']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::post('/report', [AuthController::class, 'report']);
Route::get('/account', [AuthController::class, 'account']);
Route::post('/accountUpdate', [AuthController::class, 'accountUpdate']);
Route::post('/alert', [AuthController::class, 'alert']);
Route::post('/product', [AuthController::class, 'product']);
Route::get('/pumpdata', [AuthController::class, 'pumpdata']);