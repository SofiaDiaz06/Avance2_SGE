<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- ESTILOS VISUALES PERSONALIZADOS (Paleta Papelería Paraíso) -->
        <style>
            :root {
                --primary-navy: #00043a;
                --primary-blue: #004e89;
                --accent-blue: #407ba7;
                --primary-red: #c1121f;
                --dark-red: #800016;
                --bg-light: #f8fafc;
            }

            /* Barra de navegación superior unificada */
            nav.bg-white, header.bg-white, .bg-white {
                border-color: #e2e8f0;
            }

            /* Botones principales (Nuevo producto, categoría, guardar, etc.) */
            a.bg-blue-600, button.bg-blue-600, .bg-blue-600 {
                background-color: var(--primary-blue) !important;
                transition: background-color 0.2s ease;
            }
            a.bg-blue-600:hover, button.bg-blue-600:hover, .bg-blue-600:hover {
                background-color: var(--accent-blue) !important;
            }

            /* Botones de peligro / eliminar unificados con la paleta roja */
            .text-red-600, .text-red-700 {
                color: var(--primary-red) !important;
                font-weight: 500;
            }
            .text-red-600:hover, .text-red-700:hover {
                color: var(--dark-red) !important;
            }

            /* Tarjetas y contenedores con aspecto limpio y profesional */
            .shadow-sm, .shadow {
                box-shadow: 0 4px 6px -1px rgba(0, 4, 58, 0.05), 0 2px 4px -1px rgba(0, 4, 58, 0.03) !important;
                border: 1px solid #e2e8f0;
            }

            /* Encabezados de tablas elegantes */
            table th {
                background-color: #f1f5f9 !important;
                color: var(--primary-navy) !important;
                font-weight: 600 !important;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.05em;
            }

            /* Enlaces secundarios y de navegación */
            a.text-blue-700, .underline {
                color: var(--primary-blue);
            }
            a.text-blue-700:hover {
                color: var(--accent-blue);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>