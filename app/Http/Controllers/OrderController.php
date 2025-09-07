<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get all orders for the logged-in user, newest first
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', $userId)
            ->orderBy('order_date', 'desc')
            ->get();

        return view('orders', compact('orders'));
    }
}
