<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resort;
use App\Models\Room;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    /**
     * Show feedback for a specific room.
     */
    public function showRoomFeedback(Room $room, Request $request)
    {
        // Get all ratings for this room with user and booking information
        $ratings = Rating::where('room_id', $room->id)
            ->with(['user', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate rating statistics
        $ratingStats = [
            'total_ratings' => $ratings->total(),
            'average_rating' => $ratings->avg('rating') ?? 0,
            'rating_breakdown' => [
                5 => $ratings->where('rating', 5)->count(),
                4 => $ratings->where('rating', 4)->count(),
                3 => $ratings->where('rating', 3)->count(),
                2 => $ratings->where('rating', 2)->count(),
                1 => $ratings->where('rating', 1)->count(),
            ]
        ];

        // Check if request is coming from explore section
        $fromExplore = $request->has('from') && $request->get('from') === 'explore';

        // Return appropriate view based on source
        if ($fromExplore) {
            return view('feedback.room-explore', compact('room', 'ratings', 'ratingStats'));
        } else {
            return view('feedback.room-tourist', compact('room', 'ratings', 'ratingStats'));
        }
    }
}
