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

        // Clear any stale intended URL and verification-related session data
        $request->session()->forget([
            'url.intended',
            'password_reset_user_id',
            'register_step1',
            'booking_data',
            'intended_room_id',
            'current_user_id'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Immediate admin redirect to admin dashboard view (admin/admin.blade.php)
        if (strtolower(trim((string)$user->role)) === 'admin') {
            return redirect()->route('admin');
        }

        // Enforce phone verification for non-admin users (case-insensitive, trimmed role check)
        if (!$user->hasVerifiedPhone()) {
            return redirect()->route('verification.notice');
        }

        // Redirect to the specific dashboard based on user role
        $role = strtolower(trim((string)$user->role));
        return match ($role) {
            'resort_owner' => redirect()->route('resort.owner.dashboard'),
            'boat_owner' => redirect()->route('boat.owner.dashboard'),
            'tourist' => redirect()->route('tourist.tourist'),
            default => redirect()->route('dashboard'),
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