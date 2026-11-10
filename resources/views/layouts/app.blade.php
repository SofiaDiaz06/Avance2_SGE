<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $branding->trade_name }} ERP</title>

        {{-- Favicon dinámico basado en la identidad corporativa --}}
        @if ($branding->logoUrl())
            <link rel="icon" href="{{ $branding->logoUrl() }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Estilos dinámicos de branding estándar de la guía --}}
        <x-brand-styles />
    </head>
    <body class="bg-slate-100 font-sans text-slate-800 antialiased">
        {{-- sidebarOpen: menú lateral abierto en pantallas pequeñas --}}
        <div x-data="{ sidebarOpen: false }" class="min-h-screen">
            {{-- Menú lateral + barra superior --}}
            @include('layouts.navigation')

            <div class="lg:pl-72">
                {{-- Mensajes Flash integrados de forma segura --}}
                @if (session('success'))
                    <div class="mx-4 mt-4 rounded-xl bg-emerald-50 p-4 text-sm font-medium text-emerald-800 border border-emerald-200 shadow-sm flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 font-bold">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-4 mt-4 rounded-xl bg-rose-50 p-4 text-sm font-medium text-rose-800 border border-rose-200 shadow-sm flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 font-bold">&times;</button>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mx-4 mt-4 rounded-xl bg-sky-50 p-4 text-sm font-medium text-sky-800 border border-sky-200 shadow-sm flex items-center justify-between">
                        <span>{{ session('status') }}</span>
                        <button type="button" onclick="this.parentElement.remove()" class="text-sky-600 hover:text-sky-800 font-bold">&times;</button>
                    </div>
                @endif

                <!-- Page Content -->
                <main class="pb-10">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>