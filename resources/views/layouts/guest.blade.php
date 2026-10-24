<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-100 min-h-screen flex items-center justify-center relative overflow-x-hidden selection:bg-[#407ba7] selection:text-white" style="background: linear-gradient(135deg, #001233 0%, #001845 50%, #002855 100%);">
        
        <!-- Círculos de luz ambiental de fondo para dar profundidad -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#004e89]/30 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#407ba7]/20 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- Contenedor Principal con proporciones equilibradas (más vertical y estilizado) -->
        <div class="w-full sm:max-w-md mx-4 py-12 px-8 sm:px-10 rounded-[2.5rem] backdrop-blur-xl relative z-10 transition-all duration-300" 
             style="background: linear-gradient(145deg, rgba(13, 40, 85, 0.95), rgba(7, 24, 60, 0.98)); border: 1.5px solid rgba(107, 164, 212, 0.4); box-shadow: 0 35px 70px -15px rgba(0, 0, 0, 0.7), 0 0 50px rgba(0, 78, 137, 0.25);">
            {{ $slot }}
        </div>
    </body>
</html>