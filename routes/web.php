<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


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

Route::get('/checkout/{subscription_type}', [FrontController::class, 'checkout'])->name('front.checkout');
Route::post('/payment/process', [FrontController::class, 'process'])->name('payment.process');

Route::get('/terms_conditions', [FrontController::class, 'terms_conditions'])->name('front.terms_conditions');


Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class)->middleware('role:admin');

    Route::resource('profiles', ProfileController::class)->middleware('role:admin');

});

