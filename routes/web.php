<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Livewire\Admin\UserManagement;
use App\Livewire\CartPage;
use App\Livewire\Admin\ProductComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

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

    // Admin customers CRUD
    Route::get('/admin/customers', UserManagement::class)->name('admin.customers');

    // Admin all orders
    Route::get('/admin/orders', AdminOrderController::class)->name('admin.orders');
});

//Exploit 1
Route::get('/vuln-sql-users', function (Illuminate\Http\Request $request) {
    $email = $request->query('email');
    $user = DB::select("SELECT * FROM users WHERE email = $email"); // vulnerable
    return $user ?: 'No user found';
});

Route::get('/safe-sql-users', function (Illuminate\Http\Request $request) {
    $email = $request->query('email');
    $user = DB::table('users')->where('email', $email)->first(); //safe from SQL injection
    return $user ?: 'No user found';
});

//Exploit 2
Route::get('/vuln-sql-products', function (Request $request) {
    $category = $request->query('category'); // user-controlled
    // VULNERABLE: concatenates user input directly into SQL
    $rows = DB::select("SELECT * FROM products WHERE category = '$category'");
    return response()->json($rows);
});

Route::get('/safe-sql-products', function (Request $request) {
    $validated = $request->validate([
        'category' => 'required|string|max:100'
    ]);

    $category = $validated['category'];

    $rows = Product::select('id', 'name', 'price', 'category')
        ->where('category', $category)
        ->get();

    return response()->json($rows);
});

//Exploit 3
Route::get('/vuln-sql-orders', function (Request $request) {
    $q = $request->query('q'); // user-controlled
    // WARNING: concatenating into SQL -> SQLi possible
    $rows = DB::select("SELECT * FROM orders WHERE id = $q");
    return response()->json($rows);
});

Route::get('/safe-sql-orders', function (Request $request) {
    $request->validate(['q' => 'required|integer|min:1']);
    $id = $request->query('q');

    $order = Order::findOrFail($id);

    // authorize: allow owner or admin only
    $user = $request->user();
    if (!($user && ($user->id === $order->user_id || $user->is_admin))) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    // return minimal set including sensitive fields only after auth
    return response()->json($order->only(['id', 'delivery_address', 'phone', 'total', 'created_at']));
})->middleware('auth');