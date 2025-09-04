<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
// REMOVED: Email Verification Controllers
// use App\Http\Controllers\Auth\EmailVerificationNotificationController;
// use App\Http\Controllers\Auth\EmailVerificationPromptController;
// use App\Http\Controllers\Auth\VerifyEmailController;

// ADDED: Phone Verification Controllers
use App\Http\Controllers\Auth\PhoneVerificationNotificationController;
use App\Http\Controllers\Auth\PhoneVerificationPromptController;
use App\Http\Controllers\Auth\VerifyPhoneController;

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Two-step registration
    Route::post('register/step1', [RegisteredUserController::class, 'storeStep1'])
        ->name('register.step1');
    Route::get('register/step2', [RegisteredUserController::class, 'showStep2'])
        ->name('register.step2');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // START: Phone Verification Routes (Replaces Email Verification Routes)
    Route::get('verify-phone', PhoneVerificationPromptController::class)
        ->name('verification.notice'); // This name is used by RedirectIfUnverified middleware

    Route::post('phone/verification-notification', [PhoneVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send'); // This name is used for resending codes

    Route::post('verify-phone', VerifyPhoneController::class)
        ->middleware(['throttle:6,1']) // Add throttle to prevent brute-forcing codes
        ->name('verification.verify'); // This name is used for submitting verification code
    // END: Phone Verification Routes

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
