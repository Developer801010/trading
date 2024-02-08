<?php

use App\Http\Controllers\Api\AuthenticateController;
use App\Http\Controllers\Api\APIPositionManagementController;
use App\Http\Controllers\Api\APITradeAlertController;
use App\Http\Controllers\FirebasePushController;
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

//The route for unregisterd user, it redirects unauthorize warning message
Route::get('unauthorized', [AuthenticateController::class, 'unauthorized']);

Route::post('login', [AuthenticateController::class, 'login']);
//This route takes closed stock trades for unregistered users.
Route::get('/closed-stock-trades-no-logged', [APIPositionManagementController::class, 'closedStockTradesNoLogged'])->name('api.closed-stock-trades-no-logged');
//This route takes closed options trades.
Route::get('/closed-options-trades-no-logged', [APIPositionManagementController::class, 'closedOptionsTradesNoLogged'])->name('api.closed-options-trades-no-logged');

Route::post('register', [AuthenticateController::class, 'register']);

Route::post('/forget-password', [AuthenticateController::class, 'sendPasswordResetToken'])->name('api-reset-password');
// This route takes in the 6 alpha-numeric code received from the email. ensure that it is valid code
Route::post('/reset-password-token', [AuthenticateController::class, 'validatePasswordResetToken'])->name('api-reset-password-token');
//This route takes the new password and confirmation password, and resets the password.
Route::post('/new-password', [AuthenticateController::class, 'setNewAccountPassword'])->name('new-account-password');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('user', function (Request $request) {
        return Auth::guard('sanctum')->user();
    });

    Route::post('logout', [AuthenticateController::class, 'logout']);

    Route::post('change-password', [AuthenticateController::class, 'changePassword']);

    //This route takes main-feed data.
    Route::get('/main-feed', [APIPositionManagementController::class, 'mainFeed'])->name('api.main-feed');
    //This route takes open stock trades.
    Route::get('/open-stock-trades', [APIPositionManagementController::class, 'openStockTrades'])->name('api.open-stock-trades');
    //This route takes closed stock trades.
    Route::get('/closed-stock-trades', [APIPositionManagementController::class, 'closedStockTrades'])->name('api.closed-stock-trades');
    //This route takes open options trade.
    Route::get('/open-options-trades', [APIPositionManagementController::class, 'openOptionsTrades'])->name('api.open-options-trades');
    //This route takes closed options trades.
    Route::get('/closed-options-trades', [APIPositionManagementController::class, 'closedOptionsTrades'])->name('api.closed-options-trades');

    //This route sets the token on firebase.
    Route::post('/setToken', [FirebasePushController::class, 'setToken'])->name('firebase.token_update');
    //This route removes the token on firebase.
    Route::post('/removeToken', [FirebasePushController::class, 'removeToken'])->name('firebase.token_remove');

    //This route takes tradeAlerts data.
    Route::get('/trade-alerts', [APITradeAlertController::class, 'tradeAlerts'])->name('api.trade-alerts');
    //This route creates tradeAlerts data.
    Route::post('/trade-store', [APITradeAlertController::class, 'tradeStore'])->name('api.trade-store');
    //This route closes an existing tradeAlerts data.
    Route::post('trade-close', [APITradeAlertController::class, 'tradeClose'])->name('api.trade-close');
    //This route adds a new trade into an existing tradeAlerts data.
    Route::post('trade-add', [APITradeAlertController::class, 'tradeAdd'])->name('api.trade-add');
});