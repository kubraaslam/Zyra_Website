<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\MongoUser; 
use App\Models\MongoProduct;
use App\Models\MongoOrder;
use App\Models\MongoOrderItem;

// Register - MySQL + MongoDB
Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Save in MySQL (Sanctum auth)
    $user = User::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role' => 'user',
        'membership' => null,
    ]);

    // Save copy in MongoDB (For Flutter)
    MongoUser::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role' => 'user',
        'membership' => null,
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
});

// Login - MySQL only
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'login' => ['required'], // email or username
        'password' => ['required'],
    ]);

    $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $user = User::where($loginField, $credentials['login'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid Login'], 422);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['user' => $user, 'token' => $token]);
});

// Logout
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out']);
});

// Products - MongoDB
Route::middleware('auth:sanctum')->get('/products', function () {
    return response()->json(MongoProduct::all());
});

// Orders - MongoDB
Route::middleware('auth:sanctum')->get('/orders', function (Request $request) {
    if ($request->user()->role === 'admin') {
        return response()->json(MongoOrder::all());
    }
    return response()->json(MongoOrder::where('user_id', $request->user()->id)->get());
});

// Cart - MongoDB
Route::middleware('auth:sanctum')->get('/cart', function (Request $request) {
    $cartItems = MongoOrderItem::where('user_id', $request->user()->id)
                  ->whereNull('order_id') // items not yet part of any order
                  ->get();

    $cartWithProducts = $cartItems->map(function($item) {
        $product = MongoProduct::find($item->product_id);
        return [
            'id' => $item->_id,
            'product_id' => $item->product_id,
            'product_name' => $product?->name,
            'product_price' => $product?->price,
            'quantity' => $item->quantity,
            'total_price' => $product?->price * $item->quantity,
        ];
    });

    return response()->json($cartWithProducts);
});

// Membership - MongoDB
Route::middleware('auth:sanctum')->get('/membership', function (Request $request) {
    $user = MongoUser::where('email', $request->user()->email)->first();
    return response()->json(['membership' => $user?->membership]);
});

// Subscribe to membership - MySQL + MongoDB
Route::middleware('auth:sanctum')->post('/membership/subscribe', function (Request $request) {
    $membership = $request->input('membership');
    // update both MySQL and MongoDB
    $user = $request->user();
    $user->membership = $membership;
    $user->save();

    $mongoUser = MongoUser::where('email', $user->email)->first();
    $mongoUser->membership = $membership;
    $mongoUser->save();

    return response()->json(['membership' => $membership]);
});

// Checkout - MongoDB
Route::middleware('auth:sanctum')->post('/checkout', function (Request $request) {
    $userId = $request->user()->id;

    // Get all cart items (items not yet associated with an order)
    $cartItems = MongoOrderItem::where('user_id', $userId)
                  ->whereNull('order_id')
                  ->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['message' => 'Cart is empty'], 422);
    }

    // Calculate total price
    $total = 0;
    foreach ($cartItems as $item) {
        $product = MongoProduct::find($item->product_id);
        if (!$product) continue; // skip if product doesn't exist
        $total += $product->price * $item->quantity;
    }

    // Create a new order
    $order = MongoOrder::create([
        'user_id' => $userId,
        'total' => $total,
        'created_at' => now(),
    ]);

    // Associate cart items with the new order
    foreach ($cartItems as $item) {
        $item->order_id = $order->_id;
        $item->save();
    }

    // Return the order with items
    $orderItems = MongoOrderItem::where('order_id', $order->_id)->get()->map(function($item) {
        $product = MongoProduct::find($item->product_id);
        return [
            'product_id' => $item->product_id,
            'product_name' => $product?->name,
            'unit_price' => $product?->price,
            'quantity' => $item->quantity,
            'total_price' => $product?->price * $item->quantity,
        ];
    });

    return response()->json([
        'message' => 'Order placed successfully',
        'order_id' => $order->_id,
        'total' => $total,
        'items' => $orderItems
    ]);
});