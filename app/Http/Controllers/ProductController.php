<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Base query: exclude membership and only show active products
        $query = Product::where('category', '!=', 'Membership')
            ->where('status', 'active'); // Only active products

        // All filtered products
        $products = $query->get();

        // Random 5 products for Special Offer Collection
        $specialOfferProducts = $query->inRandomOrder()->take(5)->get();

        // Filtered products by category
        $ringProducts = (clone $query)->where('category', 'Rings')->get();
        $earringProducts = (clone $query)->where('category', 'Earrings')->get();
        $braceletProducts = (clone $query)->where('category', 'Bracelets')->get();
        $necklaceProducts = (clone $query)->where('category', 'Necklaces')->get();

        return view('products', compact(
            'products',
            'specialOfferProducts',
            'ringProducts',
            'earringProducts',
            'braceletProducts',
            'necklaceProducts'
        ));
    }
}