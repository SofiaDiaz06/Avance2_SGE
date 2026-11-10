<x-app-layout>
    @php
        // Tono de color de cada tarjeta KPI (clases completas para que Tailwind las incluya)
        $tones = [
            'brand' => 'bg-brand/10 text-brand',
            'indigo' => 'bg-indigo-50 text-indigo-600',
            'amber' => 'bg-amber-50 text-amber-600',
            'emerald' => 'bg-emerald-50 text-emerald-600',
            'sky' => 'bg-sky-50 text-sky-600',
            'violet' => 'bg-violet-50 text-violet-600',
            'orange' => 'bg-orange-50 text-orange-600',
            'slate' => 'bg-slate-100 text-slate-600',
            'rose' => 'bg-rose-50 text-rose-600',
        ];
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Bienvenida con el color de marca, roles y accesos rápidos --}}
            <div class="rounded-2xl bg-gradient-to-r from-slate-900 via-brand to-slate-900 p-6 sm:p-8 text-white shadow-xl">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <span class="inline-block rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white/90 backdrop-blur">
                            {{ Str::ucfirst(now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')) }}
                        </span>
                        <h1 class="mt-3 text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Bienvenido, {{ auth()->user()->name }}
                        </h1>
                        <p class="mt-2 text-sm text-slate-200">
                            <strong>Roles asignados:</strong>
                            {{ $roles->isEmpty() ? 'Sin rol asignado' : $roles->join(', ') }}
                            @if ($roles->count() > 1)
                                · <strong>Rol activo:</strong> {{ $activeRole }}
                                (<a href="{{ route('active-role.edit') }}" class="underline text-white font-medium hover:text-white/80">cambiar</a>)
                            @endif
                        </p>
                    </div>

                    {{-- Accesos rápidos (cada botón aparece solo si el usuario tiene el permiso) --}}
                    <div class="flex flex-wrap items-center gap-3">
                        @can('crear-productos')
                            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/20 backdrop-blur border border-white/20">
                                <x-icon name="plus" class="h-4 w-4" />
                                Nuevo producto
                            </a>
                        @endcan
                        @can('crear-categorias')
                            <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/20 backdrop-blur border border-white/20">
                                <x-icon name="plus" class="h-4 w-4" />
                                Nueva categoría
                            </a>
                        @endcan
                        @can('crear-ventas')
                            <a href="{{ route('sales.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-brand shadow-sm transition hover:bg-slate-100">
                                <x-icon name="cart" class="h-4 w-4" />
                                Nueva venta
                            </a>
                        @endcan
                        @can('crear-compras')
                            <a href="{{ route('purchases.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/20 backdrop-blur border border-white/20">
                                <x-icon name="truck" class="h-4 w-4" />
                                Nueva orden de compra
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            {{-- KPIs --}}
            @if ($stats->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($stats as $stat)
                        @php
                            $toneClass = $tones[$stat['tone'] ?? 'indigo'] ?? 'bg-indigo-50 text-indigo-600';
                        @endphp
                        <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-sm border border-slate-200/80 transition hover:shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $toneClass }}">
                                    <x-icon :name="$stat['icon'] ?? 'chart'" class="h-6 w-6" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 truncate">{{ $stat['label'] }}</p>
                                    <p class="mt-1 text-2xl font-bold text-slate-800 tracking-tight">{{ $stat['value'] }}</p>
                                    @isset($stat['hint'])
                                        <p class="mt-0.5 text-xs font-medium text-slate-400">{{ $stat['hint'] }}</p>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Gráficos (Chart.js) --}}
            @if (count($charts))
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach ($charts as $chart)
                        <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 {{ $chart['wide'] ?? false ? 'lg:col-span-2' : '' }}">
                            <div class="mb-4">
                                <h3 class="text-base font-bold text-slate-800">{{ $chart['title'] }}</h3>
                                <p class="text-xs text-slate-500">{{ $chart['subtitle'] }}</p>
                            </div>

                            @if ($chart['empty'])
                                <div class="flex h-64 flex-col items-center justify-center text-slate-400">
                                    <x-icon name="chart" class="h-10 w-10 mb-2 opacity-50" />
                                    <p class="text-sm font-medium">Sin datos para mostrar todavía</p>
                                </div>
                            @else
                                <div class="relative h-72 w-full">
                                    <canvas id="chart-{{ $chart['id'] }}" data-chart='@json($chart)'></canvas>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Sugerencia de reabastecimiento (Clase 10) --}}
                @if ($lowStock->isNotEmpty())
                    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-200/80 lg:col-span-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                    <x-icon name="alert" class="h-5 w-5" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">Productos para reabastecer</h3>
                                    <p class="text-xs text-slate-500">Stock menor o igual a 5 unidades</p>
                                </div>
                            </div>

                            <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto mb-4">
                                @foreach ($lowStock as $product)
                                    <div class="flex items-center justify-between py-2.5">
                                        <span class="text-sm font-medium text-slate-700 truncate pe-2">{{ $product->name }}</span>
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $product->stock === 0 ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $product->stock }} un.
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @can('crear-compras')
                            <a href="{{ route('purchases.create') }}" class="w-full text-center rounded-xl bg-slate-900 py-2.5 px-4 text-xs font-semibold text-white shadow transition hover:bg-slate-800">
                                Crear orden de compra
                            </a>
                        @endcan
                    </div>
                @endif

                {{-- Módulos disponibles para el usuario --}}
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-200/80 {{ $lowStock->isNotEmpty() ? 'lg:col-span-2' : 'lg:col-span-3' }} p-6">
                    <h3 class="font-bold text-slate-800 mb-4">Módulos del Sistema</h3>
                    
                    @if ($modules->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 {{ $lowStock->isNotEmpty() ? 'lg:grid-cols-2' : 'lg:grid-cols-3' }} gap-4">
                            @foreach ($modules as $module)
                                <a href="{{ route($module['route']) }}" class="group flex items-start gap-4 rounded-xl border border-slate-200/80 p-4 transition hover:border-brand hover:bg-brand/[0.02]">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand/10 text-brand group-hover:bg-brand group-hover:text-white transition">
                                        <x-icon :name="$module['icon'] ?? 'cube'" class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-slate-800 group-hover:text-brand transition">{{ $module['title'] }}</h4>
                                        <p class="text-xs text-slate-500 mt-1">{{ $module['description'] }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center text-slate-400">
                            <p class="text-sm font-medium">No tienes módulos disponibles.</p>
                            <p class="text-xs mt-1">Pide a un administrador que te asigne un rol.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>