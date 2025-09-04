<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User; // Import the User model

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'], // 'login' can be username or phone
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginType = $this->loginType(); // Determine if 'login' is username or phone
        $loginValue = $this->input('login'); // Get the value entered by the user

        // Attempt to find the user based on the determined login type and value.
        // We need to fetch the user first to check their approval status.
        $user = User::where($loginType, $loginValue)->first();

        // Check if a user was found and if they require approval.
        // Only resort_owner and boat_owner roles need approval.
        // Admins and Tourists are considered automatically approved or don't need this check.
        if ($user && in_array($user->role, ['resort_owner', 'boat_owner'])) {
            // Check if user has submitted at least one permit
            $hasSubmittedPermits = $user->bir_permit_path || 
                                  $user->dti_permit_path || 
                                  $user->business_permit_path || 
                                  $user->owner_image_path;
            
            // If user hasn't submitted any permits yet, allow login (they can explore)
            if (!$hasSubmittedPermits) {
                // Allow login - user can explore but main features will be locked
            } else if (!$user->is_approved) {
                // If user has submitted permits but admin hasn't approved, allow login
                // Main features will be locked until admin approval
            }
            // If user has submitted permits AND admin has approved, allow full access
        }

        // Proceed with authentication attempt using the determined login type and password.
        // If the user passed the approval check (or didn't need it), try to log them in.
        $authenticated = Auth::attempt(
            [$loginType => $loginValue, 'password' => $this->input('password')],
            $this->boolean('remember')
        );

        // If authentication failed (e.g., incorrect password, user not found after initial check),
        // apply rate limiting and throw the generic failed message.
        if (! $authenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        // If authentication was successful, clear the rate limiter for this user.
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Determine login field type (username or phone).
     * This method checks if the input is numeric to differentiate between phone and username.
     */
    protected function loginType(): string
    {
        // If the input is entirely numeric, assume it's a phone number.
        // Otherwise, assume it's a username.
        return is_numeric($this->input('login')) ? 'phone' : 'username';
    }

    /**
     * Ensure the login request is not rate limited.
     * This prevents brute-force attacks by limiting the number of login attempts.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Fire a lockout event if too many attempts are made.
        event(new Lockout($this));

        // Get the remaining time before another attempt is allowed.
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Throw a validation exception with a throttle message.
        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     * This generates a unique key based on the login input and IP address.
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('login')) . '|' . $this->ip();
    }
}
