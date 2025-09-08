<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class MembershipController extends Controller
{
    public function show()
    {
        return view('membership');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:standard,premium',
        ]);

        // Find membership product (in products table, category = membership)
        $product = Product::where('category', 'membership')
            ->where('name', 'LIKE', "%{$request->plan}%")
            ->firstOrFail();

        // Add membership product to cart
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => 1]
        );

        return redirect()->route('checkout')
            ->with('info', "Proceed to checkout to activate your {$request->plan} membership.");
    }
}