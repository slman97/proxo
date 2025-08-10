<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->controller(ApiController::class)->group(function () {
    Route::get('/dashboard', 'dashboard');
    Route::get('/getProxiesData', 'getProxiesData');
    Route::get('/getPaymentsData', 'getPaymentsData');
    Route::post('/paymentsStore', 'storePayments');
    Route::delete('/paymentsDelete/{id}', 'destroyPayments');
    Route::post('/ProxiesStore', 'storeProxies');
    Route::delete('/ProxiesDelete/{id}', 'destroyProxies');
    Route::get('/TelegramUsers', 'TelegramUsers');
    Route::post('/AddSyriaTelPayment', 'AddSyriaTelPayment');
    Route::post('/notificationsStore', 'notificationsStore');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});