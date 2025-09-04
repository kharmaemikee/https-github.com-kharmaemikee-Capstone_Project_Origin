<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        $user = Auth::user();
    
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
    
        // Optional: redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin');
            case 'resort_owner':
                return redirect()->route('resort.owner.dashboard'); // Changed from 'resort' to 'resort.owner.dashboard'
            case 'boat_owner':
                return redirect()->route('boat.owner.dashboard'); // Changed from 'boat' to 'boat.owner.dashboard'
            case 'tourist':
                return redirect()->route('tourist.tourist'); // Changed from 'tourist' to 'tourist.tourist'
            default:
                abort(403, 'Unauthorized');
        }
    }
    
}
