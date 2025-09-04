<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
        ]);

        $loginField = ctype_digit($request->input('login')) ? 'phone' : 'username';
        $loginValue = $request->input('login');

        $user = User::where($loginField, $loginValue)->first();

        if (!$user) {
            return back()->withInput($request->only('login'))
                         ->withErrors(['login' => trans('passwords.user')]);
        }

        $status = Password::sendResetLink(
            [$loginField => $loginValue]
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('login'))
                ->withErrors(['login' => __($status)]);
    }
}
