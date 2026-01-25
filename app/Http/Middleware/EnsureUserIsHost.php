<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsHost
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'host') {
            return redirect()->route('home')->with('error', 'You must be a host to access this page.');
        }

        return $next($request);
    }
}