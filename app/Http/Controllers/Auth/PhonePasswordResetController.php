<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PhonePasswordResetController extends Controller
{
    /**
     * Show the phone password reset request form.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send OTP code for password reset.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
        ], [
            'phone_number.regex' => 'Please enter exactly 11 digits for the phone number.',
        ]);

        $user = User::where('phone', $request->phone_number)->first();

        if (!$user) {
            return back()->withInput($request->only('phone_number'))
                         ->withErrors(['phone_number' => 'No user found with this phone number.']);
        }

        // Generate a 6-digit OTP code for password reset
        $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in phone_verified_at column temporarily
        $user->update(['phone_verified_at' => $otpCode]);
        
        // Debug: Log the OTP being generated
        Log::info('Password reset OTP for user: ' . $user->id . ', OTP: ' . $otpCode);

        return redirect()->route('password.reset.verify')->with('status', 'verification-code-sent');
    }

    /**
     * Show the OTP verification form.
     */
    public function showVerifyForm(): View
    {
        return view('auth.verify-password-reset');
    }

    /**
     * Verify OTP and show password change option.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('phone', $request->phone_number)->first();

        if (!$user) {
            return back()->withErrors(['phone_number' => 'No user found with this phone number.']);
        }

        // Check if the provided code matches the stored OTP
        if ($request->input('code') !== $user->phone_verified_at) {
            return back()->withErrors(['code' => 'The provided verification code is invalid.']);
        }

        // Store user ID in session for password reset
        session(['password_reset_user_id' => $user->id]);

        return redirect()->route('password.reset.confirm');
    }

    /**
     * Show password change confirmation.
     */
    public function showConfirmForm(): View
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('password.request');
        }

        return view('auth.confirm-password-reset');
    }

    /**
     * Handle password change confirmation.
     */
    public function confirmPasswordChange(Request $request): RedirectResponse
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('password.request');
        }

        $user = User::find(session('password_reset_user_id'));

        if (!$user) {
            return redirect()->route('password.request');
        }

        if ($request->action === 'yes') {
            // Store user ID for password reset form (keep session for password reset)
            return redirect()->route('password.reset.form');
        } else {
            // User chose "Not now", redirect to login
            session()->forget('password_reset_user_id');
            return redirect()->route('login')->with('status', 'Password reset cancelled. You can try again later.');
        }
    }
}
