<x-app-layout>
    <!-- Main Image -->
    <section class="relative">
        <img src="{{ asset('img/main-img.png') }}" alt="main image" class="w-full object-cover md:h-[26rem]">
    </section>

    <!-- Advertisements -->
    <section class="flex justify-center gap-4 my-8 px-4">
        <div class="relative w-full h-24 md:w-80 md:h-32">
            <img src="{{ asset('img/ad-1.jpg') }}" alt="advertisement1" class="w-full h-full object-cover rounded">
            <div class="absolute top-2 left-2 font-semibold text-sm p-2 md:text-lg md:p-4">
                Charm Rings
            </div>
        </div>
        <div class="relative w-full h-24 md:w-80 md:h-32">
            <img src="{{ asset('img/ad-2.png') }}" alt="advertisement2" class="w-full h-full object-cover rounded">
            <div class="absolute top-2 left-2 font-semibold text-sm p-2 md:text-lg md:p-4">
                Elegant Bracelets
            </div>
        </div>
        <div class="relative w-full h-24 md:w-80 md:h-32">
            <img src="{{ asset('img/ad-3.jpeg') }}" alt="advertisement3" class="w-full h-full object-cover rounded">
            <div class="absolute top-2 left-2 font-semibold text-sm p-2 md:text-lg md:p-4">
                Modern Earrings
            </div>
        </div>
    </section>

    <!-- Popular Categories -->
    <section class="text-center my-6">
        <h2 class="text-xl font-semibold mb-4">Popular Categories</h2>
        <div class="flex justify-center gap-6 flex-wrap">
            @php
                $categories = [
                    ['name' => 'Rings', 'image' => 'category/flower-ring.png'],
                    ['name' => 'Earrings', 'image' => 'category/gem-earring.png'],
                    ['name' => 'Bracelets', 'image' => 'category/pearl-flower-bracelet.png'],
                    ['name' => 'Necklaces', 'image' => 'category/diamond-necklace.png'],
                ];
            @endphp

            @foreach($categories as $category)
                <a href="{{ route('products.index') }}#{{ Str::slug($category['name']) }}"
                    class="flex flex-col items-center">
                    <img src="{{ asset('img/' . $category['image']) }}" alt="{{ $category['name'] }}"
                        class="w-16 h-16 md:w-24 md:h-24 object-cover rounded-full mb-2 hover:opacity-80 transition">
                    <span class="text-sm font-medium">{{ $category['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- About Section -->
    <section class="flex items-center justify-center my-12 px-6">
        <div class="flex w-full max-w-6xl">
            <div class="flex items-center justify-center md:w-1/2">
                <img src="{{ asset('img/register-bg.jpg') }}" alt="About Us"
                    class="hidden md:block md:w-full md:h-[26rem] object-cover">
            </div>
            <div class="flex flex-col justify-center px-6 text-center md:w-1/2 md:text-left">
                <h2 class="text-2xl font-semibold mb-4">About Zyra</h2>
                <p class="mb-4">
                    Discover jewelry that tells your story. At Zyra, we craft pieces that blend elegance, meaning, and
                    modern design which is perfect for every style and every moment. Whether you're searching for a timeless
                    gift or a bold new look, Zyra is where your shine begins.
                </p>
                <a href="{{ route('about') }}"
                    class="bg-black text-white px-8 py-2 rounded hover:bg-gray-800 self-center md:self-start">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Trendy Collection -->
    <section class="text-center my-8 px-8">
        <div class="mb-4 flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h2 class="text-xl font-semibold">Trendy Collection</h2>
            <a href="{{ route('products.index') }}"
                class="text-xs md:text-sm bg-black text-white px-3 py-2 rounded hover:bg-gray-800 self-end mt-2">
                View More >>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($trendyProducts as $product)
                <div class="border rounded-lg p-3 shadow hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                        class="w-full h-24 md:h-48 object-cover rounded">
                    <p class="mt-2 font-medium">{{ $product->name }}</p>
                    <p class="text-sm text-gray-600">LKR {{ number_format($product->price, 2) }}</p>

                    <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="mt-2 bg-black text-white px-4 py-1 text-sm rounded hover:bg-gray-600">
                            Add to Cart
                        </button>
                    </form>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">No products available.</p>
            @endforelse
        </div>
    </section>



    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> -->
</x-app-layout>