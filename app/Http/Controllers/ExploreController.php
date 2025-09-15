<?php

namespace App\Http\Controllers;

use App\Models\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Added for logging, remove if not needed

class ExploreController extends Controller
{
    /**
     * Display a listing of publicly viewable resorts.
     * Resorts must be admin_approved and owner_status 'open', 'closed', or 'maintenance'.
     */
    public function index(Request $request)
    {
        $resorts = Resort::where('admin_status', 'approved')
                             ->whereIn('status', ['open', 'closed', 'maintenance'])
                             ->with(['rooms' => function ($query) {
                                 // Load rooms that are not archived; admin approval no longer required
                                 $query->where('archived', false);
                             }])
                             ->orderBy('resort_name')
                             ->get();

        // Check if the current route is 'tourist.list' and user is authenticated
        if ($request->routeIs('tourist.list') && Auth::check()) {
            return view('tourist.list', compact('resorts'));
        }

        // Otherwise, use the explore.exploring view (for public explore page)
        return view('explore.exploring', compact('resorts'));
    }

    /**
     * Display the specified resort and its publicly viewable rooms.
     * This is for the "View Rooms" link on the explore page.
     */
    public function show(Resort $resort)
    {
        // Removed: $resort->increment('visit_count');
        // Ang visit count ay i-increment na sa booking process sa BookingController.

        // We still check for admin_status, but allow 'closed' and 'maintenance' for the resort itself to be viewed,
        // so we can display the status message on the detail page.
        if ($resort->admin_status !== 'approved') {
            abort(404, 'Resort not found or not approved for public viewing.');
        }

        // Eager load ALL rooms for the specific resort, so their individual statuses can be shown.
        // We still filter by admin_status to ensure only admin-approved rooms are considered.
        $resort->load(['rooms' => function ($query) {
            // Show all non-archived rooms; admin approval not required anymore
            $query->where('archived', false);
        }]);

        // If the user is authenticated and is a 'tourist', render the tourist-specific view.
        if (Auth::check() && Auth::user()->role === 'tourist') {
            return view('tourist.showtour', compact('resort'));
        }

        // Otherwise (not authenticated, or not a tourist), use the public explore view.
        return view('explore.showex', compact('resort'));
    }
}