<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::count();

        $recentOrders = Order::latest()->take(5)->get();
        $topProducts = Product::withCount(['orderItems as total_sold' => function($query) {
            $query->select(DB::raw("SUM(quantity)"));
        }])->orderBy('total_sold', 'desc')->take(3)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'topProducts'
        ));
    }
}
