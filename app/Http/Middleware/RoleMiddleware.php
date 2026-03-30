<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized.');
        }

        // Enforcement: Ensure user account is not frozen (Admins are exempt)
        if (!$request->user()->is_active && !$request->user()->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Your access has been suspended. Please contact administrator.');
        }

        if ($role === 'admin' && !$request->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        if ($role === 'trainer' && !$request->user()->isTrainer()) {
            abort(403, 'Unauthorized. Trainer access required.');
        }

        if ($role === 'student' && !$request->user()->isStudent()) {
            abort(403, 'Unauthorized. Student access required.');
        }

        return $next($request);
    }
}
