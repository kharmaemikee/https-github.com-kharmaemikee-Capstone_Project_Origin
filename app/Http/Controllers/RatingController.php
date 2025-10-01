<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Booking;
use App\Models\TouristNotification;
use App\Models\ResortOwnerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    /**
     * Store a new rating for a completed booking.
     */
    public function store(Request $request)
    {
        // Log the request for debugging
        Log::info('Rating submission request', [
            'is_ajax' => $request->ajax(),
            'headers' => $request->headers->all(),
            'data' => $request->all()
        ]);

        try {
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $booking = Booking::findOrFail($request->booking_id);

        // Check if user owns this booking
        if ($booking->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only rate your own bookings.'
                ], 403);
            }
            return back()->with('error', 'You can only rate your own bookings.');
        }

        // Check if booking is completed
        if ($booking->status !== 'completed') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only rate completed bookings.'
                ], 400);
            }
            return back()->with('error', 'You can only rate completed bookings.');
        }

        // Check if user has already rated this booking
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('booking_id', $request->booking_id)
            ->first();

        if ($existingRating) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already rated this booking.'
                ], 400);
            }
            return back()->with('error', 'You have already rated this booking.');
        }

        DB::beginTransaction();
        try {
            // Create the rating
            $rating = Rating::create([
                'user_id' => Auth::id(),
                'booking_id' => $request->booking_id,
                'resort_id' => $booking->room->resort_id,
                'room_id' => $booking->room_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // Mark the rating notification as read
            TouristNotification::where('user_id', Auth::id())
                ->where('booking_id', $request->booking_id)
                ->where('type', 'booking_completed_rating_request')
                ->update(['is_read' => true]);

            // Notify the resort owner that their room has been rated
            ResortOwnerNotification::create([
                'user_id' => $booking->resort_owner_id,
                'booking_id' => $booking->id,
                'message' => 'Your room "' . $booking->room->room_name . '" at ' . $booking->name_of_resort . ' has been rated ' . $request->rating . ' stars by ' . Auth::user()->name . '.',
                'type' => 'room_rated',
                'is_read' => false,
            ]);

            DB::commit();

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your rating! Your feedback helps other travelers.'
                ]);
            }

            return back()->with('success', 'Thank you for your rating! Your feedback helps other travelers.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create rating: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'booking_id' => $request->booking_id,
                'exception' => $e
            ]);
            
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit rating. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to submit rating. Please try again.');
        }
    }

    /**
     * Show the rating form for a specific booking.
     */
    public function show(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'You can only rate your own bookings.');
        }

        // Check if booking is completed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only rate completed bookings.');
        }

        // Check if user has already rated this booking
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('booking_id', $booking->id)
            ->first();

        if ($existingRating) {
            return back()->with('info', 'You have already rated this booking.');
        }

        return view('tourist.rate-booking', compact('booking'));
    }
}