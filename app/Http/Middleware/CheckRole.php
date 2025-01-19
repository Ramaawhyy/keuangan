<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan namespace Auth ditambahkan

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan auth()->user() tidak null
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}

