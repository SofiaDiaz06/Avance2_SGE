<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6 text-sm text-emerald-300 text-center font-medium bg-emerald-950/80 py-3.5 px-4 rounded-2xl border border-emerald-800/50 shadow-sm" :status="session('status')" />

    <!-- Encabezado de la Tarjeta -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl mb-4 shadow-xl transform transition-transform hover:scale-105 duration-300" style="background: linear-gradient(135deg, #004e89 0%, #407ba7 100%); border: 1.5px solid rgba(255, 255, 255, 0.3);">
            <x-application-logo class="w-10 h-10 fill-current text-white" />
        </div>
        <h1 class="text-3xl font-extrabold text-white tracking-tight">Distribuidora Paraíso</h1>
        <p class="text-xs uppercase tracking-widest font-bold mt-3 text-white/90">Sistema de Gestión Empresarial</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block font-bold text-xs uppercase tracking-wider text-gray-200">
                Correo Electrónico
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-2xl px-5 py-4 text-base text-white bg-[#001c3f] border border-[#004e89] focus:outline-none focus:ring-2 focus:ring-[#407ba7] focus:border-[#407ba7] transition-all duration-200 placeholder-gray-400 shadow-inner" 
                   placeholder="admin@test.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-400 text-sm font-medium pl-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block font-bold text-xs uppercase tracking-wider text-gray-200">
                Contraseña
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-2xl px-5 py-4 text-base text-white bg-[#001c3f] border border-[#004e89] focus:outline-none focus:ring-2 focus:ring-[#407ba7] focus:border-[#407ba7] transition-all duration-200 placeholder-gray-400 shadow-inner" 
                   placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-red-400 text-sm font-medium pl-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="rounded-md border-[#004e89] bg-[#001c3f] text-[#004e89] shadow-sm focus:ring-[#407ba7] h-4.5 w-4.5 cursor-pointer accent-[#407ba7]">
                <span class="ms-2.5 text-sm text-gray-200 group-hover:text-white transition duration-150 font-medium">Recuérdame</span>
            </label>

            @if (Route::has('password.request'))
                <!-- Cambiado el color a blanco puro para máxima visibilidad -->
                <a href="{{ route('password.request') }}" 
                   class="text-sm font-bold hover:underline transition duration-150 text-white">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" 
                    style="background: linear-gradient(135deg, #0056b3 0%, #003366 100%); border: 1px solid rgba(137, 194, 217, 0.5);"
                    class="w-full py-4 px-4 text-white font-bold text-base rounded-2xl hover:brightness-110 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#407ba7] transition-all duration-200 shadow-xl tracking-wide flex items-center justify-center space-x-2">
                <span>Iniciar Sesión</span>
            </button>
        </div>
    </form>
</x-guest-layout>