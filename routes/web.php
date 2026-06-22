<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\PromoController;

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:customer'])
    ->name('home');

Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');

use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\OrderController;

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/products/{product}/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/products/{product}/booking', [BookingController::class, 'store'])->name('booking.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;

Route::prefix('seller')->name('seller.')->middleware(['auth', 'verified', 'role:seller'])->group(function () {
    Route::get('/', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', SellerProductController::class);
});

require __DIR__.'/auth.php';
