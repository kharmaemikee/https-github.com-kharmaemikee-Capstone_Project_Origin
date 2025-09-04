<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class PhoneVerificationPromptController extends Controller
    {
        /**
         * Display the phone verification prompt.
         */
        public function __invoke(Request $request): RedirectResponse|View
        {
            // If the user's phone is already verified, redirect to dashboard.
            return $request->user()->hasVerifiedPhone()
                            ? redirect()->intended(route('dashboard', absolute: false))
                            : view('auth.verify-phone'); // We will create this view
        }
    }
    