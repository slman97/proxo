<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->controller(ApiController::class)->group(function () {
    Route::get('/dashboard', 'dashboard');
    Route::get('/getProxiesData', 'getProxiesData');
    Route::get('/getPaymentsData', 'getPaymentsData');
    Route::post('/paymentsStore', 'storePayments');
    Route::delete('/paymentsDelete/{id}', 'destroyPayments');
    Route::post('/ProxiesStore', 'storeProxies');
    Route::delete('/ProxiesDelete/{id}', 'destroyProxies');
});