<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah user login dan apakah role-nya adalah admin
        if (Auth::check() && strtolower(Auth::user()->role) === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang ke katalog dengan pesan peringatan
        return redirect()->route('pelanggan.index')->with('error', 'Maaf Bos, halaman ini khusus area Admin!');
    }
}