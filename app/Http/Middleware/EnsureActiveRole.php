<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return $next($request);
        }

        if (!$user->active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Su usuario está inactivo. Contacte al administrador.']);
        }

        if ($request->routeIs('active-role.*', 'logout')) {
            return $next($request);
        }

        if ($user->hasMultipleRoles() && !$user->roles->contains('name', session('active_role'))) {
            return redirect()->route('active-role.edit');
        }

        return $next($request);
    }
}