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
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        /** @var \App\Models\User $user */ // Tambahkan baris ini
        $user = Auth::user();
        
        if (!$user->hasAnyRole(['admin', 'pengurus'])) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman administrator.');
        }

        return $next($request);
    }
}