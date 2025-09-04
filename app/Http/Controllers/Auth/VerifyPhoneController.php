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

            // Get the expected code from cache
            $expectedCode = $request->user()->getPhoneVerificationCode();

            // Validate the incoming code
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6'], // Assuming a 6-digit code
            ]);

            // Check if the provided code matches the expected code
            if ($request->input('code') != $expectedCode) {
                throw ValidationException::withMessages([
                    'code' => __('The provided verification code is invalid.'),
                ]);
            }

            // Mark the user's phone as verified.
            if ($request->user()->markPhoneAsVerified()) {
                event(new Verified($request->user())); // Dispatch generic Verified event
                $request->user()->clearPhoneVerificationCode(); // Clear code from cache
            }

            // Redirect to dashboard after successful verification.
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }
    }
    