<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            return match (auth()->user()->role) {
                'admin'   => redirect('/admin/dashboard'),
                'judge'   => redirect('/judge/dashboard'),
                'lawyer'  => redirect('/lawyer/dashboard'),
                'citizen' => redirect('/citizen/dashboard'),
                default   => redirect('/dashboard'),
            };
        }

        return $next($request);
    }
}
