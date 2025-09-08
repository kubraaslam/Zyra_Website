<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function show()
    {
        $userId = Auth::id();

        // Get cart items for logged-in user
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('checkout', compact('cartItems', 'subtotal'));
    }

    public function process(Request $request)
    {
        $userId = Auth::id();

        // Validate form fields
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'payment_method' => 'required|string|in:card,cod',
            'card_name' => 'required_if:payment_method,card',
            'card_number' => 'required_if:payment_method,card',
            'card_month' => 'required_if:payment_method,card',
            'card_year' => 'required_if:payment_method,card',
            'card_cvv' => 'required_if:payment_method,card',
        ]);

        // Get cart items
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // Set order and delivery dates
        $orderDate = Carbon::now();
        $deliveryDate = $orderDate->copy()->addWeeks(3);

        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'zip' => $validated['zip'],
            'payment_method' => $validated['payment_method'],
            'total' => $total,
            'order_date' => $orderDate,
            'delivery_date' => $deliveryDate,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
            ]);
        }

        foreach ($cartItems as $item) {
            // If product is a membership, activate it
            if ($item->product->category === 'membership') {
                $membershipEnd = now()->addMonth()->format('Y-m-d');
                $user = Auth::user();
                $user->update([
                    'membership_plan' => strtolower($item->product->name),
                    'membership_start' => now(),
                    'membership_end' => $membershipEnd,
                ]);
            }
        }

        // Clear cart
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('checkout')->with([
            'success' => true,
            'delivery_date' => $order->delivery_date->format('F d, Y'),
            'membership_end' => $membershipEnd ?? null, // if a membership was purchased
        ]);
    }
}