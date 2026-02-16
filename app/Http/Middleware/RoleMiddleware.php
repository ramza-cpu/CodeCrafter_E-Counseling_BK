<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! session('role')) {
            return redirect('/login')->with('error', 'Silakan login dulu');
        }

        if (! in_array(session('role'), $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
