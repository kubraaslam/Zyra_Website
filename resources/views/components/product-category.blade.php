<section id="{{ Str::slug($title) }}" class="text-center my-8 px-8">
    <div class="flex justify-center items-center mb-4">
        <h2 class="text-3xl font-bold text-center">{{ $title }}</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach ($products as $product)
            <div class="border rounded-lg p-3 shadow hover:shadow-lg transition">
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                    class="w-full h-32 md:h-48 object-cover rounded" />

                <p class="mt-2 font-medium">{{ $product->name }}</p>
                <p class="text-sm text-gray-600">LKR {{ number_format($product->price, 2) }}</p>

                @livewire('add-to-cart', ['productId' => $product->id], key($product->id))
            </div>
        @endforeach
    </div>
</section>