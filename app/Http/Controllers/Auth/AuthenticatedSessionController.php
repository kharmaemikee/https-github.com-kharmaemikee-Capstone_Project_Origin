<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate the session
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Redirect to the specific dashboard based on user role
        // It's good practice to encapsulate this logic, e.g., in the User model,
        // but for now, it's fine here.
        return match ($user->role) {
            'admin' => redirect()->route('admin'),
            'resort_owner' => redirect()->route('resort.owner.dashboard'), // Changed from 'resort' to 'resort.owner.dashboard'
            'boat_owner' => redirect()->route('boat.owner.dashboard'),     // Changed from 'boat' to 'boat.owner.dashboard'
            'tourist' => redirect()->route('tourist.tourist'),     // Assuming 'tourist.tourist' is a named route
            default => redirect()->route('dashboard'),    // Default fallback
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Clear any booking-related session data before logout
        $request->session()->forget([
            'intended_room_id', 
            'current_user_id',
            'booking_data'
        ]);
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}