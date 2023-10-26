<?php

use App\Http\Controllers\Api\AuthenticateController;
use App\Http\Controllers\Api\PositionmanagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthenticateController::class, 'login']);
Route::post('register', [AuthenticateController::class, 'register']);


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('user', function (Request $request) {
        return Auth::guard('sanctum')->user();
    });

    Route::post('logout/{token?}', [AuthenticateController::class, 'logout']);

    // This route takes in the 6 alpha-numeric code received from the email. ensure that it is valid code
    Route::post('/reset-password-token', [AuthenticateController::class, 'validatePasswordResetToken'])->name('api-reset-password-token');

    //This route takes in an email. validates the email exists, and sends 6 alphanumeric code to the email of the user user.
    Route::post('/forget-password', [AuthenticateController::class, 'sendPasswordResetToken'])->name('api-reset-password');

    //This route takes the new password and confirmation password, and resets the password.
    Route::post('/new-password', [AuthenticateController::class, 'setNewAccountPassword'])->name('new-account-password');

    //This route takes main-feed data.
    Route::get('/main-feed', [PositionManagementController::class, 'mainFeed'])->name('api.main-feed');
    //This route takes open stock trades.
    Route::get('/open-stock-trades', [PositionManagementController::class, 'openStockTrades'])->name('api.open-stock-trades');
    //This route takes closed stock trades.
    Route::get('/closed-stock-trades', [PositionManagementController::class, 'closedStockTrades'])->name('front.closed-stock-trades')->middleware('check.subscription.expired');
    //This route takes open options trade.
    Route::get('/open-options-trades', [PositionManagementController::class, 'openOptionsTrades'])->name('front.open-options-trades')->middleware('check.subscription.expired');
    //This route takes closed options trades.
    Route::get('/closed-options-trades', [PositionManagementController::class, 'closedOptionsTrades'])->name('front.closed-options-trades')->middleware('check.subscription.expired');
});
