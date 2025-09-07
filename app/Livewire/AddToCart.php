<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $productId;

    public function mount($productId)
    {
        $this->productId = $productId; 
    }

    public function addToCart()
    {
        $userId = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $this->productId)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $this->productId,
                'quantity' => 1,
            ]);
        }

        // Emit event so CartPage can update instantly
        $this->dispatch('cartUpdated');

        $this->dispatch('notify', message: 'Product added to cart!');
        
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}