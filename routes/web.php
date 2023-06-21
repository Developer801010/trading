<?php

use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\PaymentManagementController;
use App\Http\Controllers\Backend\PlanManagementController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\PositionmanagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/  
Route::get('/', [FrontController::class, 'homepage'])->name('front.home');

Route::get('/subscription', [FrontController::class, 'subscription'])->name('front.subscription');
Route::get('/terms_conditions', [FrontController::class, 'terms_conditions'])->name('front.terms_conditions');

Route::group(['middleware' => ['auth'], ['prefix' => 'front']], function() {
    Route::get('/checkout/{subscription_type}', [FrontController::class, 'checkout'])->name('front.checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('front.payment.process');
    Route::get('/thanks', [PaymentController::class, 'thanks'])->name('front.thanks');
  

    Route::get('account', [AccountController::class, 'index'])->name('front.account');
    Route::post('/account/store', [AccountController::class, 'store'])->name('front.account.store');

    // Route::post('/plan/{id}/agreement/create', [PaymentController::class, 'createAgreement'])->name('front.create-agreement-paypal');
    Route::get('execute-agreement/{success}', [PaymentController::class, 'executeAgreement'])->name('front.execute-agreement-paypal');

    Route::group(['middleware' => ['verified']], function() {  //'role:subscriber'
        Route::get('/open-position', [PositionmanagementController::class, 'openPosition'])->name('front.open-position');
    });
});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'role:admin'], ['prefix' => 'admin']], function() {

    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

    Route::resource('profiles', ProfileController::class);

    Route::resource('plans', PlanManagementController::class);
    Route::post('/paypal/plan/create', [PlanManagementController::class, 'createPlanPaypal'])->name('admin.create-plan-paypal');
    Route::get('/paypal/plan/list', [PlanManagementController::class, 'listPlanPaypal'])->name('admin.list-plan-paypal');
    Route::get('/paypal/plan/{id}', [PlanManagementController::class, 'showPlanPaypal'])->name('admin.show-plan-paypal');
    Route::get('/paypal/plan/{id}/activate', [PlanManagementController::class, 'activatePlanPaypal'])->name('admin.activate-plan-paypal');
    Route::delete('/paypal/plan/{id}/delete', [PlanManagementController::class, 'deletePlanPaypal'])->name('admin.delete-plan-paypal');    
});

