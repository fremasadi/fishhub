<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeternakController;
use  App\Http\Controllers\Peternak\StokBenihController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


// Hanya untuk admin
Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('peternaks', PeternakController::class);
});

Route::middleware(['role:peternak'])->group(function () {
    Route::resource('peternak/benih',StokBenihController::class);

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/{id}/update', [CartController::class, 'update'])->name('cart.update'); // ← Tambahkan ini
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Checkout from cart
    Route::post('/payment/checkout', [PaymentController::class, 'processCheckout'])
        ->name('payment.checkout');
    
    // Show payment page
    Route::get('/payment/{pesanan}', [PaymentController::class, 'show'])
        ->name('payment.show');
    
    // Check payment status (AJAX)
    Route::get('/payment/{pesanan}/check-status', [PaymentController::class, 'checkStatus'])
        ->name('payment.check-status');
    
    // Order history
    Route::get('/my-orders', [PaymentController::class, 'history'])
        ->name('payment.history');

    // Payment finish (redirect from Midtrans)
    Route::get('/payment/finish', [PaymentController::class, 'finish'])
        ->name('payment.finish');
});

Route::post('/midtrans/callback', [PaymentController::class, 'callback'])
    ->name('midtrans.callback');

require __DIR__.'/auth.php';
