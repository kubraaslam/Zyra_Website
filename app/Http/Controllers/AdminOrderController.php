<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function __invoke()
    {
        $orders = Order::with(['user'])->orderBy('id', 'desc')->paginate(5);
        return view('admin.orders', compact('orders'));
    }
}