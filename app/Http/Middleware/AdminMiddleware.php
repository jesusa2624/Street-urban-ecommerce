<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('web')->check()) {
            abort(401, 'No autenticado');
        }

        $user = auth('web')->user();

        if (!($user instanceof \App\Models\User) || !$user->isStaff()) {
            abort(403, 'No tienes permiso para acceder al panel de administración');
        }

        return $next($request);
    }
}
