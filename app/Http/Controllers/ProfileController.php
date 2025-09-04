<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's profile photo (tourist or otherwise).
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'owner_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        try {
            if ($request->hasFile('owner_image')) {
                $file = $request->file('owner_image');
                $filename = strtolower($user->role) . '_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $destination = public_path('images/profiles');
                if (!is_dir($destination)) {
                    @mkdir($destination, 0775, true);
                }
                $file->move($destination, $filename);
                $user->owner_image_path = 'images/profiles/' . $filename;
                // Tourists don't need approval; owners' photo change should reset approval status
                if ($user->role === 'tourist') {
                    // Tourists: no approval needed, image shows immediately
                } else {
                    // Resort/Boat owners: new photo requires admin approval
                    $user->owner_pic_approved = false;
                }
                $user->save();
            }
        } catch (\Throwable $e) {
            Log::error('Failed to update profile photo: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('status', 'Failed to update photo.');
        }

        return Redirect::route('profile.edit')->with('status', 'Profile photo updated.');
    }
}
