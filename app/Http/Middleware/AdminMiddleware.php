<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        // Jika Anda tidak menggunakan tabel roles, Anda bisa langsung mengecek apakah pengguna adalah admin berdasarkan kebijakan aplikasi
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return $next($request);
    }
}
