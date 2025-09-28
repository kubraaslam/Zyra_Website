<x-admin-layout>
    <div class="p-6 bg-white rounded-lg border shadow">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Orders</h1>
                <p class="text-gray-500 text-sm">All customer orders and fulfillment</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-3 text-green-600">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-3 text-red-600">{{ session('error') }}</div>
        @endif

        <div class="max-w-7xl mx-auto">
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left text-sm">
                    <thead>
                        <tr class="border-b text-gray-500 hover:bg-gray-200">
                            <th class="p-6">Order ID</th>
                            <th class="p-6">Name</th>
                            <th class="p-6">Email</th>
                            <th class="p-6">Payment Method</th>
                            <th class="p-6">Total</th>
                            <th class="p-6">Order Date</th>
                            <th class="p-6">Delivery Address</th>
                            <th class="p-6">Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="p-6 font-semibold">{{ $order->id }}</td>
                                <td class="p-6">{{ $order->first_name . ' ' . $order->last_name }}</td>
                                <td class="p-6">{{ $order->user->email }}</td>
                                <td class="p-6">{{ ucfirst($order->payment_method) }}</td>
                                <td class="p-6 font-semibold">LKR {{ number_format($order->total, 2) }}</td>
                                <td class="p-6">{{ $order->order_date->format('M d, Y') }}</td>
                                <td class="p-6">{{ $order->address . ', ' . $order->city }}</td>
                                <td class="p-6">{{ $order->delivery_date->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-admin-layout>