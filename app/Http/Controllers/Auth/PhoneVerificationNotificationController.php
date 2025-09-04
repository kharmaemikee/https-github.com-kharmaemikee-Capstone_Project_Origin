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

            // Send the phone verification notification (this calls the method in User model).
            $request->user()->sendPhoneVerificationNotification();

            // Redirect back with a status message.
            return back()->with('status', 'verification-code-sent');
        }
    }
    