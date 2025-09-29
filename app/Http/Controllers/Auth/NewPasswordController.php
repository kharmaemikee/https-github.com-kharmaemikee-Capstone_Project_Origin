<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        // Check if this is a phone-based password reset
        if (session('password_reset_user_id')) {
            $user = User::find(session('password_reset_user_id'));
            if ($user) {
                return view('auth.reset-password-phone', ['user' => $user]);
            }
        }
        
        // Handle traditional token-based password reset
        return view('auth.reset-password', [
            'request' => $request, 
            'username' => $request->get('username', '')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Handle phone-based password reset
        if (session('password_reset_user_id')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::find(session('password_reset_user_id'));
            
            if (!$user) {
                return redirect()->route('password.request');
            }

            // Update password only - do NOT auto-verify phone
            $user->update([
                'password' => Hash::make($request->password),
                // phone_verified_at should remain null - user must verify phone after login
            ]);

            // Clear session
            session()->forget('password_reset_user_id');

            // DO NOT auto-login the user - they must verify phone first
            // auth()->login($user); // REMOVED - user must verify phone before login

            return redirect()->route('login')->with('status', 'Password has been reset successfully! Please login and verify your phone number.');
        }

        // Handle traditional token-based password reset
        $request->validate([
            'token' => ['required'],
            'username' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('username', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('username'))
                ->withErrors(['username' => __($status)]);
    }
}
