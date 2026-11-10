<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Configuración — Seguridad
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Aviso informativo sobre permisos --}}
            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200/80 text-sm text-slate-600 flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand/10 text-brand">
                    <x-icon name="shield-check" class="h-5 w-5" />
                </div>
                <div>
                    <strong class="text-slate-800">¿Cómo se calculan los permisos?</strong>
                    <p class="mt-0.5">Permisos efectivos = permisos del <strong>rol activo</strong> + permisos <strong>directos</strong> del usuario. Un usuario con varios roles elige con cuál trabajar al iniciar sesión.</p>
                </div>
            </div>

            {{-- Tarjetas de Configuración --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @can('ver-usuarios')
                    <a href="{{ route('settings.users.index') }}" class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 transition hover:border-brand hover:shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-brand group-hover:text-white transition">
                                    <x-icon name="users" class="h-5 w-5" />
                                </div>
                                <span class="text-2xl font-extrabold text-slate-800">{{ $usersCount }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 group-hover:text-brand transition">Usuarios</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $inactiveCount }} inactivos · {{ $multiRoleCount }} con varios roles</p>
                        </div>
                    </a>
                @endcan

                @can('ver-roles')
                    <a href="{{ route('settings.roles.index') }}" class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 transition hover:border-brand hover:shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600 group-hover:bg-brand group-hover:text-white transition">
                                    <x-icon name="shield-check" class="h-5 w-5" />
                                </div>
                                <span class="text-2xl font-extrabold text-slate-800">{{ $rolesCount }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 group-hover:text-brand transition">Roles</h3>
                            <p class="text-xs text-slate-500 mt-1">Perfiles de trabajo y sus permisos.</p>
                        </div>
                    </a>
                @endcan

                @can('ver-permisos')
                    <a href="{{ route('settings.permissions.index') }}" class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 transition hover:border-brand hover:shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600 group-hover:bg-brand group-hover:text-white transition">
                                    <x-icon name="clipboard-document-list" class="h-5 w-5" />
                                </div>
                                <span class="text-2xl font-extrabold text-slate-800">{{ $permissionsCount }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 group-hover:text-brand transition">Matriz de permisos</h3>
                            <p class="text-xs text-slate-500 mt-1">Permisos por rol, módulo y usuario.</p>
                        </div>
                    </a>
                @endcan

                {{-- Configuración visual: nombre, logo, NIT, razón social y color de marca --}}
                @can('ver-branding')
                    <a href="{{ route('settings.branding.edit') }}" class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 transition hover:border-brand hover:shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-brand group-hover:text-white transition">
                                    <x-icon name="paint-brush" class="h-5 w-5" />
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($branding->logoUrl())
                                        <img src="{{ $branding->logoUrl() }}" alt="Logo" class="h-8 w-8 rounded-lg object-contain bg-slate-100 p-0.5 border border-slate-200">
                                    @endif
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-800 group-hover:text-brand transition">Identidad corporativa</h3>
                            <p class="text-xs text-slate-500 mt-1">
                                <span class="font-semibold text-slate-700">{{ $branding->trade_name }}</span><br>
                                NIT {{ $branding->nit }}
                            </p>
                        </div>
                        <p class="text-xs text-slate-400 mt-4 pt-3 border-t border-slate-100">Nombre, logo, razón social y color de marca.</p>
                    </a>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>