<?php

use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\CustomersController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DataController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\LogoutController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\PumpsController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\STPController;
use App\Http\Controllers\admin\CronJobController;
use App\Http\Controllers\DashboardController as CustomerDashboardController;
use App\Models\pumpData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AmcController;
use App\Http\Controllers\admin\SimController;
use App\Http\Controllers\admin\HaryanaapiController;
use App\Http\Controllers\admin\rolesController;
use App\Http\Controllers\stp\StpAuthContorller;
use App\Http\Controllers\stp\StpCustomerDashboardController;
use App\Http\Controllers\admin\AlertController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\cgwa\CgwaAuthController;
use App\Http\Controllers\cgwa\cgwaCustomerDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.login');
});

Route::view('/admin', 'admin.login');


Auth::routes();

Route::group(['prefix' => 'admin'], function(){

    Route::group(['middleware' => 'admin.guest'], function(){

        Route::view('/login','admin.login')->name('admin.login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.auth');
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        //Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
        Route::get('/logout', [LogoutController::class, 'logout'])->name('admin.logout');
        Route::resource('/pumps', PumpsController::class);
        Route::resource('/stps', STPController::class);
        Route::resource('/customers', CustomersController::class);
        Route::resource('/plans', PlanController::class);
        Route::get('/pump-data', [DataController::class, 'pumpData'])->name('pump.data');
        Route::get('/stp-data', [DataController::class, 'stpData'])->name('stp.data');
        Route::get('/offline', [DataController::class, 'offline'])->name('admin.offline');
        Route::get('/offlineemail/{user}', [DataController::class, 'offlineemail'])->name('admin.emailoffline');
        Route::get('/pump-report', [ReportController::class, 'pumpReportIndex'])->name('pump.report.index');
        Route::post('/pump-report-data', [ReportController::class, 'pumpReportData'])->name('pump.report.data');
        Route::get('/stp-report', [ReportController::class, 'stpReportIndex'])->name('stp.report.index');
        Route::post('/stp-report-data', [ReportController::class, 'stpReportData'])->name('stp.report.data');
        Route::get('/report-data/{id}/edit', [ReportController::class, 'editReportData'])->name('reports.data.edit');
        Route::put('/update-report-data/update/{id}', [ReportController::class, 'updateReportData'])->name('reports.data.update');
        Route::get('/negative', [ReportController::class, 'negative'])->name('admin.negative');
        Route::post('/negative-report-data', [ReportController::class, 'negativeReportData'])->name('negative.report.data');
        Route::get('/overflow', [ReportController::class, 'overflow'])->name('admin.overflow');
        Route::post('/overflow-report-data', [ReportController::class, 'overflowReportData'])->name('overflow.report.data');
        Route::get('/garbage', [ReportController::class, 'garbage'])->name('admin.garbage');
        Route::post('/garbage-report', [ReportController::class, 'garbageData'])->name('garbage.data');
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::put('/account-info/update/{id}', [AccountController::class, 'infoUpdate'])->name('account.info.update');
        Route::put('/account-password/update/{id}', [AccountController::class, 'passwordUpdate'])->name('account.password.update');
      // new code updated
        Route::get('/nabl', [DashboardController::class, 'nabl'])->name('admin.nable');
        Route::get('/planend', [DashboardController::class, 'planend'])->name('admin.planend');
        Route::get('/amc_cmc', [DashboardController::class, 'amc_cmc'])->name('admin.amc_cmc');
        Route::get('/nabl-edit/{id}/edit', [DashboardController::class, 'nableedit'])->name('nable.data.edit');
        Route::put('/nabl-edit/update/{id}', [DashboardController::class, 'update'])->name('nable.data.update');
        Route::get('/setting',[DashboardController::class,'setting'])->name('admin.setting');
        Route::get('/admin/notification-count', [DashboardController::class, 'getNotificationCount'])->name('admin.notification.count');
        
        Route::get('/amc',[AmcController::class,'amc'])->name('admin.amc');
        Route::get('/cmc',[AmcController::class,'cmc'])->name('admin.cmc');
        Route::get('/nothing',[AmcController::class,'nothing'])->name('admin.nothing');

        Route::resource('/sim', SimController::class);
        Route::post('/connectsim',[SimController::class,'connect'])->name('connect');
        Route::get('/index',[SimController::class,'viewindex'])->name('viewindex');
        Route::get('/report',[SimController::class,'report'])->name('report');
        Route::get('/active',[SimController::class,'active'])->name('sim.active');
        Route::get('/remaining',[SimController::class,'remaining'])->name('sim.remaining');
        Route::get('/de-attach/{id}/de-attach', [SimController::class, 'deattach'])->name('deattach');


        Route::get('/piezometer',[PumpsController::class,'piezometer'])->name('pumps.piezometer');
        Route::get('/flowmeter',[PumpsController::class,'flowmeter'])->name('pumps.flowmeter');
        //HWRA API
        Route::get('/Haryana',[HaryanaapiController::class,'index'])->name('admin.Haryana');
        Route::post('/storeHWRA',[HaryanaapiController::class,'store'])->name('storeHWRA');
        Route::post('/senddata',[HaryanaapiController::class,'senddata'])->name('senddata');
        Route::get('/HWRAPiezometer',[HaryanaapiController::class,'HWRAPiezometer'])->name('admin.HWRAPiezometer');
        Route::post('/HWARstore',[HaryanaapiController::class,'HWARstore'])->name('HWARstore');
               // roles 
        Route::get('/roles',[rolesController::class,'index'])->name('admin.roles');
        Route::post('/store',[rolesController::class,'store'])->name('store');
        //Alert and product
        Route::resource('/alert', AlertController::class);
        Route::resource('/product', ProductController::class);
    });

});


Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('user.index');
    Route::get('/data', [CustomerDashboardController::class, 'data'])->name('user.data');
    Route::get('/account', [CustomerDashboardController::class, 'account'])->name('user.account');
    Route::put('/account-info/update/{id}', [CustomerDashboardController::class, 'infoUpdate'])->name('user.info.update');
    Route::put('/account-password/update/{id}', [CustomerDashboardController::class, 'passwordUpdate'])->name('user.password.update');
    Route::get('/pumps', [CustomerDashboardController::class, 'pumps'])->name('user.pumps');
    Route::get('/pump/{id}', [CustomerDashboardController::class, 'pump'])->name('user.pump');
    Route::get('/pump-report', [CustomerDashboardController::class, 'pumpReport'])->name('user.pump.report');
    Route::post('/pump-report-data', [CustomerDashboardController::class, 'pumpReportData'])->name('user.pump.report.data');
    Route::get('/get-forward-flow/{pumpId}', [CustomerDashboardController::class, 'getForwardFlow']);

    Route::get('/datewisereport', [CustomerDashboardController::class, 'datewise'])->name('user.datewisereport');
    Route::post('/date-wise-report', [CustomerDashboardController::class, 'datewisereport'])->name('user.pump.report.datewise');
    Route::get('/annual-report', [CustomerDashboardController::class, 'annual'])->name('user.annual');
    Route::post('/annual-report-data', [CustomerDashboardController::class, 'annualreport'])->name('user.annual-report-data');
    Route::get('/contact_us', [CustomerDashboardController::class, 'contact'])->name('user.contact');
});


// STP Controller 
Route::prefix('stp')->group(function () {
    Route::get('/login', [StpAuthContorller::class, 'login'])->name('stp.login');
    Route::post('/login', [StpAuthContorller::class, 'doLogin'])->name('stp.doLogin');
    Route::middleware(['web', 'stp'])->group(function () {
    Route::get('/dashboard', [StpCustomerDashboardController::class, 'index'])->name('stp.dashboard');
    });
    Route::get('/dashboard', [StpCustomerDashboardController::class, 'index'])->name('stp.dashboard');
    Route::get('/data/{id}', [StpCustomerDashboardController::class, 'getStpData']);
    Route::get('/logout', [StpAuthContorller::class, 'logout'])->name('stp.logout');
    Route::get('/stppump', [StpCustomerDashboardController::class, 'stp'])->name('stp.stppump');
    Route::get('/stps/{id}', [StpCustomerDashboardController::class, 'stps'])->name('stp.stps');
    Route::get('/stpdata', [StpCustomerDashboardController::class, 'stpdata'])->name('stp.stp.data');
    Route::get('/contact_us',[StpCustomerDashboardController::class, 'contact'])->name('stp.contact');
    Route::get('/stp-report', [StpCustomerDashboardController::class, 'stpReport'])->name('stp.report');
    Route::post('/stp-report-data', [StpCustomerDashboardController::class, 'stpReportdata'])->name('stp.stp.report.data');
    Route::get('/stpdailyreport', [StpCustomerDashboardController::class, 'stpdailyreport'])->name('stp.stpdailyreport');
    Route::post('/stpdailyreport-data', [StpCustomerDashboardController::class, 'stpdailyreportdata'])->name('stp.stp.stpdailyreport');
    Route::get('/annualstpreport', [StpCustomerDashboardController::class, 'annualstpreport'])->name('stp.annualstpreport');
    Route::post('/annualstpreport-data', [StpCustomerDashboardController::class, 'annualstpreportdata'])->name('stp.stp.annualstpreport');
});

// CGWA Portel 

    Route::prefix('cgwa')->group(function () {
    Route::get('/login', [CgwaAuthController::class, 'login'])->name('cgwa.login');
    Route::post('/login', [CgwaAuthController::class, 'doLogin'])->name('cgwa.doLogin');
    Route::get('/logout', [CgwaAuthController::class, 'logout'])->name('cgwa.logout');
    Route::get('/dashboard', [cgwaCustomerDashboardController::class, 'index'])->name('cgwa.dashboard');
    Route::get('/cgwacustomer', [cgwaCustomerDashboardController::class, 'cgwacustomer'])->name('cgwa.cgwacustomer');
    Route::get('/customershow/{id}', [cgwaCustomerDashboardController::class, 'customershow'])->name('cgwa.customershow');
    Route::get('/pumpreport', [cgwaCustomerDashboardController::class, 'cgwapumpReport'])->name('cgwa.pumpReport');
    Route::post('/pumpreport-data', [cgwaCustomerDashboardController::class, 'cgwapumpReportData'])->name('cgwa.pumpdata');
    Route::get('/editreport/{id}/edit', [cgwaCustomerDashboardController::class, 'editReportData'])->name('cgwa.data.edit');
    Route::put('/editreport-data/update/{id}', [cgwaCustomerDashboardController::class, 'updateReportData'])->name('cgwa.data.update');
    Route::get('/live-data', [cgwaCustomerDashboardController::class, 'liveData'])->name('cgwa.livedata');
    Route::get('/overflowcgwa', [cgwaCustomerDashboardController::class, 'overflowcgwa'])->name('cgwa.overflow');
    Route::post('/overflowcgwa-report-data', [cgwaCustomerDashboardController::class, 'overflowcgwaReportData'])->name('cgwa.report.data');
    Route::get('/offline', [cgwaCustomerDashboardController::class, 'offline'])->name('cgwa.offline');
    Route::get('/offlineemail/{user}', [cgwaCustomerDashboardController::class, 'offlineemail'])->name('cgwa.emailoffline');
    Route::get('/negative', [cgwaCustomerDashboardController::class, 'negative'])->name('cgwa.negative');
    Route::post('/negative-report-data', [cgwaCustomerDashboardController::class, 'negativeReportData'])->name('cgwa.negative.report');

});

// cornjob route

Route::get('/morning-flow', [CronJobController::class, 'pumpMorningFlow'])->name('pump.morning.flow');
Route::get('/evening-flow', [CronJobController::class, 'pumpEveningFlow'])->name('pump.evening.flow');
Route::get('/daily-flow', [CronJobController::class, 'pumpDailyFlow'])->name('pump.daily.flow');
Route::get('/email', [CronJobController::class, 'email'])->name('admin.email');
Route::get('/todayflow',[CronJobController::class,'todayflow']);
Route::get('/planemail',[CronJobController::class,'planemail'])->name('admin.planemail');
Route::get('/allplanend',[CronJobController::class,'allplanend'])->name('admin.allplanend');
Route::get('/datatable',[CronJobController::class, 'datatable'])->name('stp.datatable');
Route::get('/daliystpdata', [CronJobController::class, 'dailydata'])->name('stp.dailydata');
Route::get('/dailyhistorydatadelete', [CronJobController::class, 'dailyhistorydatadelete']);
Route::get('/overflow', [CronJobController::class, 'overflow']);


//data insert route

Route::get('/insert_pump_data', [DataController::class, 'insertPumpData'])->name('data.insertPumpData');
//http://domain/insert_pump_data?ID=9&FF=44&CF=15&RF=1&GWL=10

// Route::get('/insert_stp_data', [DataController::class, 'insertSTPData'])->name('data.insertSTPData');
//http://domain/insert_stp_data?A=2&B=10&C=13&D=15&E=17&F=45&G=74&H=12&I=45


Route::post('/insert_stp_data', [DataController::class, 'insertSTPData'])->name('data.insertSTPData');

