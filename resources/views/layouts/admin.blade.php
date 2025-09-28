<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="p-6 md:px-20 md:py-6 space-y-2">
        <h1 class="text-3xl md:text-4xl font-bold">Zyra Admin Dashboard</h1>
        <p class="text-gray-500">Manage your jewelry store with ease</p>

        <div class="py-2 md:py-6">
            @include('layouts.admin-navigation')
        </div>


        <main>
            {{ $slot }}
        </main>

        @livewireScripts
    </div>


</body>

</html>