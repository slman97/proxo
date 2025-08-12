<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->controller(ApiController::class)->group(function () {
    Route::get('/dashboard', 'dashboard');

    Route::get('/getProxiesData', 'getProxiesData');
    Route::get('/getPaymentsData', 'getPaymentsData');

    Route::delete('/paymentsDelete/{id}', 'destroyPayments');
    Route::delete('/ProxiesDelete/{id}', 'destroyProxies');

    Route::post('/ProxiesStore', 'storeProxies');
    Route::get('/TelegramUser', 'TelegramUser');
    Route::get('/notifications', 'notifications');

    Route::post('/paymentsStore', 'storePayments');
    Route::post('/AddSyriaTelPayment', 'AddSyriaTelPayment');
    Route::post('/notificationsStore', 'notificationsStore');
    
    Route::post('/notifications/update-status', 'updateStatus');

    Route::post('/logout',  'logout');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
