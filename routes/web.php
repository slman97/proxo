<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProxiesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/data', 'getData')->name('users.data');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/store', 'store')->name('users.store');
        Route::delete('/{user}', 'destroy')->name('users.destroy');
    });
    Route::prefix('payment')->controller(PaymentController::class)->group(function () {
        Route::get('/', 'index')->name('payment.index');
        Route::get('/data', 'getData')->name('payment.data');
        Route::get('/create', 'create')->name('payment.create');
        Route::post('/store', 'store')->name('payment.store');
        Route::delete('/{payment}', 'destroy')->name('payment.destroy');
    });
    Route::prefix('proxies')->controller( ProxiesController::class)->group(function () {
        Route::get('/', 'index')->name('proxies.index');
        Route::get('/data', 'getData')->name('proxies.data');
        Route::get('/create', 'create')->name('proxies.create');
        Route::post('/store', 'store')->name('proxies.store');
        Route::delete('/{proxy}', 'destroy')->name('proxies.destroy');
    });

});


Route::post('/webhook', [TelegramController::class, 'webhookHandler']);

require __DIR__.'/auth.php';
