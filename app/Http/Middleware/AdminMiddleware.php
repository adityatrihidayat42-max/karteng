<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        /** @var \App\Models\User $user */ // Tambahkan baris ini
        $user = Auth::user();
        
<<<<<<< HEAD
        if (!$user->hasAnyRole(['admin', 'pengurus'])) {
=======
        if (!$user->hasAnyRole($roles ?: ['admin', 'pengurus'])) {
>>>>>>> c62801866525755a687e5889f7ab1e1b07a93a37
            abort(403, 'Anda tidak memiliki hak akses ke halaman administrator.');
        }

        return $next($request);
    }
}