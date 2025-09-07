<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Livewire\CartPage;
use Illuminate\Support\Facades\Route;

// Dashboard (only for logged-in users)
Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Dashboard route (optional, can remove if using home)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes (only for logged-in users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Products page
Route::get('/products', [ProductController::class, 'index'])->name('products');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Cart page
Route::get('/cart', CartPage::class)->middleware('auth')->name('cart');

// Auth routes
require __DIR__ . '/auth.php';