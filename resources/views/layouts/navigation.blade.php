<nav x-data="{ open: false }" style="background-color: #00043a; border-bottom: 2px solid #004e89;" class="shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Módulos con distribución uniforme -->
            <div class="flex items-center flex-1 me-6">
                <div class="hidden sm:flex items-center justify-between w-full">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('dashboard') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                        <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>

                    <!-- Categorías -->
                    @if(App\Models\Module::isActive('categories') && auth()->user()->can('ver-categorias'))
                        <a href="{{ route('categories.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('categories.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Categorías
                        </a>
                    @endif

                    <!-- Productos -->
                    @if(App\Models\Module::isActive('products') && auth()->user()->can('ver-productos'))
                        <a href="{{ route('products.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('products.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Productos
                        </a>
                    @endif

                    <!-- Clientes -->
                    @if(App\Models\Module::isActive('clients') && auth()->user()->can('ver-clientes'))
                        <a href="{{ route('clients.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('clients.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Clientes
                        </a>
                    @endif

                    <!-- Proveedores -->
                    @if(App\Models\Module::isActive('providers') && auth()->user()->can('ver-proveedores'))
                        <a href="{{ route('providers.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('providers.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            Proveedores
                        </a>
                    @endif

                    <!-- Ventas -->
                    @if(App\Models\Module::isActive('sales') && auth()->user()->can('ver-ventas'))
                        <a href="{{ route('sales.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('sales.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Ventas
                        </a>
                    @endif

                    <!-- Compras -->
                    @if(App\Models\Module::isActive('purchases') && auth()->user()->can('ver-compras'))
                        <a href="{{ route('purchases.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('purchases.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            <svg class="w-4 h-4 me-1.5" style="color: #407ba7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Compras
                        </a>
                    @endif

                    <!-- Configuración -->
                    @canany(['ver-usuarios', 'ver-roles', 'ver-permisos'])
                        <a href="{{ route('settings.index') }}" style="color: #ffffff;" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out hover:bg-[#004e89] {{ request()->routeIs('settings.*') ? 'border-b-2 border-[#407ba7] bg-[#004e89]' : '' }}">
                            Configuración
                        </a>
                    @endcanany
                </div>
            </div>

            <!-- Settings Dropdown (Botón de Usuario optimizado) -->
            <div class="hidden sm:flex sm:items-center shrink-0">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button style="background-color: #004e89; border: 1px solid #407ba7; color: #ffffff;" 
                                class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg hover:bg-[#407ba7] focus:outline-none transition ease-in-out duration-150 shadow-md">
                            <div class="text-left min-w-[130px]">
                                <div class="font-bold text-sm leading-tight text-white">{{ Auth::user()->name }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-red-200 bg-[#800016] px-1.5 py-0.5 rounded">
                                        {{ Auth::user()->getRoleNames()->first() ?: 'USER' }}
                                    </span>
                                    @if ($activeRole = Auth::user()->activeRole())
                                        <span class="text-[11px] font-medium capitalize text-blue-100">
                                            ({{ $activeRole->name }})
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ms-3">
                                <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l4 4a1 1 0 01-0.707 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Auth::user()->hasMultipleRoles())
                            <x-dropdown-link :href="route('active-role.edit')">
                                Cambiar rol
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-start block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button for Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-[#004e89] focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background-color: #00043a; border-top: 1px solid #004e89;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(App\Models\Module::isActive('categories') && auth()->user()->can('ver-categorias'))
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-white">
                    {{ __('Categorías') }}
                </x-responsive-nav-link>
            @endif

            @if(App\Models\Module::isActive('products') && auth()->user()->can('ver-productos'))
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-white">
                    {{ __('Productos') }}
                </x-responsive-nav-link>
            @endif

            @if(App\Models\Module::isActive('clients') && auth()->user()->can('ver-clientes'))
                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" class="text-white">
                    {{ __('Clientes') }}
                </x-responsive-nav-link>
            @endif

            @if(App\Models\Module::isActive('providers') && auth()->user()->can('ver-proveedores'))
                <x-responsive-nav-link :href="route('providers.index')" :active="request()->routeIs('providers.*')" class="text-white">
                    {{ __('Proveedores') }}
                </x-responsive-nav-link>
            @endif

            @if(App\Models\Module::isActive('sales') && auth()->user()->can('ver-ventas'))
                <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')" class="text-white">
                    {{ __('Ventas') }}
                </x-responsive-nav-link>
            @endif

            @if(App\Models\Module::isActive('purchases') && auth()->user()->can('ver-compras'))
                <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')" class="text-white">
                    {{ __('Compras') }}
                </x-responsive-nav-link>
            @endif

            @canany(['ver-usuarios', 'ver-roles', 'ver-permisos'])
                <x-responsive-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" class="text-white">
                    {{ __('Configuración') }}
                </x-responsive-nav-link>
            @endcanany
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#004e89]">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-300">{{ Auth::user()->email }}</div>
                @if ($activeRole = Auth::user()->activeRole())
                    <div class="mt-0.5 text-xs font-normal capitalize text-teal-300">{{ $activeRole->name }}</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                @if (Auth::user()->hasMultipleRoles())
                    <x-responsive-nav-link :href="route('active-role.edit')" class="text-white">
                        {{ __('Cambiar rol') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>