<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentNotificationController;

Route::get('/', function () {
    if (auth()->user()?->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    $featuredProducts = \App\Models\Product::latest()->take(3)->get();

    return view('dashboard', compact('featuredProducts'));
})->name('dashboard');
Route::get('/katalog', [OrderController::class, 'index'])->name('store');
Route::get('/riwayat-order', [OrderController::class, 'history'])->middleware('auth')->name('orders.history');
Route::post('/checkout', [OrderController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::get('/order/{order_id}', [OrderController::class, 'status'])->middleware('auth')->name('order.status');
Route::post('/order/{order_id}/simulate-pay', [OrderController::class, 'simulatePay'])->middleware('auth')->name('order.simulate-pay');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminProductController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [AdminProductController::class, 'orders'])->name('orders.index');
    Route::get('/katalog', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/katalog/tambah', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/katalog', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/katalog/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/katalog/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/katalog/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});

// Midtrans Notification Webhook (exempt from CSRF)
Route::post('/payment/callback', [PaymentNotificationController::class, 'handle'])->name('payment.callback');
