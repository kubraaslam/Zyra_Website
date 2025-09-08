<x-guest-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative"
        style="background-image: url('{{ asset('img/login-bg.jpg') }}'); background-size: cover; background-position: center;">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>

        <!-- Logo -->
        <div class="z-10 mb-6">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Zyra Logo" class="w-24 h-24 md:w-28 md:h-28">
            </a>
        </div>

        <div class="z-10 w-full sm:max-w-md px-8 py-6 bg-black bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-90 shadow-lg rounded-2xl backdrop-blur-md">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-4 mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                        <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-white hover:text-gray-300" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex flex-col gap-3">
                    <x-primary-button class="w-full py-4">
                        {{ __('Log in') }}
                    </x-primary-button>

                    <a href="{{ route('register') }}"
                        class="underline text-white hover:text-gray-700 text-sm">
                        {{ __('Don\'t have an account? Register Now') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>