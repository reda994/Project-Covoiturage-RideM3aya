<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Si l'utilisateur n'est pas actif, le déconnecter et rediriger
        if (!$request->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Votre compte a été désactivé.');
        }

        // L'admin a accès à tout
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // Vérification des rôles passés en paramètres
        foreach ($roles as $role) {
            if ($role === 'driver' && $request->user()->isDriver()) {
                return $next($request);
            }
            if ($role === 'passenger' && $request->user()->isPassenger()) {
                return $next($request);
            }
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'Accès non autorisé.');
    }
}