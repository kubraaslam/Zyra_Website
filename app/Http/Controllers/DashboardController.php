<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Base query: exclude membership and only show active products
        $query = Product::where('category', '!=', 'Membership')
            ->where('status', 'active'); // Only active products

        // All filtered products
        $products = $query->get();

        // Random 5 products for Trendy Collection
        $trendyProducts = $query->inRandomOrder()->take(5)->get();

        return view('dashboard', compact('products', 'trendyProducts'));
    }
}
