<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah user memiliki role kasir/user biasa
        if (!Auth::user()->isKasir()) {
            // Jika bukan kasir, arahkan ke dashboard umum
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
