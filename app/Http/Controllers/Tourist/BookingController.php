<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room; // Make sure this is imported
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the booking fill-up form for a specific room.
     * This is intended for logged-in tourists.
     *
     * @param  \App\Models\Room  $room  <-- This parameter is crucial
     * @return \Illuminate\View\View
     */
    public function showFillupForm(Room $room)
    {
        // Check if the authenticated user is a 'tourist'.
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }

        // Check if the room is archived
        if ($room->archived) {
            abort(404, 'This room is no longer available.');
        }

        // The 'room' object is automatically resolved by Laravel's route model binding.
        // We now pass both 'room' and 'roomId' to the view for compatibility.
        // 'roomId' is redundant if 'room' object is used directly, but kept for your view.
        return view('tourist.fillup', ['room' => $room, 'roomId' => $room->id]);
    }

    /**
     * Handle the redirection after a guest logs in and wants to book.
     * This method retrieves the room_id from the session (set during login redirection)
     * and then redirects to the 'tourist.fillup' route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handlePostLoginBooking(Request $request)
    {
        // Check if the authenticated user is a 'tourist'.
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }

        // Retrieve the room_id from the session, which was stored before login redirection.
        // Use Session::pull() to get the item and remove it from the session immediately.
        $roomId = Session::pull('intended_room_id');

        if ($roomId) {
            $room = Room::find($roomId);
            if ($room) {
                // Check if the room is archived
                if ($room->archived) {
                    return redirect()->route('explore.exploring')->with('error', 'This room is no longer available for booking.');
                }
                
                // If room is found, redirect to the 'tourist.fillup' route with the room ID.
                // This ensures the same route handles both direct and post-login access.
                return redirect()->route('tourist.fillup', ['room' => $room->id]);
            }
        }

        // If no room_id is found in the session, or room not found,
        // redirect to a default page (e.g., explore page) with an error.
        return redirect()->route('explore.exploring')->with('error', 'Could not retrieve room details for booking. Please try again.');
    }
}