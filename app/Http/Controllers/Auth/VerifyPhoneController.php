<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Auth\Events\Verified; // Still use Verified event, it's generic
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Validation\ValidationException; // For validation errors

    class VerifyPhoneController extends Controller
    {
        /**
         * Mark the authenticated user's phone number as verified.
         */
        public function __invoke(Request $request): RedirectResponse
        {
            // If the user's phone is already verified, redirect to dashboard.
            if ($request->user()->hasVerifiedPhone()) {
                return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
            }

            // Validate the incoming code
            $request->validate([
                'code' => ['required', 'string', 'size:6'], // 6-character code
            ]);

            // Get the expected code from phone_verified_at column
            $expectedCode = $request->user()->phone_verified_at;

            // Check if the provided code matches the expected code
            if ($request->input('code') !== $expectedCode) {
                throw ValidationException::withMessages([
                    'code' => __('The provided verification code is invalid.'),
                ]);
            }

            // Mark the user's phone as verified by setting phone_verified_at to current timestamp
            $request->user()->update(['phone_verified_at' => now()]);
            
            // Dispatch verified event
            event(new Verified($request->user()));

            // Redirect to dashboard after successful verification.
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }
    }
    