<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use App\Services\SemaphoreSmsService;
    use Illuminate\Support\Facades\Cache;

    class PhoneVerificationNotificationController extends Controller
    {
        /**
         * Send a new phone verification notification.
         */
        public function store(Request $request): RedirectResponse
        {
            // If admin or already verified, redirect appropriately (admins go to admin dashboard)
            $role = strtolower(trim((string)$request->user()->role));
            if ($request->user()->hasVerifiedPhone() || $role === 'admin') {
                return $role === 'admin'
                    ? redirect()->route('admin')
                    : redirect()->route('dashboard');
            }

            // Generate a new 6-digit OTP code
            $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            
            // Avoid logging OTP values in production
            \Illuminate\Support\Facades\Log::info('Resending OTP generated for user: ' . $request->user()->id);
            
            // Store OTP in cache for 10 minutes instead of DB
            Cache::put('otp:verify:' . $request->user()->id, $otpCode, now()->addMinutes(10));

            // Send OTP via Semaphore
            try {
                $sms = new SemaphoreSmsService();
                $message = 'Code: ' . $otpCode;
                $sent = $sms->send($request->user()->phone, $message);
                if (!$sent) {
                    // Surface a user-facing notice if sending failed
                    return back()->with('status', 'verification-sms-failed');
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send Semaphore SMS for resend: ' . $e->getMessage());
                return back()->with('status', 'verification-sms-error');
            }

            // Redirect back with a status message.
            return back()->with('status', 'verification-code-sent');
        }
    }
    