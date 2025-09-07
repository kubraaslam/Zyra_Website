<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public $cartItems;
    public $subtotal = 0;

    protected $listeners = ['cartUpdated' => 'mount'];

    public function mount()
    {
        $this->cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        $this->calculateSubtotal();
    }

    public function calculateSubtotal()
    {
        $this->subtotal = $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function updateQuantity($cartId, $quantity)
    {
        if ($quantity < 1)
            return;

        $cartItem = Cart::find($cartId);
        $cartItem->update(['quantity' => $quantity]);

        $this->mount(); // Refresh cart items
    }

    public function removeItem($cartId)
    {
        Cart::destroy($cartId);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
