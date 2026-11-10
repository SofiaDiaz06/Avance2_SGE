<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $branding->trade_name }} ERP</title>

        <!-- Favicon dinámico basado en la identidad corporativa -->
        @if ($branding->logoUrl())
            <link rel="icon" href="{{ $branding->logoUrl() }}" type="image/x-icon">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- ESTILOS DINÁMICOS DE BRANDING (Componente oficial de la guía) -->
        <x-brand-styles />
    </head>
    <body class="font-sans antialiased text-slate-100 min-h-screen flex items-center justify-center relative overflow-x-hidden selection:bg-brand selection:text-white" style="background: linear-gradient(135deg, #001233 0%, #001845 50%, #002855 100%);">
        
        <!-- Círculos de luz ambiental de fondo para dar profundidad -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-brand/30 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-sky-500/20 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- Contenedor Principal en dos columnas para pantallas grandes -->
        <div class="w-full min-h-screen lg:grid lg:grid-cols-2 relative z-10">
            
            {{-- Panel de marca (solo en pantallas grandes) --}}
            <div class="hidden lg:flex flex-col justify-between p-12 bg-slate-950/40 backdrop-blur-md border-r border-white/10">
                <div class="flex items-center gap-3">
                    <x-application-logo class="h-10 w-auto text-white" />
                    <span class="text-lg font-bold tracking-wider text-white">{{ $branding->trade_name }}</span>
                </div>

                <div class="space-y-4 max-w-md">
                    <h1 class="text-4xl font-bold tracking-tight text-white leading-tight">
                        {{ $branding->trade_name }}
                    </h1>
                    <p class="text-lg text-slate-300 font-medium">
                        {{ $branding->slogan ?: 'Sistema de gestión empresarial' }}
                    </p>
                    <p class="text-sm text-slate-400">
                        Inventario, ventas, compras y auditoría en un solo lugar.
                    </p>
                </div>

                <div class="text-xs text-slate-500 font-medium">
                    {{ $branding->legal_name }} · NIT {{ $branding->nit }}
                </div>
            </div>

            {{-- Formulario de Acceso --}}
            <div class="flex items-center justify-center p-6 sm:p-12">
                <div class="w-full sm:max-w-md mx-auto py-10 px-6 sm:px-10 rounded-[2.5rem] backdrop-blur-xl relative transition-all duration-300 shadow-2xl" 
                     style="background: linear-gradient(145deg, rgba(13, 40, 85, 0.95), rgba(7, 24, 60, 0.98)); border: 1.5px solid rgba(107, 164, 212, 0.4); box-shadow: 0 35px 70px -15px rgba(0, 0, 0, 0.7), 0 0 50px rgba(0, 78, 137, 0.25);">
                    
                    <!-- Logo visible en móviles dentro de la tarjeta -->
                    <div class="flex flex-col items-center mb-6 lg:hidden">
                        <x-application-logo class="h-12 w-auto text-white mb-2" />
                        <span class="text-xl font-bold text-white">{{ $branding->trade_name }}</span>
                    </div>

                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>