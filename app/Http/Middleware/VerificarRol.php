<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if ($request->user() && $request->user()->hasAnyRole(...$roles)) {
            return $next($request);
        }

        return response()->json(['error' => 'No tienes permiso para acceder a esta ruta.'], 403);
    }
}
