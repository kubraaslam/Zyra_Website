<x-admin-layout>
    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div
                class="p-6 bg-white rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                <h3 class="text-gray-800 font-semibold text-sm flex items-center justify-between">Total Revenue
                    <x-heroicon-o-chart-bar class="w-5 h-5 text-gray-500" />
                </h3>
                <p class="text-2xl font-bold pt-2">Rs. {{ number_format($totalRevenue, 0) }}</p>
            </div>
            <div
                class="p-6 bg-white rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                <h3 class="text-gray-800 font-semibold text-sm flex items-center justify-between">Total Orders
                    <x-heroicon-o-shopping-cart class="w-5 h-5 text-gray-500" />
                </h3>
                </h3>
                <p class="text-2xl font-bold pt-2">{{ $totalOrders }}</p>
            </div>
            <div
                class="p-6 bg-white rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                <h3 class="text-gray-800 font-semibold text-sm flex items-center justify-between">Total Products
                    <x-heroicon-o-cube class="w-5 h-5 text-gray-500" />
                </h3>
                </h3>
                <p class="text-2xl font-bold pt-2">{{ $totalProducts }}</p>
            </div>
            <div
                class="p-6 bg-white rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                <h3 class="text-gray-800 font-semibold text-sm flex items-center justify-between">Total Customers
                    <x-heroicon-o-users class="w-5 h-5 text-gray-500" />
                </h3>
                </h3>
                <p class="text-2xl font-bold pt-2">{{ $totalCustomers }}</p>
            </div>
        </div>

        <!-- Recent Orders + Top Products -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 bg-white shadow rounded-2xl border">
                <h3 class="text-2xl font-semibold">Recent Orders</h3>
                <p class="text-gray-500 text-sm mb-4">Latest customer orders</p>
                @foreach($recentOrders as $order)
                    <div class="flex justify-between items-center py-2 border-b font-semibold">
                        <div class="flex flex-col">
                            <span>{{ $order->first_name . ' ' . $order->last_name }}</span>
                            <span class="text-sm font-normal text-gray-500">
                                {{ $order->orderItems->count() }} items
                            </span>
                        </div>
                        <span>Rs. {{ $order->total }}</span>
                    </div>
                @endforeach
            </div>

            <div class="p-6 bg-white shadow rounded-2xl border">
                <h3 class="text-2xl font-semibold">Top Products</h3>
                <p class="text-gray-500 text-sm mb-4">Best selling items this month</p>
                @foreach($topProducts as $product)
                    <div class="flex justify-between items-center py-2 border-b font-semibold">
                        <div class="flex flex-col">
                            <span>{{ $product->name }}</span>

                            <span class="text-sm font-normal text-gray-500">
                                {{ $product->category}}
                            </span>
                        </div>
                        <span class="font-semibold">Rs. {{ $product->price }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>