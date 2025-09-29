<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithPhone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has verified their phone (skip for admin users)
        if (!Auth::user()->hasVerifiedPhone() && Auth::user()->role !== 'admin') {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
