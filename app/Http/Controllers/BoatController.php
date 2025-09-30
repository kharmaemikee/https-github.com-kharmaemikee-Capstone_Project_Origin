<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatOwnerNotification; // NEW: Import the new notification model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class BoatController extends Controller
{
    /**
     * Display a listing of the boats for the authenticated boat owner.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = Auth::user();
        if ($user->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }

        // Check if user has verified their phone (skip for admin users)
        // if (!$user->hasVerifiedPhone() && $user->role !== 'admin') {
        //     return redirect()->route('verification.notice');
        // }

        // Ensure that only boats belonging to the authenticated boat owner are fetched
        // Show oldest first so newly added boats appear at the end
        $boats = $user->boats()->notArchived()->orderBy('created_at', 'asc')->get();

        // ADDED: Get unread notifications count for sidebar badge
        $unreadCount = BoatOwnerNotification::where('user_id', $user->id)
                                                        ->where('is_read', false)
                                                        ->count();

        return view('boat_owner.boat', compact('boats', 'unreadCount'));
    }

    /**
     * Show the form for creating a new boat.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        if (Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }
        
        // Get unread notifications count for sidebar badge
        $unreadCount = BoatOwnerNotification::where('user_id', Auth::id())
                                            ->where('is_read', false)
                                            ->count();
        
        return view('boat_owner.addboat', compact('unreadCount')); // Ensure this matches your file name addboat.blade.php
    }

    /**
     * Store a newly created boat in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'boat_name' => 'required|string|max:255',
            'boat_prices' => 'required|numeric|min:0',
            'boat_capacities' => 'required|integer|min:1',
            'boat_length' => 'nullable|string|max:50',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'captain_name' => 'nullable|string|max:255',
            'captain_contact' => 'nullable|string|regex:/^[0-9]{11}$/',
        ], [
            'captain_contact.regex' => 'The number is not enough. Please enter exactly 11 digits.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = 'boat_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('image');
            if (!is_dir($destination)) {
                @mkdir($destination, 0775, true);
            }
            $file->move($destination, $filename);
            $imagePath = 'image/' . $filename;
        }

        $createData = [
            'boat_name' => $validated['boat_name'],
            'boat_prices' => $validated['boat_prices'],
            'boat_capacities' => $validated['boat_capacities'],
            'image_path' => $imagePath,
            'status' => Boat::STATUS_PENDING, // Always set to pending on creation
        ];
        if (Schema::hasColumn('boats', 'boat_length')) {
            $createData['boat_length'] = $validated['boat_length'] ?? null;
        }
        $boat = Auth::user()->boats()->create($createData);

        // Conditionally persist captain fields if columns exist
        try {
            $dirty = false;
            if (Schema::hasColumn('boats', 'captain_name') && $request->filled('captain_name')) {
                $boat->captain_name = $request->input('captain_name');
                $dirty = true;
            }
            if (Schema::hasColumn('boats', 'captain_contact') && $request->filled('captain_contact')) {
                $boat->captain_contact = $request->input('captain_contact');
                $dirty = true;
            }
            if ($dirty) {
                $boat->save();
            }
        } catch (\Throwable $e) {
            // Ignore silently if schema not ready; prevents crashes before migration
        }

        return redirect()->route('boat')->with('success', 'Boat added successfully. It is now pending admin approval.');
    }

    /**
     * Show the form for editing the specified boat.
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\View\View
     */
    public function edit(Boat $boat): View
    {
        if (Auth::id() !== $boat->user_id || Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }

        // Get unread notifications count for sidebar badge
        $unreadCount = BoatOwnerNotification::where('user_id', Auth::id())
                                            ->where('is_read', false)
                                            ->count();

        return view('boat_owner.editboat', compact('boat', 'unreadCount'));
    }

    /**
     * Update the specified boat in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Boat $boat): RedirectResponse
    {
        if (Auth::id() !== $boat->user_id || Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'boat_name' => 'required|string|max:255',
            'boat_prices' => 'required|numeric|min:0',
            'boat_capacities' => 'required|integer|min:1',
            'boat_length' => 'nullable|string|max:50',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Captain fields are optional
            'captain_name' => 'nullable|string|max:255',
            'captain_contact' => 'nullable|string|regex:/^[0-9]{11}$/',
        ], [
            'captain_contact.regex' => 'The number is not enough. Please enter exactly 11 digits.',
        ]);

        // Only update basic boat fields here. Status is handled by updateStatus().
        $updateData = $request->only([
            'boat_name', 'boat_prices', 'boat_capacities'
        ]);
        if (Schema::hasColumn('boats', 'boat_length')) {
            $updateData['boat_length'] = $request->input('boat_length');
        }

        // Handle image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($boat->image_path) {
                $oldImagePath = public_path($boat->image_path);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
            $file = $request->file('image_path');
            $filename = 'boat_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('image');
            if (!is_dir($destination)) {
                @mkdir($destination, 0775, true);
            }
            $file->move($destination, $filename);
            $updateData['image_path'] = 'image/' . $filename;
        }

        $boat->update($updateData);

        // Update captain fields if columns exist
        try {
            $dirty = false;
            if (Schema::hasColumn('boats', 'captain_name')) {
                $boat->captain_name = $request->input('captain_name', $boat->captain_name);
                $dirty = $dirty || $boat->isDirty('captain_name');
            }
            if (Schema::hasColumn('boats', 'captain_contact')) {
                $boat->captain_contact = $request->input('captain_contact', $boat->captain_contact);
                $dirty = $dirty || $boat->isDirty('captain_contact');
            }
            if ($dirty) {
                $boat->save();
            }
        } catch (\Throwable $e) {
            // Ignore if schema not ready
        }

        return redirect()->route('boat')->with('success', 'Boat updated successfully.');
    }

    /**
     * Remove the specified boat from storage.
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Boat $boat): RedirectResponse
    {
        if (Auth::id() !== $boat->user_id || Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }
        // Instead of hard delete, archive the boat
        try {
            $boat->archive();
            return redirect()->route('boat')->with('success', 'Boat "' . $boat->boat_name . '" archived successfully.');
        } catch (\Throwable $e) {
            Log::error('Boat archive failed: ' . $e->getMessage(), ['boat_id' => $boat->id, 'user_id' => Auth::id()]);
            return redirect()->route('boat')->with('error', 'Failed to archive boat: ' . $e->getMessage());
        }
    }

    /**
     * Show archived boats for the current boat owner.
     */
    public function archiveIndex(): View
    {
        $user = Auth::user();
        if ($user->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }
        $boats = $user->boats()->archived()->orderByDesc('archived_at')->paginate(10);
        return view('boat_owner.archive', compact('boats'));
    }

    /** Restore archived boat */
    public function restore(Boat $boat): RedirectResponse
    {
        if (Auth::id() !== $boat->user_id || Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }
        try {
            $boat->unarchive();
            return redirect()->route('boat.owner.archive')->with('success', 'Boat restored successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to restore boat: ' . $e->getMessage());
        }
    }

    /** Permanently delete archived boat */
    public function forceDelete(Boat $boat): RedirectResponse
    {
        if (Auth::id() !== $boat->user_id || Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }
        try {
            if ($boat->image_path) {
                Storage::disk('public')->delete($boat->image_path);
            }
            $boat->delete();
            return redirect()->route('boat.owner.archive')->with('success', 'Boat permanently deleted.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to delete boat: ' . $e->getMessage());
        }
    }

    /**
     * Update the status of the specified boat (e.g., 'open', 'rehab', 'closed') by the boat owner.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Boat $boat): RedirectResponse
    {
        if (Auth::id() !== $boat->user_id || Auth::user()?->role !== 'boat_owner') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:' . Boat::STATUS_OPEN . ',' . Boat::STATUS_REHAB . ',' . Boat::STATUS_CLOSED,
            'rehab_reason' => 'nullable|string|max:500', // Only required if status is rehab
        ]);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === Boat::STATUS_REHAB) {
            $request->validate([
                'rehab_reason' => 'required|string|max:500',
            ], [
                'rehab_reason.required' => 'The reason for maintenance is required.',
            ]);
            $updateData['rejection_reason'] = $validated['rehab_reason']; // Use rejection_reason for maintenance reason
        } else {
            $updateData['rejection_reason'] = null; // Clear maintenance reason if not in maintenance status
        }

        // Prevent owners from changing status if it's currently pending, rejected by admin, approved, or assigned
        if (in_array($boat->status, [Boat::STATUS_PENDING, Boat::STATUS_REJECTED, Boat::STATUS_APPROVED, Boat::STATUS_ASSIGNED])) {
            if ($boat->status === Boat::STATUS_ASSIGNED) {
                return redirect()->back()->with('error', 'Cannot change status while boat is assigned to a booking. The status will automatically change to "Open" when the booking period ends.');
            }
            return redirect()->back()->with('error', 'Cannot change status while boat is ' . ucfirst($boat->status) . '. Please wait for admin approval/review or ensure it\'s not already approved.');
        }

        $boat->update($updateData);

        return redirect()->back()->with('success', 'Boat status updated to ' . ucfirst($validated['status']) . '.');
    }

    /**
     * Display notifications for the boat owner.
     * NEW METHOD: Fetches dynamic notifications.
     *
     * @return \Illuminate\View\View
     */
    public function showNotifications(): View
    {
        if (!Auth::check() || Auth::user()->role !== 'boat_owner') {
            Log::warning('Unauthorized access attempt to boat owner notifications.', ['user_id' => Auth::id(), 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action. Only boat owners can view notifications.');
        }

        $boatOwnerId = Auth::id();

        // Fetch notifications relevant to this boat owner, eager load booking and its room
        $boatOwnerNotifications = BoatOwnerNotification::where('user_id', $boatOwnerId)
                                                           ->with('booking', 'booking.room', 'booking.user') // Added booking.user to eager load tourist info
                                                           ->orderBy('created_at', 'desc')
                                                           ->paginate(10);

        return view('boat_owner.notification', compact('boatOwnerNotifications'));
    }

    /**
     * Mark a boat owner notification as read.
     * NEW METHOD: Marks a specific notification as read.
     *
     * @param  \App\Models\BoatOwnerNotification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(BoatOwnerNotification $notification)
    {
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $notification->update(['is_read' => true]);

        // Return JSON response if request expects JSON, otherwise redirect back
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        }

        return back()->with('success', 'Notification marked as read.');
    }
}
