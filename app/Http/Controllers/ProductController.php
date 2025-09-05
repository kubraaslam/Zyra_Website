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

        // Pass to Blade
        return view('products.index', compact('products'));
    }

}
