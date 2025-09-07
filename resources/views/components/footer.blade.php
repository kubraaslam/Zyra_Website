<footer class="bg-black text-white py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Logo / Brand -->
        <div class="space-y-2">
            <h2 class="text-xl font-semibold mb-4">Zyra</h2>
            <p class="text-sm text-gray-400">
                Jewelry that blends elegance, meaning, and modern design.
            </p>
            <br>
            <p class="flex items-center gap-2 text-sm">
                <x-heroicon-o-map-pin class="w-5 h-5 text-gray-600" />
                116/A, Nawala Road, Sri Lanka.
            </p>
            <p class="flex items-center gap-2 text-sm">
                <x-heroicon-o-envelope class="w-5 h-5 text-gray-600" />
                zyrajewelry@gmail.com
            </p>
            <p class="flex items-center gap-2 text-sm">
                <x-heroicon-o-phone class="w-5 h-5 text-gray-600" />
                +94 11 258 4598
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="font-semibold mb-4">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('dashboard') }}" class="hover:underline hover:text-gray-300">Dashboard</a></li>
                <li><a href="{{ route('products') }}" class="hover:underline hover:text-gray-300">Products</a>
                </li>
                <li><a href="{{ route('about') }}" class="hover:underline hover:text-gray-300">About Us</a></li>
                <li><a href="{{ route('cart') }}" class="hover:underline hover:text-gray-300">Cart</a></li>
            </ul>
        </div>

        <!-- Socials -->
        <div>
            <h3 class="font-semibold mb-4">Follow Us</h3>
            <div class="flex gap-4 text-sm">
                <a href="#" class="text-2xl text-white hover:text-gray-600"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="text-2xl text-white hover:text-gray-600"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-2xl text-white hover:text-gray-600"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>

        <!-- Mailing List -->
        <div>
            <h3 class="font-semibold mb-4">Join the Mailing List</h3>
            <form>
                <input type="email" placeholder="Enter your email" class="w-full border-white rounded px-2 py-1 mb-2 text-sm bg-black">
                <button type="button"
                    class="bg-white text-black px-4 py-1 text-sm rounded hover:bg-gray-400">Subscribe</button>
            </form>
        </div>

    </div>

    <div class="mt-8 text-center text-gray-500 text-sm">
        © {{ date('Y') }} Zyra Jewelry. All rights reserved.
    </div>
</footer>