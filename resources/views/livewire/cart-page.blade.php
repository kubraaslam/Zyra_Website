<div>
    <div class="p-4 mx-auto max-w-7xl">
        <h2 class="text-center text-3xl font-bold mb-8">My Cart</h2>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items: 2/3 -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between border-b pb-2 flex-wrap">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                                <div>
                                    <p class="font-semibold">{{ $item->product->name }}</p>
                                    <p class="text-gray-600">LKR {{ number_format($item->product->price, 2) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                    class="px-2 py-1 bg-gray-300 rounded">-</button>
                                <span>{{ $item->quantity }}</span>
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                    class="px-2 py-1 bg-gray-300 rounded">+</button>
                            </div>

                            <div class="items-center hidden lg:flex">
                                <p class="text-center">LKR {{ number_format($item->product->price * $item->quantity, 2) }}</p>
                            </div>

                            <button wire:click="removeItem({{ $item->id }})"
                                class="text-red-500 hover:text-red-700"><x-heroicon-o-trash class="w-5 h-5 text-red" /></button>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary: 1/3 -->
                <div class="bg-gray-100 p-6 rounded-lg shadow w-full">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    @foreach($cartItems as $item)
                        <div class="flex justify-between mb-2">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>LKR {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach

                    <hr class="my-4">

                    <div class="flex justify-between font-bold text-lg">
                        <span>Subtotal</span>
                        <span>LKR {{ number_format($subtotal, 2) }}</span>
                    </div>

                    <form action="{{ route('products') }}" method="get">
                        <button type="submit"
                            class="mt-6 w-full bg-gray-500 hover:bg-gray-400 text-white font-semibold py-2 rounded-lg text-lg">
                            CHECKOUT
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order History -->
            <div class="mt-10 text-center">
                <form action="{{ route('products') }}" method="get">
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-800">
                        Order History
                    </button>
                </form>
            </div>
        @else
            <p class="text-gray-500">Your cart is empty.</p>
        @endif
    </div>
</div>