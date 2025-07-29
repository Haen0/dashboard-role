<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Layanan Konsultasi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            <div class="flex">
                @auth
                {{-- Sidebar tetap di sisi kiri --}}
                <aside class="w-64 hidden md:block h-screen fixed top-0 left-0 bg-white shadow z-20">
                    @include('layouts.sidebar')
                </aside>
                @endauth

                <div class="flex-1 ml-0 @auth md:ml-64 @endauth">
                    {{-- Header --}}
                    @isset($header)
                        @include('layouts.navigation')
                    @endisset

                    {{-- Main content --}}
                    <main class="p-4">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
        {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> --}}
    </body>
</html>
