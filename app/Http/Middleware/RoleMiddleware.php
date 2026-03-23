<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
