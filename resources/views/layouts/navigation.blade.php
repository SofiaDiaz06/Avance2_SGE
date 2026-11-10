{{-- ============================================================
     MENÚ LATERAL (sidebar): fijo en pantallas grandes y desplegable en celulares.
     Cada enlace aparece solo si el usuario tiene el permiso (@can).
     ============================================================ --}}

{{-- Fondo oscuro detrás del menú cuando se abre en el celular --}}
<div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

{{-- Oculto a la izquierda en el celular; !translate-x-0 (con prioridad) lo muestra al abrirlo --}}
<aside class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-slate-900 border-r border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    {{-- Marca: logo, nombre comercial y eslogan --}}
    <div class="flex h-16 shrink-0 items-center justify-between px-6 border-b border-slate-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="block h-9 w-auto text-white" />
            <div class="flex flex-col">
                <span class="font-bold text-white tracking-wide text-base leading-tight">{{ $branding->trade_name }}</span>
                @if ($branding->slogan)
                    <span class="text-[11px] text-slate-400 font-medium truncate max-w-[170px]">{{ $branding->slogan }}</span>
                @endif
            </div>
        </a>
        <button type="button" @click="sidebarOpen = false" class="rounded-md p-1 text-slate-400 hover:text-white lg:hidden">
            <x-icon name="x-mark" class="h-6 w-6" />
        </button>
    </div>

    {{-- Enlaces agrupados por área de la empresa --}}
    <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-6">
        <div>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
                {{ __('Dashboard') }}
            </x-nav-link>
        </div>

        {{-- Inventario --}}
        @canany(['ver-productos', 'ver-categorias', 'ver-inventario'])
            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Inventario</p>
                @can('ver-productos')
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" icon="cube">
                        Productos
                    </x-nav-link>
                @endcan
                @can('ver-categorias')
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="tag">
                        Categorías
                    </x-nav-link>
                @endcan
                @can('ver-inventario')
                    <x-nav-link :href="route('inventory.kardex')" :active="request()->routeIs('inventory.*')" icon="clipboard-document-list">
                        Kardex
                    </x-nav-link>
                @endcan
            </div>
        @endcanany

        {{-- Comercial --}}
        @canany(['ver-clientes', 'ver-ventas'])
            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Comercial</p>
                @can('ver-clientes')
                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" icon="users">
                        Clientes
                    </x-nav-link>
                @endcan
                @can('ver-ventas')
                    <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')" icon="shopping-cart">
                        Ventas
                    </x-nav-link>
                @endcan
            </div>
        @endcanany

        {{-- Abastecimiento --}}
        @canany(['ver-proveedores', 'ver-compras'])
            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Abastecimiento</p>
                @can('ver-proveedores')
                    <x-nav-link :href="route('providers.index')" :active="request()->routeIs('providers.*')" icon="truck">
                        Proveedores
                    </x-nav-link>
                @endcan
                @can('ver-compras')
                    <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')" icon="shopping-bag">
                        Compras
                    </x-nav-link>
                @endcan
            </div>
        @endcanany

        {{-- Administración --}}
        @canany(['ver-auditoria', 'ver-usuarios', 'ver-roles', 'ver-permisos', 'ver-branding'])
            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Administración</p>
                @can('ver-auditoria')
                    <x-nav-link :href="route('audit.index')" :active="request()->routeIs('audit.*')" icon="shield-check">
                        Auditoría
                    </x-nav-link>
                @endcan
                @canany(['ver-usuarios', 'ver-roles', 'ver-permisos'])
                    <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" icon="cog-6-tooth">
                        Configuración
                    </x-nav-link>
                @endcanany
                @can('ver-branding')
                    <x-nav-link :href="route('settings.branding.edit')" :active="request()->routeIs('settings.branding.*')" icon="paint-brush">
                        Identidad corporativa
                    </x-nav-link>
                @endcan
            </div>
        @endcanany
    </nav>

    {{-- Opciones del usuario en pantallas pequeñas --}}
    <div class="border-t border-slate-800 p-4 lg:hidden">
        <div class="px-2 pb-2">
            <div class="font-semibold text-sm text-white">{{ Auth::user()->name }}</div>
            <div class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-2 space-y-1">
            @if (Auth::user()->hasMultipleRoles())
                <x-responsive-nav-link :href="route('active-role.edit')">
                    Cambiar rol
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('profile.edit')">
                Mi perfil
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    Cerrar sesión
                </x-responsive-nav-link>
            </form>
        </div>
    </div>

    <div class="border-t border-slate-800 px-6 py-4 text-center text-xs text-slate-500">
        © {{ date('Y') }} {{ $branding->legal_name }}
    </div>
</aside>

{{-- ============================================================
     BARRA SUPERIOR: botón del menú (celular), título de la página y usuario.
     ============================================================ --}}
<div class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur lg:pl-72">
    <div class="flex min-h-[4rem] items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <button type="button" @click="sidebarOpen = true" class="-ms-1 rounded-md p-1 text-slate-500 hover:text-slate-800 lg:hidden" aria-label="Abrir menú">
            <x-icon name="menu" class="h-6 w-6" />
        </button>

        {{-- Título de la página (slot «header» de cada vista) --}}
        <div class="min-w-0 flex-1">
            @isset($header)
                {{ $header }}
            @endisset
        </div>

        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-3 rounded-full py-1 pe-2 ps-1 text-start transition hover:bg-slate-100 focus:outline-none">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand/10 text-sm font-bold text-brand">
                            {{ Str::of(Auth::user()->name)->substr(0, 1)->upper() }}
                        </span>
                        <span class="hidden md:block">
                            <span class="block text-sm font-semibold leading-tight text-slate-800">{{ Auth::user()->name }}</span>
                            @if ($activeRole = Auth::user()->activeRole())
                                <span class="block text-xs capitalize leading-tight text-brand">{{ $activeRole->name }}</span>
                            @endif
                        </span>
                        <x-icon name="chevron-down" class="h-4 w-4 text-slate-400" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    @if (Auth::user()->hasMultipleRoles())
                        <x-dropdown-link :href="route('active-role.edit')">
                            Cambiar rol
                        </x-dropdown-link>
                    @endif
                    <x-dropdown-link :href="route('profile.edit')">
                        Mi perfil
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>