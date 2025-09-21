<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Livewire\CartPage;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Welcome page (default landing page)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard (only for logged-in users)
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

// Show checkout page
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');

// Process checkout form
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

// Order History page
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
});

Route::get('/membership', [MembershipController::class, 'show'])->name('membership');
Route::post('/membership/subscribe', [MembershipController::class, 'subscribe'])
    ->name('membership.subscribe');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Auth routes
require __DIR__ . '/auth.php';