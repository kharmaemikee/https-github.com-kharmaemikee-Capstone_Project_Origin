<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;

    class PhoneVerificationNotificationController extends Controller
    {
        /**
         * Send a new phone verification notification.
         */
        public function store(Request $request): RedirectResponse
        {
            // If the user's phone is already verified, redirect to dashboard.
            if ($request->user()->hasVerifiedPhone()) {
                return redirect()->intended(route('dashboard', absolute: false));
            }

            // Generate a new 6-digit OTP code
            $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            
            // Debug: Log the new OTP being generated
            \Illuminate\Support\Facades\Log::info('Resending OTP for user: ' . $request->user()->id . ', New OTP: ' . $otpCode);
            
            // Store OTP in phone_verified_at column temporarily
            $request->user()->update(['phone_verified_at' => $otpCode]);
            
            // Debug: Log the updated user's phone_verified_at value
            \Illuminate\Support\Facades\Log::info('User updated with new phone_verified_at: ' . $request->user()->fresh()->phone_verified_at);

            // Redirect back with a status message.
            return back()->with('status', 'verification-code-sent');
        }
    }
    