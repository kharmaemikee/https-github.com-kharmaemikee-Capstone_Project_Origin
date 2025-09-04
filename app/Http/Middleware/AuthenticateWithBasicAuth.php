<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth as BaseAuthenticateWithBasicAuth;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithBasicAuth extends BaseAuthenticateWithBasicAuth
{
    /**
     * The authentication guard used to authenticate users.
     *
     * @var string|null
     */
    protected $guard = null;

    /**
     * Authenticate the user using basic HTTP authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @param  string|null  $username
     * @param  string|null  $password
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function authenticate($request, $guard, $username = null, $password = null)
    {
        if (Auth::onceBasic()) {
            return Auth::user();
        }

        return null; // Or handle unauthorized response as needed
    }
}