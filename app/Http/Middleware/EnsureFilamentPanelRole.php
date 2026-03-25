<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureFilamentPanelRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        $prefix = trim($request->segment(1) ?? '', '/');

        if ($prefix === 'super-admin' && ! $user->hasRole('Super Admin')) {
            abort(403, 'Only Super Admin can access this panel.');
        }

        if ($prefix === 'admin' && ! $user->hasAnyRole('Admin')) {
            abort(403, 'Only Admin can access this panel.');
        }

        if ($prefix === 'warehouse' && ! $user->hasRole('Warehouse Staff')) {
            abort(403, 'Only Warehouse Staff can access this panel.');
        }

        return $next($request);
    }
}
