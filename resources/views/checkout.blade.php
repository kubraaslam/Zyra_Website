<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10"
        x-data="{ showThankYou: {{ session('success') ? 'true' : 'false' }}, paymentMethod: 'card' }">
        <!-- Thank You Modal -->
        <div x-show="showThankYou" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center">
                <h2 class="text-2xl font-bold mb-4">Thank you for your order!</h2>
                <p class="mb-4">Your delivery is scheduled for <span
                        class="font-semibold">{{ session('delivery_date') }}</span>.</p>
                @if(session('membership_end'))
                    <p class="mb-2 text-green-600">Membership activated until:
                        <strong>{{ session('membership_end') }}</strong></p>
                @endif
                <button @click="showThankYou = false; window.location='{{ route('dashboard') }}';"
                    class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-gray-700">
                    Go to Dashboard
                </button>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-center mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-gray-200 p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    @foreach($cartItems as $item)
                        <div class="flex justify-between mb-2">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>LKR {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach

                    <hr class="my-4 border-gray-400" />

                    <div class="flex justify-between font-bold text-lg">
                        <span>Subtotal</span>
                        <span>LKR {{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('checkout.process') }}" method="POST"
                    class="bg-gray-100 border-gray-200 border-2 p-6 rounded-lg shadow space-y-4">
                    @csrf

                    <!-- Billing Information -->
                    <h2 class="text-xl font-semibold mb-4">Billing Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm">First Name:</label>
                            <input type="text" name="first_name" required class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm">Last Name:</label>
                            <input type="text" name="last_name" required class="w-full border rounded px-3 py-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm">Email:</label>
                        <input type="email" name="email" required class="w-full border rounded px-3 py-2" />
                    </div>

                    <div>
                        <label class="block text-sm">Phone Number:</label>
                        <input type="tel" name="phone" required class="w-full border rounded px-3 py-2" />
                    </div>

                    <div>
                        <label class="block text-sm">Address:</label>
                        <input type="text" name="address" required class="w-full border rounded px-3 py-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm">City:</label>
                            <input type="text" name="city" required class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm">Zip Code:</label>
                            <input type="text" name="zip" required class="w-full border rounded px-3 py-2" />
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <h2 class="text-xl font-semibold mt-6 mb-4">Payment Information</h2>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="payment_method" value="card" x-model="paymentMethod" checked />
                            <span class="ml-2">Credit / Debit Card</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" />
                            <span class="ml-2">Cash on Delivery</span>
                        </label>
                    </div>

                    <!-- Card details, shown only if Credit/Debit Card is selected -->
                    <div class="space-y-4 mt-4" x-show="paymentMethod === 'card'">
                        <div>
                            <label class="block text-sm">Card Holder Name:</label>
                            <input type="text" name="card_name" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm">Card Number:</label>
                            <input type="text" name="card_number" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm">Month</label>
                                <select name="card_month" class="w-full border rounded px-2 py-2">
                                    @for($month = 1; $month <= 12; $month++)
                                        <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                            {{ str_pad($month, 2, '0', STR_PAD_LEFT) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm">Year</label>
                                <select name="card_year" class="w-full border rounded px-2 py-2">
                                    @for($year = date('Y'); $year <= date('Y') + 10; $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm">CVV</label>
                                <input type="text" name="card_cvv" maxlength="4"
                                    class="w-full border rounded px-3 py-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Pay Now Button -->
                    <div class="text-center">
                        <button type="submit" name="place_order"
                            class="bg-gray-900 text-white font-semibold px-10 py-3 rounded-full hover:bg-gray-700">
                            Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>