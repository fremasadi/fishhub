<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeternakController;
use  App\Http\Controllers\Peternak\StokBenihController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\StokBenihController as AdminStokBenihController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Peternak\PesananController as PeternakPesananController;


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


// Hanya untuk admin
Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('peternaks', PeternakController::class);

     Route::get('admin/benih', [AdminStokBenihController::class, 'index'])
        ->name('admin.benih.index');
    Route::resource('admin/pesanan', AdminPesananController::class)->names('admin.pesanan');
    Route::get('admin/pembayaran', [\App\Http\Controllers\Admin\PembayaranController::class, 'index'])
        ->name('admin.pembayaran.index');

});

Route::middleware(['role:peternak'])->group(function () {
    Route::resource('peternak/benih',StokBenihController::class);
    Route::resource('peternak/pesanan', PeternakPesananController::class)->names('peternak.pesanan');
    Route::get('peternak/pembayaran', [App\Http\Controllers\Peternak\PembayaranController::class, 'index'])
        ->name('peternak.pembayaran.index');

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
