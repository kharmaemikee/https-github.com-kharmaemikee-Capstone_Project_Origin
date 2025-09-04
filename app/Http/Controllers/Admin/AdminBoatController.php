<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log; // Corrected import
use Illuminate\Support\Facades\Storage;

class AdminBoatController extends Controller
{
    /**
     * Display a listing of all boats for the admin.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Ensure only admins can access this page
        if (Auth::user()?->role !== 'admin') { // Corrected Auth::user()
            abort(403, 'Unauthorized action.');
        }

        // Fetch all boats, eagerly load the 'user' relationship to display owner name
        $boats = Boat::with('user')->orderBy('status')->orderBy('created_at', 'desc')->get();

        return view('admin.boat_info', compact('boats'));
    }

    /**
     * Display the specified boat's details for the admin.
     * (This method is currently a placeholder for potential future detail view)
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\View\View
     */
    public function show(Boat $boat): View
    {
        // Ensure only admins can access this page
        if (Auth::user()?->role !== 'admin') { // Corrected Auth::user()
            abort(403, 'Unauthorized action.');
        }

        // Eager load the user relationship if not already loaded
        $boat->load('user');

        return view('admin.boat_details', compact('boat'));
        // Note: You would need to create 'admin.boat_details.blade.php' if you intend to use this.
    }

    /**
     * Approve a boat.
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Boat $boat): RedirectResponse
    {
        // Ensure only admins can approve
        if (!Auth::check() || Auth::user()->role !== 'admin') { // Corrected Auth::user()
            Log::warning('Unauthorized boat approval attempt.', ['user_id' => Auth::id(), 'boat_id' => $boat->id]); // Corrected Log::warning()
            abort(403, 'Unauthorized action.');
        }

        // Only approve if not already approved, but allow from pending or rejected or rehab.
        if ($boat->status === Boat::STATUS_PENDING || $boat->status === Boat::STATUS_REJECTED || $boat->status === Boat::STATUS_REHAB || $boat->status === Boat::STATUS_CLOSED) {
            $boat->update([
                'status' => Boat::STATUS_OPEN, // Changed from Boat::STATUS_APPROVED to Boat::STATUS_OPEN
                'rejection_reason' => null, // Clear any previous rejection or rehab reason
            ]);
            return redirect()->route('admin.boat')->with('success', 'Boat "' . $boat->boat_name . '" has been approved and is now OPEN for bookings.');
        }

        return redirect()->route('admin.boat')->with('error', 'Boat "' . $boat->boat_name . '" is not in a state to be approved (Current status: ' . ucfirst($boat->status) . ').');
    }

    /**
     * Reject a boat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, Boat $boat): RedirectResponse
    {
        // Ensure only admins can reject
        if (Auth::user()?->role !== 'admin') { // Corrected Auth::user()
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // It should be possible to reject from any non-rejected state.
        if ($boat->status !== Boat::STATUS_REJECTED) {
            $boat->update([
                'status' => Boat::STATUS_REJECTED,
                'rejection_reason' => $request->rejection_reason,
            ]);
            return redirect()->back()->with('success', 'Boat "' . $boat->boat_name . '" has been rejected.');
        }

        return redirect()->back()->with('error', 'Boat "' . $boat->boat_name . '" is already rejected.');
    }

    /**
     * Remove the specified boat from storage.
     * (Admin can also delete boats if needed, similar to boat owner's destroy but without owner check)
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Boat $boat): RedirectResponse
    {
        // Ensure only admins can delete
        if (Auth::user()?->role !== 'admin') { // Corrected Auth::user()
            abort(403, 'Unauthorized action.');
        }

        try {
            if ($boat->image_path) {
                Storage::disk('public')->delete($boat->image_path);
                Log::info('Admin deleted boat image during destruction: ' . $boat->image_path);
            }

            $boat_name = $boat->boat_name; // Store name before deletion
            $boat->delete();

            return redirect()->route('admin.boat')->with('success', 'Boat "' . $boat_name . '" deleted successfully by admin.');
        } catch (\Exception $e) {
            Log::error('Admin boat deletion failed: ' . $e->getMessage(), ['boat_id' => $boat->id, 'admin_id' => Auth::id()]);
            return redirect()->route('admin.boat')->with('error', 'Failed to delete boat: ' . $e->getMessage());
        }
    }

    /**
     * Update the status of the specified boat (e.g., 'open', 'rehab', 'closed') by admin.
     * This method also handles setting/clearing the rehab reason.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Boat $boat): RedirectResponse
    {
        if (Auth::user()?->role !== 'admin') { // Corrected Auth::user()
            abort(403, 'Unauthorized action.');
        }

        // Define all possible statuses
        $allStatuses = [
            Boat::STATUS_OPEN,
            Boat::STATUS_REHAB,
            Boat::STATUS_CLOSED,
            Boat::STATUS_APPROVED,
            Boat::STATUS_PENDING,
            Boat::STATUS_REJECTED,
        ];

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', $allStatuses),
            'rehab_reason' => 'nullable|string|max:500',
        ]);

        $updateData = ['status' => $validated['status']];

        // Handle rehab_reason for 'rehab' status
        if ($validated['status'] === Boat::STATUS_REHAB) {
            $request->validate([
                'rehab_reason' => 'required|string|max:500',
            ], [
                'rehab_reason.required' => 'The reason for rehab is required.',
            ]);
            $updateData['rejection_reason'] = $validated['rehab_reason']; // Use rejection_reason for rehab reason
        } else {
            // Clear rehab reason if status is not rehab
            $updateData['rejection_reason'] = null;
        }

        // If the admin is setting to Approved or Open, ensure rehab_reason is cleared
        if ($validated['status'] === Boat::STATUS_APPROVED || $validated['status'] === Boat::STATUS_OPEN) {
            $updateData['rejection_reason'] = null;
        }

        $boat->update($updateData);

        return redirect()->back()->with('success', 'Boat status updated to ' . ucfirst($validated['status']) . '.');
    }
}
