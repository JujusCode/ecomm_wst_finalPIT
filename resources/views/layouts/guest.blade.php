<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">

        <title>ByteX - Best Tech Deals</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-800 via-indigo-700 to-indigo-800 flex items-center justify-center p-4">
            <div class="w-full max-w-5xl overflow-hidden rounded-lg shadow-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>