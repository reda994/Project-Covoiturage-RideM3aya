<?php

// app/Http/Middleware/RoleMiddleware.php

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
        
        foreach ($roles as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }
        
        abort(403, 'Accès non autorisé.');
    }
}