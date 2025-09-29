<?php
namespace App\Http\Controllers\ResortOwner;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ResortController extends Controller
{
    /**
     * Display the resort information and rooms for the authenticated user.
     */
    public function index()
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }

        // Check if user has verified their phone (skip for admin users)
        // if (!Auth::user()->hasVerifiedPhone() && Auth::user()->role !== 'admin') {
        //     return redirect()->route('verification.notice');
        // }
        
        $resort = Auth::user()->resorts()->first();
        
        if (!$resort) {
            // This shouldn't happen since resorts are created automatically on registration
            abort(404, 'Resort not found.');
        }
        
        // Get rooms for this resort (only non-archived)
        $rooms = $resort->rooms()->notArchived()->orderBy('room_name')->get();
        
        // Get unread notifications count for sidebar badge
        $unreadCount = \App\Models\ResortOwnerNotification::where('user_id', Auth::id())
                                                            ->where('is_read', false)
                                                            ->count();
        
        return view('resort_owner.resort-information', compact('resort', 'rooms', 'unreadCount')); 
    }

    /**
     * Show the form for editing the specified resort.
     */
    public function edit(Resort $resort)
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Get unread notification count
        $unreadCount = \App\Models\ResortOwnerNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('resort_owner.edit-resort', compact('resort', 'unreadCount'));
    }

    /**
     * Update the specified resort in storage.
     */
    public function update(Request $request, Resort $resort)
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'resort_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_number' => 'required|string|regex:/^[0-9]{11}$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook_page_link' => 'nullable|url|max:255',
        ], [
            'contact_number.regex' => 'The number is not enough. Please enter exactly 11 digits.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($resort->image_path && file_exists(public_path($resort->image_path))) {
                @unlink(public_path($resort->image_path));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . uniqid('', true) . '.' . $file->getClientOriginalExtension();
            $destination = public_path('image');
            if (!is_dir($destination)) {
                @mkdir($destination, 0775, true);
            }
            $file->move($destination, $filename);
            $validatedData['image_path'] = 'image/' . $filename;
        }

        $resort->update($validatedData);

        return redirect()->route('resort.owner.information')->with('success', 'Resort information updated successfully!');
    }

    /**
     * Update the resort status (open, closed, maintenance).
     */
    public function updateStatus(Request $request, Resort $resort)
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['open', 'closed', 'maintenance'])],
            'rehab_reason' => ['nullable', 'string', 'max:500'],
        ]);

        // If status is not maintenance, clear rehab_reason
        if ($validatedData['status'] !== 'maintenance') {
            $validatedData['rehab_reason'] = null;
        }

        $resort->update($validatedData);

        return redirect()->route('resort.owner.information')->with('success', 'Resort status updated successfully!');
    }

    /**
     * Remove the specified resort from storage.
     */
    public function destroy(Resort $resort)
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the resort (this will cascade delete rooms and other related data)
        $resort->delete();

        return redirect()->route('resort.owner.information')->with('success', 'Resort deleted successfully!');
    }
}