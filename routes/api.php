<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Register
Route::post('/register', function(Request $request){
    $data = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role' => 'user',
        'membership' => null,
    ]);

    $token = $user->createToken('api-token', ['*'])->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
});

// Login
Route::post('/login', function(Request $request){
    $credentials = $request->validate([
        'login' => ['required'], // can be email or username
        'password' => ['required'],
    ]);

    // Try login with email first, then username
    $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    if (!Auth::attempt([$loginField => $credentials['login'], 'password' => $credentials['password']])) {
        return response()->json(['message' => 'Invalid Login'], 422);
    }

    $user = $request->user();
    $token = $user->createToken('api-token', ['*'])->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});

// Logout
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out']);
});
