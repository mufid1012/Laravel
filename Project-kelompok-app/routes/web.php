<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentNotificationController;

Route::view('/', 'dashboard')->name('dashboard');
Route::get('/katalog', [OrderController::class, 'index'])->name('store');
Route::post('/checkout', [OrderController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::get('/order/{order_id}', [OrderController::class, 'status'])->name('order.status');
Route::post('/order/{order_id}/simulate-pay', [OrderController::class, 'simulatePay'])->name('order.simulate-pay');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Midtrans Notification Webhook (exempt from CSRF)
Route::post('/payment/callback', [PaymentNotificationController::class, 'handle'])->name('payment.callback');
