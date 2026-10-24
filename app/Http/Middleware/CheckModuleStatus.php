<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Module;

class CheckModuleStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleKey): Response
    {
        // Valida si el módulo está activo usando el método que creamos en el modelo
        if (!Module::isActive($moduleKey)) {
            // Si está apagado, redirige al dashboard con una advertencia
            return redirect('/dashboard')->with('error', 'El módulo solicitado se encuentra desactivado.');
        }

        return $next($request);
    }
}