<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Models\TouristNotification;
use App\Models\BoatOwnerNotification;

class NotificationController extends Controller
{
    /**
     * Display the tourist's notifications.
     * This will be used for the /tourist/visit route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showTouristNotifications(Request $request)
    {
        // Ensure only tourists can access this
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized access.');
        }

        // Get notifications for the authenticated tourist, ordered by creation date (newest first)
        $touristNotifications = TouristNotification::where('user_id', Auth::id())
                                                    ->orderBy('created_at', 'desc')
                                                    ->paginate(10); // Or adjust pagination as needed

        return view('tourist.visit', compact('touristNotifications'));
    }

    /**
     * Mark a specific tourist notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TouristNotification  $notification
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function markTouristNotificationAsRead(Request $request, TouristNotification $notification)
    {
        // Authorize: Ensure the notification belongs to the authenticated tourist
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->is_read = true;
        $notification->save();

        // Return JSON response for AJAX requests
        return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
    }

    /**
     * Delete a specific tourist notification.
     *
     * @param  \App\Models\TouristNotification  $notification
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroyTouristNotification(TouristNotification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $notification->delete();
            
            // Return JSON response for AJAX requests
            return response()->json(['success' => true, 'message' => 'Notification deleted successfully.']);
        } catch (\Exception $e) {
            Log::error("Failed to delete tourist notification: " . $e->getMessage());
            
            // Return JSON response for AJAX requests
            return response()->json(['error' => 'Failed to delete notification. Please try again.'], 500);
        }
    }

    /**
     * Get tourist notifications via AJAX for the notification dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTouristNotificationsAjax(Request $request)
    {
        // Ensure only tourists can access this
        if (Auth::user()->role !== 'tourist') {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        try {
            // Get notifications for the authenticated tourist, ordered by creation date (newest first)
            $notifications = TouristNotification::where('user_id', Auth::id())
                ->with('booking.room') // Eager load booking and room relationships
                ->orderBy('created_at', 'desc')
                ->limit(10) // Limit to 10 most recent notifications
                ->get();

            // Log for debugging
            Log::info('Tourist notifications count: ' . $notifications->count());

            // Transform the data for JSON response
            $notificationsData = $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at,
                    'booking' => $notification->booking ? [
                        'room_name' => $notification->booking->room->room_name ?? 'N/A Room',
                        'name_of_resort' => $notification->booking->name_of_resort,
                        'status' => $notification->booking->status,
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'notifications' => $notificationsData,
                'count' => $notificationsData->count(),
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to fetch tourist notifications: " . $e->getMessage());
            return response()->json(['error' => 'Failed to load notifications.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the boat owner's notifications.
     * This will be used for the boat_owner/notification route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showBoatOwnerNotifications(Request $request)
    {
        // Ensure only boat owners can access this
        if (Auth::user()->role !== 'boat_owner') {
            abort(403, 'Unauthorized access.');
        }

        // Get notifications for the authenticated boat owner, ordered by creation date (newest first)
        $boatOwnerNotifications = BoatOwnerNotification::where('user_id', Auth::id())
                                                        ->with('booking.user', 'booking.room') // Eager load relationships for display
                                                        ->orderBy('created_at', 'desc')
                                                        ->paginate(10);

        $unreadCount = BoatOwnerNotification::where('user_id', Auth::id())
                                            ->where('is_read', false)
                                            ->count();

        return view('boat_owner.notification', compact('boatOwnerNotifications', 'unreadCount'));
    }

    /**
     * Mark a specific boat owner notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BoatOwnerNotification  $notification
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function markBoatOwnerNotificationAsRead(Request $request, BoatOwnerNotification $notification)
    {
        // Authorize: Ensure the notification belongs to the authenticated boat owner
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->is_read = true;
        $notification->save();

        // Return JSON response for AJAX requests
        return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
    }

    /**
     * Delete a specific boat owner notification.
     *
     * @param  \App\Models\BoatOwnerNotification  $notification
     * @return \Illuminate\Http\JsonResponse // Changed to JsonResponse
     */
    public function destroyBoatOwnerNotification(BoatOwnerNotification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $notification->delete();
            // Nagbalik na ito ng JSON response na may 'success' message
            return response()->json(['success' => 'Notification deleted successfully.']);
        } catch (\Exception $e) {
            Log::error("Failed to delete boat owner notification: " . $e->getMessage());
            // Nagbalik na rin ito ng JSON response na may 'error' message
            return response()->json(['error' => 'Failed to delete notification. Please try again.'], 500);
        }
    }

    /**
     * Mark all tourist notifications as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllTouristNotificationsAsRead(Request $request)
    {
        // Ensure only tourists can access this
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized access.');
        }

        try {
            TouristNotification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
        } catch (\Exception $e) {
            Log::error("Failed to mark all tourist notifications as read: " . $e->getMessage());
            return response()->json(['error' => 'Failed to mark all notifications as read. Please try again.'], 500);
        }
    }

    /**
     * Mark all boat owner notifications as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllBoatOwnerNotificationsAsRead(Request $request)
    {
        // Ensure only boat owners can access this
        if (Auth::user()->role !== 'boat_owner') {
            abort(403, 'Unauthorized access.');
        }

        try {
            BoatOwnerNotification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
        } catch (\Exception $e) {
            Log::error("Failed to mark all boat owner notifications as read: " . $e->getMessage());
            return response()->json(['error' => 'Failed to mark all notifications as read. Please try again.'], 500);
        }
    }
}