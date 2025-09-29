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
        // If the user's phone is already verified or user is admin, redirect to appropriate dashboard.
        $role = strtolower(trim((string)$request->user()->role));
        
        if ($request->user()->hasVerifiedPhone() || $role === 'admin') {
            if ($role === 'admin') {
                return redirect()->route('admin');
            }
            return redirect()->route('dashboard');
        }
        
        return view('auth.verify-phone');
        }
    }
    