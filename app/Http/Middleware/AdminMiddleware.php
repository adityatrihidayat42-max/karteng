<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        if (!$user->hasAnyRole(['admin', 'pengurus']) && $user->email !== 'admin@nu.or.id') {
            abort(403, 'Anda tidak memiliki hak akses ke halaman administrator.');
        }

        return $next($request);
    }
}
