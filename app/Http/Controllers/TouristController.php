<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\TouristNotification;
use App\Models\Resort; // <--- ADDED: Import the Resort model
use App\Models\Room; // Still needed if you decide to uncomment showFillup()

class TouristController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }

        // Fetch notifications for the current authenticated tourist
        $touristNotifications = TouristNotification::where('user_id', Auth::id())
                                                    ->latest()
                                                    ->get();

        // --- ADDED LOGIC FOR MOST VISITED RESORTS ---
        // Fetch the most visited resorts, ordered by visit_count in descending order
        $mostVisitedResorts = Resort::withAvg('ratings as ratings_avg', 'stars')
                                    ->orderByDesc('visit_count')
                                    ->where('admin_status', 'approved') // Only show approved resorts
                                    ->whereIn('status', ['open', 'closed', 'maintenance']) // Show all relevant statuses for display
                                    ->take(8) // Limit to top 8, adjust as needed
                                    ->get();
        // --- END ADDED LOGIC ---

        // Pass both to the view
        return view('tourist.tourist', compact('touristNotifications', 'mostVisitedResorts'));
    }

    /*
    // This 'visit' method in TouristController is NOT being used by your current web.php routes.
    // Your web.php routes 'tourist/visit' to BookingController@myBookings.
    // Keep this commented or delete it if you confirm BookingController handles this.
    public function visit()
    {
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }

        $touristNotifications = TouristNotification::where('user_id', Auth::id())
                                                    ->where('is_read', false)
                                                    ->with('booking.room')
                                                    ->latest()
                                                    ->paginate(5);

        $bookings = Booking::where('user_id', Auth::id())
                            ->with('room')
                            ->latest()
                            ->paginate(5);

        return view('tourist.visit', compact('touristNotifications', 'bookings'));
    }
    */

    public function markNotificationAsRead(TouristNotification $notification)
    {
        if (Auth::user()->id !== $notification->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to mark this notification as read.');
        }

        $notification->is_read = true;
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function destroyNotification(TouristNotification $notification)
    {
        if (Auth::user()->id !== $notification->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this notification.');
        }

        try {
            $notification->delete();
            return redirect()->back()->with('success', 'Notification deleted successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging: \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete notification. Please try again.');
        }
    }

    public function showReminders()
    {
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }
        return view('tourist.reminders');
    }

    /*
    // This 'showFillup' method in TouristController is NOT being used by your current web.php routes.
    // Your web.php routes 'tourist/fillup/{room}' to BookingController@showFillupForm.
    // Keep this commented or delete it if you confirm BookingController handles this.
    public function showFillup($roomId)
    {
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }
        $room = Room::notArchived()->findOrFail($roomId);
        return view('tourist.fillup', compact('room', 'roomId'));
    }
    */

    /*
    // This 'showFillup2' method in TouristController is NOT being used by your current web.php routes.
    // Your web.php routes 'tourist/fillup2' to BookingController@showFillupForm2.
    // Keep this commented or delete it if you confirm BookingController handles this.
    public function showFillup2()
    {
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }
        return view('tourist.fillup2');
    }
    */
}