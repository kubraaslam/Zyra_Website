<x-app-layout>
    <!-- Main image -->
    <section class="relative">
        <img src="{{ asset('img/ad-1.jpg') }}" alt="main image" class="w-full md:h-[26rem] object-cover">
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-black text-3xl md:text-7xl font-bold">About Us</h1>
        </div>
    </section>

    <!-- About Section -->
    <section class="flex items-center justify-center my-12 px-6">
        <div class="flex w-full md:max-w-6xl">
            <div class="md:w-1/3 flex items-center justify-center">
                <img src="{{ asset('img/login-bg.jpg') }}" alt="About Us"
                    class="hidden md:block md:w-full md:h-[30rem] object-cover rounded">
            </div>
            <!-- Content -->
            <div class="md:w-2/3 flex flex-col justify-center px-6 text-center md:text-left">
                <h2 class="text-2xl font-semibold mb-4">Our Story</h2>
                <p class="mb-4">
                    Zyra Jewelry was born out of a love for minimalist design and meaningful accessories...
                </p>

                <h2 class="text-2xl font-semibold mb-4">Our Mission</h2>
                <p class="mb-4">
                    We envision a world where everyone can access beauty, feel empowered, and wear jewelry that tells a
                    story—your story.
                </p>

                <h2 class="text-2xl font-semibold mb-4">Our Vision</h2>
                <p class="mb-4">
                    Welcome to Zyra Jewelry — where timeless elegance meets everyday wear.
                </p>
            </div>
        </div>
    </section>

    <!-- Advertisements -->
    <section class="flex justify-center gap-4 my-8 px-4 flex-wrap">
        <div class="w-80">
            <img src="{{ asset('img/ad-1.jpg') }}" alt="advertisement1" class="w-full h-32 object-cover">
            <div class="text-lg text-center mt-2">Everyday Essentials</div>
        </div>
        <div class="w-80">
            <img src="{{ asset('img/ad-2.png') }}" alt="advertisement2" class="w-full h-32 object-cover">
            <div class="text-lg text-center mt-2">Occasion-ready Design</div>
        </div>
        <div class="w-80">
            <img src="{{ asset('img/ad-3.jpeg') }}" alt="advertisement3" class="w-full h-32 object-cover">
            <div class="text-lg text-center mt-2">Custom & gift-worthy pieces</div>
        </div>
    </section>
</x-app-layout>