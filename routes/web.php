<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use App\Livewire\CartPage;
use App\Livewire\Admin\ProductComponent;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Auth routes
require __DIR__ . '/auth.php';

// Customer routes
Route::middleware(['auth', 'is_customer'])->group(function () {
    // Customer dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // About page
    Route::get('/about', function () {
        return view('about');
    })->name('about');

    // Customer products page
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products');

    // Cart page
    Route::get('/cart', CartPage::class)
        ->name('cart');

    // Orders page
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders');

    // Membership page
    Route::get('/membership', [MembershipController::class, 'show'])
        ->name('membership');
    Route::post('/membership/subscribe', [MembershipController::class, 'subscribe'])
        ->name('membership.subscribe');

    // Checkout page
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Profile routes (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Admin products CRUD
    Route::get('/admin/products', ProductComponent::class)->name('admin.products');
});