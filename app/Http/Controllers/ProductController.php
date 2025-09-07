<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products
        $products = Product::all();

        // Random 5 products for Trendy Collection
        $specialOfferProducts = Product::all()->shuffle()->take(5);

        $ringProducts = Product::where('category', 'Rings')->get();
        $earringProducts = Product::where('category', 'Earrings')->get();
        $braceletProducts = Product::where('category', 'Bracelets')->get();
        $necklaceProducts = Product::where('category', 'Necklaces')->get();

        // Pass to Blade
        return view('products', compact('products', 'specialOfferProducts', 'ringProducts', 'earringProducts', 'braceletProducts', 'necklaceProducts'));
    }
}