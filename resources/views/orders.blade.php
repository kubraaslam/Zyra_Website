<x-app-layout>
    <div class="p-12">
        <h1 class="text-2xl font-semibold mb-6">Your Orders</h1>

        @forelse ($orders as $order)
            <div class="bg-gray-300 rounded-xl p-4 mb-6">
                <div class="flex flex-wrap justify-between text-sm font-medium mb-2 p-6">
                    <div>Order ID: {{ $order->id }}</div>
                    <div>Total Amount (LKR): {{ number_format($order->total, 2) }}</div>
                    <div>Delivered to: {{ $order->address }}</div>
                    <div>Order Date: {{ $order->order_date->format('Y-m-d') }}</div>
                </div>
                <div class="border-t border-gray-400 mt-2 pt-3 text-sm md:p-6">
                    <div class="mb-3 font-semibold">Delivery Date: {{ $order->delivery_date->format('Y-m-d') }}</div>
                    <div class="grid grid-cols-2 gap-4 md:flex md:gap-6 md:flex-wrap">
                        @foreach ($order->orderItems as $item)
                            <div class="flex flex-col items-center w-28 text-center">
                                <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-20 h-20 rounded-md mb-2 object-cover">
                                <div class="text-sm font-medium">{{ $item->product->name }}</div>
                                <div class="text-xs text-gray-600">x{{ $item->quantity }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600">You have no past orders.</p>
        @endforelse
    </div>
</x-app-layout>