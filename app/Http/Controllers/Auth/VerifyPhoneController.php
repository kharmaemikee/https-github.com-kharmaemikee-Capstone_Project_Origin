<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Validation\ValidationException; // For validation errors
    use Illuminate\Support\Facades\Cache;

    class VerifyPhoneController extends Controller
    {
        /**
         * Mark the authenticated user's phone number as verified.
         */
        public function __invoke(Request $request): RedirectResponse
        {
            // If the user's phone is already verified or user is admin, redirect to dashboard.
            if ($request->user()->hasVerifiedPhone() || strtolower(trim((string)$request->user()->role)) === 'admin') {
                return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
            }

            // Validate the incoming code
            $request->validate([
                'code' => ['required', 'string', 'size:6'], // 6-character code
            ]);

            // Get the expected code from cache
            $expectedCode = Cache::get('otp:verify:' . $request->user()->id);

            // Check if the provided code matches the expected code
            if ($request->input('code') !== $expectedCode) {
                throw ValidationException::withMessages([
                    'code' => __('The provided verification code is invalid.'),
                ]);
            }

            // Mark the user's phone as verified by setting phone_verified_at to current timestamp
            $request->user()->update(['phone_verified_at' => now()]);
            // Clear cached OTP
            Cache::forget('otp:verify:' . $request->user()->id);
            
            // We do not dispatch the email Verified event for phone verification

            // Redirect to dashboard after successful verification.
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1')->with('phone_verified_success', true);
        }
    }
    