<x-app-layout>
    <!-- Special Offer Collection -->
    <section class="text-center my-8 px-8">
        <div class="mb-4 flex flex-col sm:justify-between sm:items-center">
            <h2 class="text-3xl font-bold">Special Offer</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($specialOfferProducts as $product)
                <div class="border rounded-lg p-3 shadow hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                        class="w-full h-24 md:h-48 object-cover rounded">
                    <p class="mt-2 font-medium">{{ $product->name }}</p>
                    <p class="text-sm text-gray-600">LKR {{ number_format($product->price, 2) }}</p>

                    <livewire:add-to-cart :product-id="$product->id" />
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">No products available.</p>
            @endforelse
        </div>
    </section>

    <!-- Product sections by category -->
    <x-product-category title="Rings" :products="$ringProducts" />
    <x-product-category title="Earrings" :products="$earringProducts" />
    <x-product-category title="Bracelets" :products="$braceletProducts" />
    <x-product-category title="Necklaces" :products="$necklaceProducts" />
</x-app-layout>