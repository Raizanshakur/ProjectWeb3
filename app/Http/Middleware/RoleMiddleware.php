<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pastikan user yang terautentikasi memiliki salah satu role yang diizinkan.
     *
     * Penggunaan di route: middleware('role:parent') atau middleware('role:doctor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
