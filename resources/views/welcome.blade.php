<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zyra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen w-screen bg-cover bg-center overflow-hidden"
    style="background-image: url('{{ asset('img/landing-img.jpg') }}')">

    <!-- Navbar -->
    <nav class="flex justify-between items-center p-4 md:px-8 w-full z-10">
        <div>
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-16 md:h-20">
        </div>

        <!-- Links always visible -->
        <div class="flex space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 bg-black text-white font-semibold rounded shadow hover:bg-gray-600 transition text-sm md:text-base">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-white text-black font-semibold rounded shadow hover:bg-gray-200 transition text-sm md:text-base">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-black text-white font-semibold rounded shadow hover:bg-gray-600 transition text-sm md:text-base">
                        Register
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Centered text-->
    <div class="flex flex-col items-center justify-center h-screen text-center px-4">
        <div class="bg-black bg-opacity-50 p-6 md:p-12 rounded-xl max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Welcome to Zyra Jewelry
                Store</h1>
            <p class="text-lg sm:text-xl md:text-2xl text-gray-200 font-serif mb-6">Discover timeless accessories
                crafted for elegance</p>
        </div>
    </div>

</body>

</html>