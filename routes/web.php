<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

// Public Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login.submit');
});

// Authenticated Merchant Routes
Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('toko')->group(function () {
        Route::get('/buat', [StoreController::class, 'create'])->name('stores.create');
        Route::post('/', [StoreController::class, 'store'])->name('stores.store');
        Route::get('/{store:slug}/kelola', [StoreController::class, 'edit'])->name('stores.edit');
        Route::put('/{store:slug}', [StoreController::class, 'update'])->name('stores.update');
        Route::delete('/{store:slug}', [StoreController::class, 'destroy'])->name('stores.destroy');

        Route::post('/{store:slug}/produk', [ProductController::class, 'store'])->name('stores.products.store');
        Route::put('/{store:slug}/produk/{product}', [ProductController::class, 'update'])->name('stores.products.update');
        Route::delete('/{store:slug}/produk/{product}', [ProductController::class, 'destroy'])->name('stores.products.destroy');
    });
});

// Public Store Routes (Must be declared after /toko/buat to prevent wildcard clash)
Route::prefix('toko')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/{store:slug}/cetak-qr', [StoreController::class, 'qr'])->name('stores.qr');
    Route::get('/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
});
