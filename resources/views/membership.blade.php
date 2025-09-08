<x-app-layout>
    <section class="my-8 px-4" x-data="{ confirmMembership: false, selectedPlan: '' }">
        <div class="text-center mb-4">
            <h2 class="text-2xl md:text-3xl font-bold">Membership Options</h2>
        </div>

        <div class="flex justify-center gap-12 flex-wrap">
            <!-- Standard Membership -->
            <div class="w-full md:w-1/3">
                <div class="relative h-80">
                    <img src="storage/products/standard-mem.png" alt="membership-option1"
                        class="w-full h-full object-cover rounded">
                    <div class="absolute top-2 left-2 my-4 p-2 md:p-8">
                        <p class="text-lg font-semibold">Standard <br>LKR 3000/Month</p>
                        <ul class="p-2 md:p-8 list-disc pl-5">
                            <li>Welcome bonus: LKR 500 store credit</li>
                            <li>10% discount on first purchase.</li>
                            <li>Priority restock alerts</li>
                            <li>Behind-the-scenes content</li>
                            <li>Early promotions</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button @click="confirmMembership = true; selectedPlan = 'standard'"
                        class="bg-black text-white px-4 py-2 text-sm rounded hover:bg-gray-600 transition">
                        Subscribe
                    </button>
                </div>
            </div>

            <!-- Premium Membership -->
            <div class="w-full md:w-1/3">
                <div class="relative h-80">
                    <img src="storage/products/premium-mem.png" alt="membership-option2"
                        class="w-full h-full object-cover rounded">
                    <div class="absolute top-2 left-2 my-4 p-2 md:p-8">
                        <p class="text-lg font-semibold">Premium <br>LKR 8000/Month</p>
                        <ul class="p-2 md:p-8 list-disc pl-5">
                            <li>Welcome gift box</li>
                            <li>Free jewelry on first purchase</li>
                            <li>Access to unreleased pieces</li>
                            <li>Premium support hotline</li>
                            <li>Monthly LKR 1,500 voucher</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button @click="confirmMembership = true; selectedPlan = 'premium'"
                        class="bg-black text-white px-4 py-2 text-sm rounded hover:bg-gray-600 transition">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>

        <!-- Shared Confirmation Modal -->
        <div x-show="confirmMembership" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 text-center">
                <h2 class="text-lg font-semibold mb-4">Confirm Subscription</h2>
                <p class="mb-6">
                    Do you want to subscribe to the <span
                        x-text="selectedPlan.charAt(0).toUpperCase() + selectedPlan.slice(1)"></span> plan?
                </p>
                <div class="flex justify-center gap-4">
                    <button @click="confirmMembership = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                        Cancel
                    </button>
                    <form method="POST" action="{{ route('membership.subscribe') }}">
                        @csrf
                        <input type="hidden" name="plan" x-model="selectedPlan">
                        <button type="submit" class="px-4 py-2 rounded bg-black text-white hover:bg-gray-600">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>