<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }

        $user = Auth::user();

        if (in_array($user->usertype, $roles)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Tidak diizinkan untuk mengakses halaman ini.');
    }
}

