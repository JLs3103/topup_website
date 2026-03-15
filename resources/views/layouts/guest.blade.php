<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-gray-950">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center px-4 py-8 sm:py-10 overflow-hidden bg-gradient-to-b from-gray-900 via-gray-900 to-gray-950">
            <div class="pointer-events-none absolute -top-16 -left-20 h-72 w-72 rounded-full bg-indigo-500/25 blur-3xl"></div>
            <div class="pointer-events-none absolute top-1/2 -right-20 h-80 w-80 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-16 left-1/3 h-64 w-64 rounded-full bg-fuchsia-500/15 blur-3xl"></div>

            <div class="relative z-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 rounded-full object-cover shadow-xl shadow-indigo-900/40 ring-2 ring-indigo-400/40" />
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-6 bg-gray-900/85 border border-gray-700/80 shadow-2xl shadow-black/40 backdrop-blur-xl overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
