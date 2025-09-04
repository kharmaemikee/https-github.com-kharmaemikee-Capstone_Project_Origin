<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\Room; // Make sure to import the Room model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminResortController extends Controller
{
    /**
     * Display a listing of all resorts for the admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ensure only admins can access this page
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Fetch all resorts, ordered by admin_status (pending first, then rejected, then approved)
        // This ensures pending items are at the top for easy review.
        $resorts = Resort::orderByRaw("FIELD(admin_status, 'pending', 'rejected', 'approved')")
                         ->orderBy('resort_name')
                         ->get();

        return view('admin.resort_info', compact('resorts'));
    }

    /**
     * Display the specified resort's details for the admin, including its rooms.
     *
     * @param  \App\Models\Resort  $resort
     * @return \Illuminate\View\View
     */
    public function show(Resort $resort)
    {
        // Ensure only admins can access this page
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Load rooms associated with the resort, ordered by admin_status
        $resort->load(['rooms' => function($query) {
            $query->orderByRaw("FIELD(admin_status, 'pending', 'rejected', 'approved')");
        }]);

        return view('admin.resort-details-for-admin', compact('resort'));
    }

    /**
     * Approve a resort.
     *
     * @param  \App\Models\Resort  $resort
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveResort(Resort $resort)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Only approve if the current status is 'pending'
        if ($resort->admin_status === 'pending') {
            $resort->admin_status = 'approved';
            $resort->rejection_reason = null; // Clear rejection reason on approval
            $resort->save();
            return redirect()->back()->with('success', 'Resort "' . $resort->resort_name . '" has been approved.');
        }

        return redirect()->back()->with('error', 'Resort "' . $resort->resort_name . '" is not pending approval.');
    }

    /**
     * Reject a resort.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resort  $resort
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectResort(Request $request, Resort $resort)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500', // Admin must provide a reason
        ]);

        // Only reject if the current status is 'pending'
        if ($resort->admin_status === 'pending') {
            $resort->admin_status = 'rejected';
            $resort->rejection_reason = $request->input('rejection_reason'); // Store rejection reason
            $resort->save();
            return redirect()->back()->with('success', 'Resort "' . $resort->resort_name . '" has been rejected.');
        }

        return redirect()->back()->with('error', 'Resort "' . $resort->resort_name . '" is not pending approval.');
    }

    /**
     * Approve a specific room.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveRoom(Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if ($room->admin_status === 'pending') {
            $room->admin_status = 'approved';
            $room->rejection_reason = null; // Clear rejection reason on approval
            $room->save();
            return redirect()->back()->with('success', 'Room "' . $room->room_name . '" has been approved.');
        }
        return redirect()->back()->with('error', 'Room "' . $room->room_name . '" is not pending approval.');
    }

    /**
     * Reject a specific room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectRoom(Request $request, Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500', // Admin must provide a reason
        ]);

        if ($room->admin_status === 'pending') {
            $room->admin_status = 'rejected';
            $room->rejection_reason = $request->input('rejection_reason'); // Store rejection reason
            $room->save();
            return redirect()->back()->with('success', 'Room "' . $room->room_name . '" has been rejected.');
        }
        return redirect()->back()->with('error', 'Room "' . $room->room_name . '" is not pending approval.');
    }
}
