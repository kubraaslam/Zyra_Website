<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartBadge extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $userId = Auth::id();
        $this->cartCount = Cart::where('user_id', $userId)->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart-badge');
    }
}
