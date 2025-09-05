<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cartCount = CartItem::where('user_id', $user->id)->count();

        // All products
        $allProducts = Product::all();

        // Random 5 products for Trendy Collection
        $trendyProducts = Product::all()->shuffle()->take(5);

        return view('dashboard', compact('allProducts', 'trendyProducts', 'cartCount'));
    }
}
