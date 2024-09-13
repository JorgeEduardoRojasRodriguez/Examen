<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUrlIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // validar si es localhost:4211
        if ($request->url() === 'http://localhost:4211') {
            return response()->json(['error' => 'No se puede acceder a esta URL'], 403);
        }
 
        return $next($request);
    }
}
