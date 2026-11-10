<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6 text-sm text-emerald-300 text-center font-medium bg-emerald-950/80 py-3.5 px-4 rounded-2xl border border-emerald-800/50 shadow-sm" :status="session('status')" />

    <!-- Encabezado de la Tarjeta -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-3 shadow-xl transform transition-transform hover:scale-105 duration-300 bg-brand/20 border border-brand/40">
            <x-application-logo class="w-8 h-8 fill-current text-brand" />
        </div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Iniciar sesión</h1>
        <p class="text-xs text-slate-300 mt-1">Ingrese con su correo y contraseña.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="block font-bold text-xs uppercase tracking-wider text-slate-200">
                Correo Electrónico
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-xl px-4 py-3 text-base text-white bg-slate-900/60 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200 placeholder-slate-500 shadow-inner" 
                   placeholder="admin@test.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-sm font-medium pl-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-200">
                Contraseña
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl px-4 py-3 text-base text-white bg-slate-900/60 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200 placeholder-slate-500 shadow-inner" 
                   placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-sm font-medium pl-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="rounded border-slate-700 bg-slate-900 text-brand shadow-sm focus:ring-brand h-4 w-4 cursor-pointer">
                <span class="ms-2 text-sm text-slate-300 group-hover:text-white transition duration-150 font-medium">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm font-medium text-brand-light hover:text-white hover:underline transition duration-150">
                    ¿Olvidó su contraseña?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-3">
            <x-primary-button class="w-full justify-center py-3.5 text-base rounded-xl shadow-lg">
                Ingresar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>