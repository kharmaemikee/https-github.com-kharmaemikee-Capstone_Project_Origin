<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Rating;
use App\Models\ResortOwnerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        if (!Auth::check() || Auth::user()->role !== 'tourist' || $booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only rate completed bookings.');
        }

        $data = $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Rating::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'booking_id' => $booking->id,
                'resort_id' => optional(optional($booking->room)->resort)->id ?? $booking->room->resort_id ?? null,
                'user_id' => Auth::id(),
                'stars' => $data['stars'],
                'comment' => $data['comment'] ?? null,
            ]
        );

        // Notify the resort owner that a rating was submitted
        try {
            $resortOwnerId = $booking->resort_owner_id ?? optional(optional($booking->room)->resort)->user_id ?? null;
            if ($resortOwnerId) {
                ResortOwnerNotification::create([
                    'user_id' => $resortOwnerId,
                    'booking_id' => $booking->id,
                    'message' => 'A tourist submitted a rating of ' . $data['stars'] . ' star' . ($data['stars'] > 1 ? 's' : '') . ' for booking #' . $booking->id . '.',
                    'type' => 'rating_submitted',
                    'is_read' => false,
                ]);
            }
        } catch (\Throwable $e) {
            // swallow notification errors to not block rating submission
        }

        return back()->with('success', 'Thank you for rating your stay!');
    }
}


