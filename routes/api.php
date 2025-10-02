<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;       // MySQL
use App\Models\MongoUser;  // MongoDB copy

// Register - MySQL + MongoDB
Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // 1️⃣ Save in MySQL (Sanctum auth)
    $user = User::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role' => 'user',
        'membership' => null,
    ]);

    // 2️⃣ Save copy in MongoDB
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

// Example API route using MongoDB
Route::middleware('auth:sanctum')->get('/products', function() {
    return response()->json(\App\Models\MongoProduct::all());
});
