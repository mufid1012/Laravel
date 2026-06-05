<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentNotificationController;

Route::get('/', [OrderController::class, 'index'])->name('store');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/order/{order_id}', [OrderController::class, 'status'])->name('order.status');
Route::post('/order/{order_id}/simulate-pay', [OrderController::class, 'simulatePay'])->name('order.simulate-pay');

// Midtrans Notification Webhook (exempt from CSRF)
Route::post('/payment/callback', [PaymentNotificationController::class, 'handle'])->name('payment.callback');
