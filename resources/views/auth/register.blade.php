<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
         style="background-image: url('{{ asset('img/register-bg.jpg') }}'); background-size: cover; background-position: center;">

        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Zyra Logo" class="w-20 h-20">
            </a>
        </div>

        <!-- Form container -->
        <div class="w-full sm:max-w-md px-6 py-4 bg-black bg-opacity-50 shadow-md sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Username -->
                <div>
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register / Already registered -->
                <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-200 hover:text-white mb-2 sm:mb-0" href="{{ route('login') }}">
                        {{ __('Already registered? Login') }}
                    </a>

                    <x-primary-button class="w-full sm:w-auto">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>