<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && $request->is('/')) {
            if (auth()->user()->role == true) {
                return redirect('/dashboard');
            }
            return redirect('/sales');
        }

        return $next($request);
    }
}