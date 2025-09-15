<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Boat;
use App\Models\ResortOwnerNotification;
use App\Models\TouristNotification;
use App\Models\BoatOwnerNotification;
use App\Models\Setting;
use App\Models\Resort; // <--- ADDED: Import the Resort model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show the first fill-up form with room details.
     * Accessible by GET /tourist/fillup/{room}
     */
    public function showFillupForm(Room $room)
    {
        // Role check is handled by middleware or route definition in web.php
        return view('tourist.fillup', ['room' => $room, 'roomId' => $room->id]);
    }

    /**
     * Show the second fill-up form.
     * Data from fillup.blade.php is passed as query parameters.
     * Accessible by GET /tourist/fillup2
     */
    public function showFillupForm2(Request $request)
    {
        // Clear any stale booking session data to prevent issues with different accounts
        if (Auth::check()) {
            $currentUserId = Auth::id();
            $sessionUserId = session('current_user_id');
            
            // If this is a different user, clear all booking-related session data
            if ($sessionUserId && $sessionUserId !== $currentUserId) {
                session()->forget(['intended_room_id', 'current_user_id']);
            }
            
            // Store current user ID in session
            session(['current_user_id' => $currentUserId]);
        }
        
        // Get the room and check availability
        $roomId = $request->get('room_id');
        $checkInDate = $request->get('reservation_date');
        
        // If essential data is missing, redirect to explore page
        if (!$roomId || !$checkInDate) {
            return redirect()->route('explore.exploring')
                ->with('error', 'Please select a room and date from the explore page to continue with booking.');
        }
        
        $room = Room::notArchived()->find($roomId);
        if (!$room) {
            return redirect()->route('explore.exploring')
                ->with('error', 'The selected room was not found. Please try again.');
        }
        
        // Check if room is archived or not available
        if ($room->archived || $room->status !== 'open' || (isset($room->admin_status) && $room->admin_status !== 'approved')) {
            return redirect()->route('explore.exploring')
                ->with('error', 'This room is not currently available for booking.');
        }
        
        // Check availability for the specific date
        $isAvailable = $room->isAvailableForDate($checkInDate);
        $conflictingBooking = null;
        
        if (!$isAvailable) {
            $conflictingBooking = $room->getConflictingBooking($checkInDate);
        }
        
        return view('tourist.fillup2', [
            'requestData' => $request->all(),
            'room' => $room,
            'isAvailable' => $isAvailable,
            'conflictingBooking' => $conflictingBooking,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }

    /**
     * Handle the redirection after a guest logs in and wants to book.
     * This method retrieves the room_id from the session (set during login redirection)
     * and then redirects to the 'tourist.fillup' route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handlePostLoginBooking(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Check if the authenticated user is a 'tourist'.
        if (Auth::user()->role !== 'tourist') {
            abort(403, 'Unauthorized');
        }

        // Retrieve the room_id from the session, which was stored before login redirection.
        // Use Session::pull() to get the item and remove it from the session immediately.
        $roomId = Session::pull('intended_room_id');

        if ($roomId) {
            $room = Room::notArchived()->find($roomId);
            if ($room) {
                // If room is found, redirect to the 'tourist.fillup' route with the room ID.
                // This ensures the same route handles both direct and post-login access.
                return redirect()->route('tourist.fillup', ['room' => $room->id]);
            }
        }

        // If no room_id is found in the session, or room not found,
        // redirect to a default page (e.g., explore page) with an error.
        return redirect()->route('explore.exploring')->with('error', 'Could not retrieve room details for booking. Please try again.');
    }

    /**
     * Check room availability for specific dates.
     * This method can be called via AJAX to check availability before submitting the booking form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'tour_type' => ['required', Rule::in(['day_tour', 'overnight'])],
            'num_nights' => 'nullable|integer|min:0|required_if:tour_type,overnight',
        ]);

        $room = Room::notArchived()->findOrFail($request->room_id);
        
        // Check if room is archived or not available
        if ($room->archived || $room->status !== 'open' || (isset($room->admin_status) && $room->admin_status !== 'approved')) {
            return response()->json([
                'available' => false,
                'message' => 'This room is not currently available for booking.',
                'reason' => 'room_unavailable'
            ]);
        }

        $checkInDate = Carbon::parse($request->check_in_date);
        $checkOutDate = null;

        if ($request->tour_type === 'overnight') {
            $checkOutDate = $checkInDate->copy()->addDays($request->num_nights);
        } else {
            $checkOutDate = null;
        }

        $isAvailable = $room->isAvailableForDates($checkInDate, $checkOutDate);

        if (!$isAvailable) {
            $conflictingBookings = $room->getConflictingBookings($checkInDate, $checkOutDate);
            $conflictDetails = $conflictingBookings->map(function ($booking) {
                $dates = $booking->check_out_date 
                    ? $booking->check_in_date->format('M d, Y') . ' - ' . $booking->check_out_date->format('M d, Y')
                    : $booking->check_in_date->format('M d, Y');
                return "Guest: {$booking->guest_name}, Dates: {$dates}";
            })->join('; ');

            return response()->json([
                'available' => false,
                'message' => "This room is not available for the selected dates. Conflicting bookings: {$conflictDetails}",
                'reason' => 'date_conflict',
                'conflicts' => $conflictingBookings->map(function ($booking) {
                    return [
                        'guest_name' => $booking->guest_name,
                        'check_in' => $booking->check_in_date->format('Y-m-d'),
                        'check_out' => $booking->check_out_date ? $booking->check_out_date->format('Y-m-d') : null,
                        'tour_type' => $booking->tour_type,
                    ];
                })
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Room is available for the selected dates.',
            'check_in' => $checkInDate->format('Y-m-d'),
            'check_out' => $checkOutDate ? $checkOutDate->format('Y-m-d') : null,
        ]);
    }

    /**
     * Store a newly created booking in storage.
     * Accessible by POST /bookings
     */
    public function store(Request $request)
    {
        // Role check is handled by middleware 'auth' in web.php
        if (!Auth::check() || Auth::user()->role !== 'tourist') {
            Log::warning('Unauthorized booking attempt.', ['user_id' => Auth::id(), 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action. Only tourists can create bookings.');
        }

        // 1. **Validation (Comprehensive for all fields)**
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|regex:/^[0-9]{11}$/',
            'reservation_date' => 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'num_guests' => 'required|integer|min:1',
            'tour_type' => ['required', Rule::in(['day_tour', 'overnight'])],

            // Conditional validation for tour type specific fields
            'num_nights' => 'nullable|integer|min:0|required_if:tour_type,overnight',
            'day_tour_departure_time' => 'nullable|required_if:tour_type,day_tour|date_format:H:i',
            'day_tour_time_of_pickup' => 'nullable|required_if:tour_type,day_tour|date_format:H:i',
            'overnight_date_time_of_pickup' => 'nullable|required_if:tour_type,overnight|date_format:Y-m-d\TH:i',
            'num_senior_citizens' => 'nullable|integer|min:0',
            'num_pwds' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string|max:1000',
            'guest_names' => 'array',
            'guest_names.*' => 'string|max:255',
            'guest_ages' => 'array',
            'guest_ages.*' => 'integer|min:7',
        ], [
            'contact_number.regex' => 'The number is not enough. Please enter exactly 11 digits.',
        ]);

        // Load room with its associated resort to get resort_id and resort_name
        $room = Room::notArchived()->with('resort')->findOrFail($validatedData['room_id']);

        // Check if the room is available for booking (assuming room has status and admin_status)
        if ($room->status !== 'open' || (isset($room->admin_status) && $room->admin_status !== 'approved')) {
            return back()->withInput()->with('error', 'This room is not currently available for booking.');
        }

        // Check if the room is archived
        if ($room->archived) {
            return back()->withInput()->with('error', 'This room is no longer available for booking.');
        }

        // Check room availability for the requested dates
        $checkInDate = Carbon::parse($validatedData['reservation_date']);
        $checkOutDate = null;
        $numberOfNights = (int) ($validatedData['num_nights'] ?? 0);

        if ($validatedData['tour_type'] === 'overnight') {
            $checkOutDate = $checkInDate->copy()->addDays($numberOfNights);
        } else {
            $checkOutDate = null;
            $numberOfNights = 0;
        }

        // Check if the room is available for the requested dates
        if (!$room->isAvailableForDates($checkInDate, $checkOutDate)) {
            $conflictingBookings = $room->getConflictingBookings($checkInDate, $checkOutDate);
            $conflictDetails = $conflictingBookings->map(function ($booking) {
                $dates = $booking->check_out_date 
                    ? $booking->check_in_date->format('M d, Y') . ' - ' . $booking->check_out_date->format('M d, Y')
                    : $booking->check_in_date->format('M d, Y');
                return "Guest: {$booking->guest_name}, Dates: {$dates}";
            })->join('; ');
            
            return back()->withInput()->with('error', 
                "This room is not available for the selected dates. " .
                "Conflicting bookings: {$conflictDetails}"
            );
        }

        // Get the resort owner ID from the room's associated resort
        $resortOwnerId = $room->resort->user_id;
        $resort = $room->resort; // Get the Resort object for incrementing visit_count

        DB::beginTransaction();

        try {
            // Build combined guest_name string: primary guest + additional guests
            $allGuestNames = [];
            $primaryName = trim($validatedData['first_name'] . ' ' .
                                ($validatedData['middle_name'] ? $validatedData['middle_name'] . ' ' : '') .
                                $validatedData['last_name']);
            if ($primaryName !== '') {
                $allGuestNames[] = $primaryName;
            }
            $additionalGuests = $validatedData['guest_names'] ?? [];
            $additionalAges = $validatedData['guest_ages'] ?? [];
            foreach ($additionalGuests as $idx => $g) {
                $g = trim($g);
                if ($g !== '') {
                    $ageSuffix = '';
                    if (isset($additionalAges[$idx]) && (int)$additionalAges[$idx] > 0) {
                        $ageSuffix = ' (' . (int)$additionalAges[$idx] . ')';
                    }
                    $allGuestNames[] = $g . $ageSuffix;
                }
            }
            // Append age to primary guest in display
            if (!empty($allGuestNames)) {
                $allGuestNames[0] = $allGuestNames[0] . ' (' . (int)$validatedData['age'] . ')';
            }
            $guestNamesConcat = implode('; ', $allGuestNames);

            $booking = Booking::create([
                'user_id' => Auth::id(), // The tourist making the booking
                'resort_owner_id' => $resortOwnerId,
                'room_id' => $room->id,
                'guest_name' => $guestNamesConcat,
                'guest_age' => $validatedData['age'],
                'guest_gender' => $validatedData['gender'],
                'guest_address' => $validatedData['address'],
                'guest_nationality' => $validatedData['nationality'],
                'phone_number' => $validatedData['contact_number'],
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkOutDate,
                'number_of_nights' => $numberOfNights,
                'number_of_guests' => $validatedData['num_guests'],
                'special_requests' => $validatedData['special_requests'] ?? null,
                'status' => 'pending', // Initial status
                'tour_type' => $validatedData['tour_type'],
                'day_tour_departure_time' => $validatedData['day_tour_departure_time'] ?? null,
                'day_tour_time_of_pickup' => $validatedData['day_tour_time_of_pickup'] ?? null,
                'overnight_date_time_of_pickup' => $validatedData['overnight_date_time_of_pickup'] ?? null,
                'num_senior_citizens' => $validatedData['num_senior_citizens'] ?? 0,
                'num_pwds' => $validatedData['num_pwds'] ?? 0,
                'assigned_boat_id' => null, // Initially null, will be assigned upon approval
                'assigned_boat' => null, // Initially null
                'boat_captain_crew' => null, // Initially null
                'boat_contact_number' => null, // Initially null
                'name_of_resort' => $room->resort->resort_name,
            ]);

            // <--- ADDED: Increment visit_count for the resort after successful booking
            if ($resort) {
                $resort->increment('visit_count');
                Log::info('Resort visit count incremented due to successful room booking.', [
                    'resort_id' => $resort->id,
                    'current_visits' => $resort->visit_count,
                    'booking_id' => $booking->id,
                    'user_id' => Auth::id(),
                ]);
            }
            // END ADDED SECTION

            // Create Notification for Resort Owner
            ResortOwnerNotification::create([
                'user_id' => $resortOwnerId,
                'booking_id' => $booking->id,
                'message' => 'New booking request from ' . Auth::user()->name . ' for room: ' . $room->room_name . ' at ' . $room->resort->resort_name . '.',
                'type' => 'new_booking',
                'is_read' => false,
            ]);

            DB::commit();

            return redirect()->route('tourist.visit')
                ->with('success', 'Your booking request has been sent! Please wait for the resort owner\'s approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Booking failed: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'room_id' => $validatedData['room_id'] ?? 'N/A',
                'request_data' => $request->all(),
                'exception' => $e
            ]);
            return back()->withInput()->with('error', 'There was an issue processing your booking. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display all bookings and notifications for the authenticated Tourist.
     * Accessible by GET /tourist/visit
     */
    public function myBookings()
    {
        if (!Auth::check() || Auth::user()->role !== 'tourist') {
            Log::warning('Unauthorized access attempt to tourist visit page.', ['user_id' => Auth::id(), 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized access. Only tourists can view this page.');
        }

        $touristId = Auth::id();

        // Eager load necessary relationships for bookings: room, room.resort, and user (for guest_name)
        $bookings = Booking::where('user_id', $touristId)
                            ->with('room.resort', 'user', 'assignedBoat.user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        // Eager load necessary relationships for tourist notifications: booking, booking.room, and assignedBoat
        $touristNotifications = TouristNotification::where('user_id', $touristId)
                                                    ->with('booking', 'booking.room', 'booking.assignedBoat.user')
                                                    ->orderBy('created_at', 'desc')
                                                    ->paginate(10);

        return view('tourist.visit', compact('bookings', 'touristNotifications'));
    }

    /**
     * Mark a tourist notification as read.
     * Accessible by PUT /tourist/notifications/{notification}/mark-as-read
     */
    public function markTouristNotificationAsRead(TouristNotification $notification)
    {
        // Assuming this route is only accessible by tourists via middleware in web.php
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Delete a tourist notification.
     * Accessible by DELETE /tourist/notifications/{notification}/destroy
     */
    public function destroyTouristNotification(TouristNotification $notification)
    {
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $notification->delete();
            return back()->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete tourist notification: " . $e->getMessage(), ['notification_id' => $notification->id]);
            return back()->with('error', 'Failed to delete notification. Please try again.');
        }
    }

    /**
     * Display booking notifications for the authenticated Resort Owner.
     * Accessible by GET /resort_owner/notification
     */
    public function showNotifications()
    {
        // Role check is handled by middleware 'auth' in web.php, but this is a specific RO route
        if (!Auth::check() || Auth::user()->role !== 'resort_owner') {
            Log::warning('Unauthorized access attempt to resort owner notifications.', ['user_id' => Auth::id(), 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action. Only resort owners can view notifications.');
        }

        $resortOwnerId = Auth::id();

        // Fetch notifications relevant to this resort owner, eager load booking and its relationships
        $resortOwnerNotifications = ResortOwnerNotification::where('user_id', $resortOwnerId)
                                                            ->with('booking', 'booking.room', 'booking.user', 'booking.room.resort', 'booking.assignedBoat')
                                                            ->orderBy('created_at', 'desc')
                                                            ->paginate(10);

        $unreadCount = ResortOwnerNotification::where('user_id', $resortOwnerId)
                                              ->where('is_read', false)
                                              ->count();

        return view('resort_owner.notification', compact('resortOwnerNotifications', 'unreadCount'));
    }

    /**
     * Confirm a pending booking by a Resort Owner and assign an available boat.
     * Accessible by PUT /resort_owner/bookings/{booking}/confirm
     */
    public function confirmBooking(Booking $booking)
    {
        // Authorization: Ensure the logged-in resort owner owns this booking's resort
        if (!Auth::check() || Auth::user()->role !== 'resort_owner' || Auth::id() !== $booking->resort_owner_id) {
            Log::warning('Unauthorized booking confirmation attempt.', ['user_id' => Auth::id(), 'booking_id' => $booking->id, 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action.');
        }

        // Only allow confirmation if the status is 'pending' OR 'pending_update_approval'
        if (!in_array($booking->status, ['pending', 'pending_update_approval'])) {
            return back()->with('error', 'This booking cannot be confirmed. Current status: ' . ucfirst($booking->status) . '.');
        }

        DB::beginTransaction();
        try {
            // Get the last assigned boat ID from settings
            $lastAssignedBoatId = (int) Setting::get('last_assigned_boat_id', 0);
            
            // Get boats in the correct assignment sequence
            $boatsInSequence = Boat::getBoatsInAssignmentSequence($lastAssignedBoatId);
            
            if ($boatsInSequence->isEmpty()) {
                DB::rollBack();
                return back()->with('error', 'No available boats found. Please ensure there are "Open" status boats registered by a Boat Owner.');
            }

            // Determine the booking's time slot
            $newBookingStartTime = null;
            $newBookingEndTime = null;

            if ($booking->tour_type === 'day_tour') {
                // Fix: Handle both time and datetime formats
                if ($booking->day_tour_departure_time && $booking->day_tour_time_of_pickup) {
                    // Extract just the time part if it's a full datetime
                    $departureTime = $booking->day_tour_departure_time;
                    $pickupTime = $booking->day_tour_time_of_pickup;
                    
                    // If the time contains a space, extract just the time part
                    if (strpos($departureTime, ' ') !== false) {
                        $departureTime = explode(' ', $departureTime)[1];
                    }
                    if (strpos($pickupTime, ' ') !== false) {
                        $pickupTime = explode(' ', $pickupTime)[1];
                    }
                    
                    try {
                        $newBookingStartTime = Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $departureTime);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('error', 'Invalid departure time format. Please contact support.');
                    }
                    try {
                        $newBookingEndTime = Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $pickupTime);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('error', 'Invalid pickup time format. Please contact support.');
                    }
                    if ($newBookingEndTime->lessThan($newBookingStartTime)) {
                        $newBookingEndTime->addDay(); // Handle overnight day tours
                    }
                }
            } elseif ($booking->tour_type === 'overnight') {
                if ($booking->overnight_date_time_of_pickup && $booking->check_out_date) {
                    try {
                        $newBookingStartTime = Carbon::parse($booking->overnight_date_time_of_pickup);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('error', 'Invalid pickup time format for overnight booking. Please contact support.');
                    }
                    try {
                        $newBookingEndTime = Carbon::parse($booking->check_out_date->format('Y-m-d') . ' 23:59:59'); // Assume end of day for overnight checkout
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('error', 'Invalid checkout date format for overnight booking. Please contact support.');
                    }
                }
            }

            // IMPROVED SEQUENTIAL ASSIGNMENT LOGIC:
            // 1. Try to assign boats in strict sequential order (boats are already in correct sequence)
            // 2. This ensures all boats are assigned before any boat is reassigned
            // 3. The numbering system is maintained through the sequence
            
            // Validate that we have valid times for the booking
            if (!$newBookingStartTime || !$newBookingEndTime) {
                DB::rollBack();
                return back()->with('error', 'Invalid booking times. Please ensure departure and pickup times are properly set.');
            }
            
            $foundBoat = null;
            
            foreach ($boatsInSequence as $currentBoat) {
                // 1. Check Capacity
                if (!$currentBoat->hasSufficientCapacity($booking->number_of_guests)) {
                    continue;
                }

                // 2. Check for Time Conflict using the helper method
                if (!$currentBoat->isAvailableForTimeSlot($newBookingStartTime, $newBookingEndTime)) {
                    continue; // This boat has a conflict, try the next one
                }

                // Found an available boat that meets all criteria
                $foundBoat = $currentBoat;
                break;
            }

            if (!$foundBoat) {
                DB::rollBack();
                return back()->with('error', 'No available boat found for the requested time and guest count. All eligible boats are either booked or too small for the selected time slot.');
            }

            // Update booking status and assign boat details (but don't change boat status yet)
            $booking->status = 'approved';
            $booking->assigned_boat_id = $foundBoat->id;
            $booking->assigned_boat = $foundBoat->boat_name . ' (#' . $foundBoat->boat_number . ')';
            
            // Ensure the user relationship is loaded to get boat owner details
            if (!$foundBoat->relationLoaded('user')) {
                $foundBoat->load('user');
            }
            
            $booking->boat_captain_crew = $foundBoat->captain_name ?? 'N/A';
            $booking->boat_contact_number = $foundBoat->captain_contact ?? 'N/A';
            $booking->save();

            // DON'T mark the boat as assigned yet - this will happen on pickup day/time
            // The boat remains "open" until the actual pickup time

            // Update the last assigned boat ID in settings for sequential assignment
            Setting::set('last_assigned_boat_id', $foundBoat->id);

            // Mark associated resort owner notification as read
            ResortOwnerNotification::where('booking_id', $booking->id)
                                    ->where('user_id', Auth::id())
                                    ->whereIn('type', ['new_booking', 'booking_updated']) // Mark both new booking and updated booking notifications as read
                                    ->update(['is_read' => true]);

            // Notify Tourist: booking approved, boat will be activated 30 mins before departure
            TouristNotification::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'message' => 'Your booking for ' . ($booking->room->room_name ?? 'a room') . ' at ' . $booking->name_of_resort . ' has been APPROVED. A boat will be assigned 30 minutes before departure.',
                'type' => 'booking_approved_pending_assignment',
                'is_read' => false,
            ]);

            // Inform each party that assignment will happen on the reservation date
            ResortOwnerNotification::create([
                'user_id' => $booking->resort_owner_id,
                'booking_id' => $booking->id,
                'message' => 'Booking approved. Boat will be assigned automatically on the reservation date.',
                'type' => 'boat_assignment_pending',
                'is_read' => false,
            ]);

            TouristNotification::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'message' => 'Booking approved. Please wait — your boat will be assigned on your reservation date.',
                'type' => 'boat_assignment_pending',
                'is_read' => false,
            ]);

            // Boat owner heads-up without revealing guest details earlier than necessary
            if ($foundBoat && $foundBoat->user_id) {
            BoatOwnerNotification::create([
                'user_id' => $foundBoat->user_id,
                'booking_id' => $booking->id,
                    'message' => 'A booking using your boat is approved. Assignment will occur on the guest\'s reservation date.',
                    'type' => 'boat_assignment_pending',
                'is_read' => false,
            ]);
            }

            DB::commit();
            return back()->with('success', 'Booking approved. Your reserved boat ('. $foundBoat->boat_name .') will be activated 30 minutes before departure.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to confirm booking: " . $e->getMessage(), ['booking_id' => $booking->id, 'user_id' => Auth::id(), 'exception' => $e]);
            return back()->with('error', 'Failed to confirm booking. Please try again.');
        }
    }

    /**
     * Reject a pending booking by a Resort Owner.
     * Accessible by PUT /resort_owner/bookings/{booking}/reject
     */
    public function rejectBooking(Booking $booking)
    {
        // Authorization: Ensure the logged-in resort owner owns this booking's resort
        if (!Auth::check() || Auth::user()->role !== 'resort_owner' || Auth::id() !== $booking->resort_owner_id) {
            Log::warning('Unauthorized booking rejection attempt.', ['user_id' => Auth::id(), 'booking_id' => $booking->id, 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action.');
        }

        // Only allow rejection if the status is 'pending' OR 'pending_update_approval'
        if (!in_array($booking->status, ['pending', 'pending_update_approval'])) {
            return back()->with('error', 'This booking cannot be rejected. Current status: ' . ucfirst($booking->status) . '.');
        }

        DB::beginTransaction();
        try {
            $booking->update(['status' => 'rejected']);

            // Mark associated resort owner notification as read
            ResortOwnerNotification::where('booking_id', $booking->id)
                                    ->where('user_id', Auth::id())
                                    ->whereIn('type', ['new_booking', 'booking_updated']) // Mark both new booking and updated booking notifications as read
                                    ->update(['is_read' => true]);

            // Create a notification for the Tourist
            TouristNotification::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'message' => 'Unfortunately, your booking for ' . ($booking->room->room_name ?? 'a room') . ' at ' . ($booking->name_of_resort ?? 'the resort') . ' has been REJECTED.', // Added null coalescing for resort name
                'type' => 'booking_rejected',
                'is_read' => false,
            ]);

            // If a boat was previously assigned (e.g., if it was approved and then updated, and now rejected),
            // ensure the boat owner is notified that the boat is no longer needed for this booking.
            if ($booking->assigned_boat_id) {
                $boat = Boat::find($booking->assigned_boat_id);
                if ($boat) {
                    BoatOwnerNotification::create([
                        'user_id' => $boat->user_id,
                        'booking_id' => $booking->id,
                        'message' => 'Booking for ' . $booking->guest_name . ' on ' . $boat->boat_name . ' has been rejected. Your boat is now available.',
                        'type' => 'boat_unassigned',
                        'is_read' => false,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Booking rejected successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to reject booking: " . $e->getMessage(), ['booking_id' => $booking->id, 'user_id' => Auth::id(), 'exception' => $e]);
            return back()->with('error', 'Failed to reject booking. Please try again.');
        }
    }

    /**
     * Mark a resort owner notification as read.
     * Accessible by PUT /resort_owner/notifications/{notification}/mark-as-read
     */
    public function markAsRead(ResortOwnerNotification $notification)
    {
        // Role check is handled by middleware 'auth' in web.php
        // Ensure the notification belongs to the authenticated resort owner
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $notification->update(['is_read' => true]);

        // Return JSON response for AJAX requests
        return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
    }

    /**
     * Mark all resort owner notifications as read.
     * Accessible by PUT /resort_owner/notifications/mark-all-as-read
     */
    public function markAllResortOwnerNotificationsAsRead()
    {
        // Ensure only resort owners can access this
        if (!Auth::check() || Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized access.');
        }

        try {
            ResortOwnerNotification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
        } catch (\Exception $e) {
            Log::error("Failed to mark all resort owner notifications as read: " . $e->getMessage());
            return response()->json(['error' => 'Failed to mark all notifications as read. Please try again.'], 500);
        }
    }

    /**
     * Delete a resort owner notification.
     * Accessible by DELETE /resort_owner/notifications/{notification}/destroy
     */
    public function destroyResortOwnerNotification(ResortOwnerNotification $notification)
    {
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $notification->delete();
            
            // Return JSON response if request expects JSON, otherwise redirect back
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Notification deleted successfully.']);
            }
            
            return back()->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete resort owner notification: " . $e->getMessage(), ['notification_id' => $notification->id]);
            
            // Return JSON response if request expects JSON, otherwise redirect back
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'error' => 'Failed to delete notification. Please try again.'], 500);
            }
            
            return back()->with('error', 'Failed to delete notification. Please try again.');
        }
    }

    /**
     * Show a single booking detail.
     */
    public function show(Booking $booking)
    {
        // Middleware handles general authentication.
        // Internal logic handles specific role-based authorization for viewing.
        if (!Auth::check()) {
            abort(403, 'Unauthorized action. Please log in.');
        }

        $user = Auth::user();

        // A tourist can view their own booking
        // A resort owner can view bookings for their own resorts
        // An admin can view any booking
        // A boat owner can view bookings if their boat is assigned to it
        if (($user->role === 'tourist' && $user->id !== $booking->user_id) ||
            ($user->role === 'resort_owner' && $user->id !== $booking->resort_owner_id) ||
            ($user->role === 'boat_owner' && $user->id !== optional($booking->assignedBoat)->user_id)
            && $user->role !== 'admin'
        ) {
            Log::warning('Unauthorized attempt to view booking.', ['user_id' => $user->id, 'role' => $user->role, 'booking_id' => $booking->id]);
            abort(403, 'Unauthorized action. You are not authorized to view this booking.');
        }

        // Eager load necessary relationships for the booking details view
        $booking->load('user', 'room.resort', 'assignedBoat.user');

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking by a Tourist.
     * Accessible by PUT /bookings/{booking}/cancel
     */
    public function cancel(Booking $booking)
    {
        // Role check is handled by middleware 'auth' in web.php
        if (!Auth::check() || Auth::user()->role !== 'tourist' || Auth::id() !== $booking->user_id) {
            Log::warning('Unauthorized booking cancellation attempt.', ['user_id' => Auth::id(), 'booking_id' => $booking->id, 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation if the booking is pending or approved or pending_update_approval
        if (!in_array($booking->status, ['pending', 'approved', 'pending_update_approval'])) {
            return back()->with('error', 'Booking cannot be cancelled in its current status: ' . $booking->status);
        }

        DB::beginTransaction();
        try {
            $booking->update(['status' => 'cancelled']);

            // If a boat was assigned, notify the boat owner that the boat is now available again
            if ($booking->assigned_boat_id) {
                $boat = Boat::find($booking->assigned_boat_id);

                if ($boat) {
                    BoatOwnerNotification::create([
                        'user_id' => $boat->user_id,
                        'booking_id' => $booking->id,
                        'message' => $boat->boat_name . ' is now available as the booking for ' . $booking->guest_name . ' was cancelled.',
                        'type' => 'boat_available',
                        'is_read' => false,
                    ]);
                } else {
                    Log::warning('Cancelled booking: Could not find assigned boat with ID ' . $booking->assigned_boat_id . '.', ['booking_id' => $booking->id]);
                }
            }

            // Create a notification for the Resort Owner about the cancellation
            ResortOwnerNotification::create([
                'user_id' => $booking->resort_owner_id,
                'booking_id' => $booking->id,
                'message' => 'Booking for ' . ($booking->room->room_name ?? 'a room') . ' at ' . ($booking->name_of_resort ?? 'the resort') . ' by ' . Auth::user()->name . ' has been CANCELLED by the tourist.',
                'type' => 'booking_cancelled',
                'is_read' => false,
            ]);

            DB::commit();
            return back()->with('success', 'Booking cancelled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to cancel booking: " . $e->getMessage(), ['booking_id' => $booking->id, 'user_id' => Auth::id(), 'exception' => $e]);
            return back()->with('error', 'Failed to cancel booking. Please try again.');
        }
    }

    /**
     * Mark a booking as completed and send notifications to tourist and boat owner.
     * Accessible by PUT /resort_owner/bookings/{booking}/complete
     */
    public function completeBooking(Booking $booking)
    {
        $user = Auth::user();
        // Authorization: Only resort owners or administrators can mark bookings as complete.
        if (!Auth::check() || ($user->role !== 'resort_owner' && $user->role !== 'admin')) {
            Log::warning('Unauthorized attempt to complete booking: role mismatch.', ['user_id' => Auth::id(), 'role' => $user->role ?? 'guest']);
            abort(403, 'Unauthorized action. Only resort owners or administrators can mark bookings as complete.');
        }

        // If resort owner, ensure they own the resort associated with this booking.
        if ($user->role === 'resort_owner' && $user->id !== $booking->resort_owner_id) {
            Log::warning('Unauthorized attempt to complete booking: resort owner does not own booking.', ['user_id' => Auth::id(), 'booking_id' => $booking->id, 'booking_owner_id' => $booking->resort_owner_id]);
            abort(403, 'Unauthorized action. You are not authorized to complete this booking.');
        }

        if ($booking->status !== 'approved') {
            return back()->with('error', 'This booking cannot be marked as completed. Current status: ' . ucfirst($booking->status) . '. Only approved bookings can be completed.');
        }

        DB::beginTransaction();
        try {
            $booking->status = 'completed';
            $booking->save();

            // Optionally, mark any related resort owner notification as read if it was about this booking
            ResortOwnerNotification::where('booking_id', $booking->id)
                                    ->where('user_id', $user->id)
                                    ->update(['is_read' => true]);

            // Create a notification for the Tourist about the completion
            TouristNotification::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'message' => 'Your booking for ' . ($booking->room->room_name ?? 'a room') . ' at ' . ($booking->name_of_resort ?? 'the resort') . ' has been marked as COMPLETED. We hope you enjoyed your visit!',
                'type' => 'booking_completed',
                'is_read' => false,
            ]);

            // If a boat was assigned, notify the boat owner that the booking is completed
            if ($booking->assigned_boat_id && $booking->assignedBoat) {
                BoatOwnerNotification::create([
                    'user_id' => $booking->assignedBoat->user_id,
                    'booking_id' => $booking->id,
                    'message' => 'Booking for ' . $booking->guest_name . ' on ' . $booking->assignedBoat->boat_name . ' has been completed.',
                    'type' => 'booking_completed',
                    'is_read' => false,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Booking successfully marked as completed!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to complete booking: " . $e->getMessage(), ['booking_id' => $booking->id, 'user_id' => Auth::id(), 'exception' => $e]);
            return back()->with('error', 'Failed to mark booking as completed. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified booking in storage by a Tourist.
     * Accessible by PUT /tourist/bookings/{booking}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        // Authorization: Only allow the tourist who owns this booking to update it.
        if (!Auth::check() || Auth::user()->role !== 'tourist' || Auth::id() !== $booking->user_id) {
            Log::warning('Unauthorized booking update attempt.', ['user_id' => Auth::id(), 'booking_id' => $booking->id, 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action. You are not authorized to update this booking.');
        }

        // Only allow updating if the booking status is 'pending' or 'pending_update_approval'.
        if (!in_array($booking->status, ['pending', 'pending_update_approval'])) {
            return redirect()->route('tourist.visit')->with('error', 'This booking cannot be updated because its status is no longer pending or awaiting update approval.');
        }

        // Store original data before updating for notification comparison
        // Added room price, resort address, and resort contact number by loading relations
        $booking->load('room.resort'); // Ensure relations are loaded
        $originalData = $booking->only([
            'guest_name', 'guest_age', 'guest_gender', 'guest_address', 'guest_nationality',
            'phone_number', 'check_in_date', 'check_out_date', 'number_of_nights',
            'number_of_guests', 'special_requests', 'tour_type',
            'day_tour_departure_time', 'day_tour_time_of_pickup', 'overnight_date_time_of_pickup',
            'num_senior_citizens', 'num_pwds', 'name_of_resort'
        ]);
        // Add room price, resort address, and resort contact number from related models
        $originalData['room_price'] = $booking->room->price ?? 'N/A';
        $originalData['resort_address'] = $booking->room->resort->address ?? 'N/A';
        $originalData['resort_contact_number'] = $booking->room->resort->contact_number ?? 'N/A';


        // Validate the request data for editable fields
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|regex:/^[0-9]{11}$/',
            'reservation_date' => 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'num_guests' => 'required|integer|min:1',
            'tour_type' => ['required', Rule::in(['day_tour', 'overnight'])],
            'num_nights' => 'nullable|integer|min:0|required_if:tour_type,overnight',
            'day_tour_departure_time' => 'nullable|required_if:tour_type,day_tour|date_format:H:i',
            'day_tour_time_of_pickup' => 'nullable|required_if:tour_type,day_tour|date_format:H:i',
            'overnight_date_time_of_pickup' => 'nullable|required_if:tour_type,overnight|date_format:Y-m-d\TH:i',
            'num_senior_citizens' => 'nullable|integer|min:0',
            'num_pwds' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string|max:1000',
        ], [
            'contact_number.regex' => 'The number is not enough. Please enter exactly 11 digits.',
        ]);

        DB::beginTransaction();
        try {
            $checkInDate = Carbon::parse($validatedData['reservation_date']);
            $checkOutDate = null;
            $numberOfNights = (int) ($validatedData['num_nights'] ?? 0);

            if ($validatedData['tour_type'] === 'overnight') {
                $checkOutDate = $checkInDate->copy()->addDays($numberOfNights);
            } else {
                $checkOutDate = null;
                $numberOfNights = 0;
            }

            $updatedBookingData = [
                'guest_name' => trim($validatedData['first_name'] . ' ' .
                                      ($validatedData['middle_name'] ? $validatedData['middle_name'] . ' ' : '') .
                                      $validatedData['last_name']),
                'guest_age' => $validatedData['age'],
                'guest_gender' => $validatedData['gender'],
                'guest_address' => $validatedData['address'],
                'guest_nationality' => $validatedData['nationality'],
                'phone_number' => $validatedData['contact_number'],
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkOutDate,
                'number_of_nights' => $numberOfNights,
                'number_of_guests' => $validatedData['num_guests'],
                'special_requests' => $validatedData['special_requests'] ?? null,
                'tour_type' => $validatedData['tour_type'],
                // Set to null if not applicable based on tour_type
                'day_tour_departure_time' => ($validatedData['tour_type'] === 'day_tour') ? ($validatedData['day_tour_departure_time'] ?? null) : null,
                'day_tour_time_of_pickup' => ($validatedData['tour_type'] === 'day_tour') ? ($validatedData['day_tour_time_of_pickup'] ?? null) : null,
                'overnight_date_time_of_pickup' => ($validatedData['tour_type'] === 'overnight') ? ($validatedData['overnight_date_time_of_pickup'] ?? null) : null,
                'num_senior_citizens' => $validatedData['num_senior_citizens'] ?? 0,
                'num_pwds' => $validatedData['num_pwds'] ?? 0,
                'status' => 'pending_update_approval', // Set status to indicate it needs review
            ];

            $booking->update($updatedBookingData);

            // --- Create Notification for Resort Owner about the update ---
            $resortOwnerId = $booking->resort_owner_id; // Get the resort owner ID from the booking

            // Prepare data for the notification message to show what changed
            $changedFields = [];

            // Compare and collect changes
            // Use fresh() to get the updated booking data for comparison against original
            $freshBooking = $booking->fresh()->load('room.resort');

            // Helper function to compare and format changes
            $compareAndAddChange = function ($oldValue, $newValue, $label, &$changedFields) {
                // Handle Carbon instances by converting to string for comparison
                if ($oldValue instanceof Carbon) $oldValue = $oldValue->toDateTimeString();
                if ($newValue instanceof Carbon) $newValue = $newValue->toDateTimeString();

                if ((string)$oldValue !== (string)$newValue) { // Cast to string for consistent comparison of various types
                    $changedFields[] = "{$label} (from '{$oldValue}' to '{$newValue}')";
                }
            };

            $compareAndAddChange($originalData['guest_name'], $freshBooking->guest_name, 'Guest Name', $changedFields);
            $compareAndAddChange($originalData['guest_age'], $freshBooking->guest_age, 'Age', $changedFields);
            $compareAndAddChange($originalData['guest_gender'], $freshBooking->guest_gender, 'Gender', $changedFields);
            $compareAndAddChange($originalData['guest_address'], $freshBooking->guest_address, 'Address', $changedFields);
            $compareAndAddChange($originalData['guest_nationality'], $freshBooking->guest_nationality, 'Nationality', $changedFields);
            $compareAndAddChange($originalData['phone_number'], $freshBooking->phone_number, 'Contact Number', $changedFields);

            // For dates, compare formatted strings
            $originalCheckIn = null;
            try {
                $originalCheckIn = Carbon::parse($originalData['check_in_date'])->toDateString();
            } catch (\Exception $e) {
                $originalCheckIn = $originalData['check_in_date'];
            }
            
            $compareAndAddChange(
                $originalCheckIn,
                $freshBooking->check_in_date->toDateString(),
                'Reservation Date',
                $changedFields
            );

            // Check out date will change if check-in or num_nights change for overnight
            if ($originalData['tour_type'] === 'overnight' || $freshBooking->tour_type === 'overnight') {
                $originalCheckout = null;
                if (isset($originalData['check_out_date']) && $originalData['check_out_date']) {
                    try {
                        $originalCheckout = Carbon::parse($originalData['check_out_date'])->toDateString();
                    } catch (\Exception $e) {
                        $originalCheckout = $originalData['check_out_date'];
                    }
                }
                $newCheckout = optional($freshBooking->check_out_date)->toDateString();
                if ($originalCheckout !== $newCheckout) {
                    $changedFields[] = "Check-out Date (from '" . ($originalCheckout ?? 'N/A') . "' to '" . ($newCheckout ?? 'N/A') . "')";
                }
            }

            $compareAndAddChange($originalData['number_of_guests'], $freshBooking->number_of_guests, 'Number of Guests', $changedFields);
            $compareAndAddChange($originalData['tour_type'], $freshBooking->tour_type, 'Tour Type', $changedFields);

            // Specific time comparisons based on tour type
            if ($originalData['tour_type'] === 'day_tour' || $freshBooking->tour_type === 'day_tour') {
                $compareAndAddChange(
                    $originalData['day_tour_departure_time'] ?? '',
                    $freshBooking->day_tour_departure_time ?? '',
                    'Departure Time (Day Tour)',
                    $changedFields
                );
                $compareAndAddChange(
                    $originalData['day_tour_time_of_pickup'] ?? '',
                    $freshBooking->day_tour_time_of_pickup ?? '',
                    'Time of Pickup (Day Tour)',
                    $changedFields
                );
            }
            if ($originalData['tour_type'] === 'overnight' || $freshBooking->tour_type === 'overnight') {
                $compareAndAddChange(
                    $originalData['overnight_date_time_of_pickup'] ?? '',
                    $freshBooking->overnight_date_time_of_pickup ?? '',
                    'Pickup Date/Time (Overnight)',
                    $changedFields
                );
                $compareAndAddChange(
                    $originalData['number_of_nights'] ?? 0,
                    $freshBooking->number_of_nights ?? 0,
                    'Number of Nights',
                    $changedFields
                );
            }

            $compareAndAddChange($originalData['num_senior_citizens'] ?? 0, $freshBooking->num_senior_citizens ?? 0, 'Senior Citizens', $changedFields);
            $compareAndAddChange($originalData['num_pwds'] ?? 0, $freshBooking->num_pwds ?? 0, 'PWDs', $changedFields);

            if (($originalData['special_requests'] ?? '') !== ($freshBooking->special_requests ?? '')) {
                $changedFields[] = "Special Requests (Updated)";
            }

            $compareAndAddChange($originalData['room_price'], $freshBooking->room->price ?? 'N/A', 'Room Price', $changedFields);
            $compareAndAddChange($originalData['resort_address'], $freshBooking->room->resort->address ?? 'N/A', 'Resort Address', $changedFields);
            $compareAndAddChange($originalData['resort_contact_number'], $freshBooking->room->resort->contact_number ?? 'N/A', 'Resort Contact No.', $changedFields);
            $compareAndAddChange($originalData['name_of_resort'], $freshBooking->name_of_resort, 'Resort Name', $changedFields);


            $changesSummary = empty($changedFields) ? "No significant changes were detected." : "Changes: " . implode(", ", $changedFields) . ".";

            ResortOwnerNotification::create([
                'user_id' => $resortOwnerId,
                'booking_id' => $booking->id,
                'message' => 'Tourist ' . Auth::user()->name . ' has updated their booking request (ID: ' . $booking->id . ') for room: ' . ($booking->room->room_name ?? 'N/A') . ' at ' . ($booking->name_of_resort ?? 'the resort') . '. ' . $changesSummary,
                'type' => 'booking_updated',
                'is_read' => false,
                'data' => json_encode([ // Store more structured data for display
                    'original_data' => $originalData,
                    'new_data' => $freshBooking->toArray(), // Get the fresh data after update
                    'changed_fields_summary' => $changedFields,
                ]),
            ]);

            if ($booking->getOriginal('status') === 'approved' && $booking->assigned_boat_id) {
                $boat = Boat::find($booking->assigned_boat_id);
                if ($boat) {
                    BoatOwnerNotification::create([
                        'user_id' => $boat->user_id,
                        'booking_id' => $booking->id,
                        'message' => 'Booking for ' . $booking->guest_name . ' on ' . $boat->boat_name . ' has been updated. Resort owner needs to re-confirm. Your boat may be reassigned.',
                        'type' => 'booking_details_updated',
                        'is_read' => false,
                    ]);
                }
            }


            DB::commit();
            return redirect()->route('tourist.visit')->with('success', 'Booking updated successfully! The resort owner will review the changes.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to update booking: " . $e->getMessage(), ['booking_id' => $booking->id, 'user_id' => Auth::id(), 'request_data' => $request->all(), 'exception' => $e]);
            return back()->withInput()->with('error', 'Failed to update booking. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified booking from storage by a Tourist.
     * Accessible by DELETE /tourist/bookings/{booking}/delete
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        // Authorization: Only allow the tourist who owns this booking to delete it.
        if (!Auth::check() || Auth::user()->role !== 'tourist' || Auth::id() !== $booking->user_id) {
            Log::warning('Unauthorized booking deletion attempt.', ['user_id' => Auth::id(), 'booking_id' => $booking->id, 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action. You are not authorized to delete this booking.');
        }

        // Only allow deletion if the status is approved, rejected, cancelled, or completed, or pending update approval.
        if (!in_array($booking->status, ['approved', 'rejected', 'cancelled', 'completed', 'pending_update_approval', 'pending'])) {
            return back()->with('error', 'This booking cannot be deleted. Only approved, rejected, cancelled, completed, pending, or pending update approval bookings can be removed from your list.');
        }

        DB::beginTransaction();
        try {
            // If a boat was assigned, and the booking is being deleted (not just cancelled),
            // you might want to ensure the boat owner is aware it's now completely free.
            // This is especially important if the booking was 'approved'.
            if ($booking->assigned_boat_id && $booking->assignedBoat && $booking->status === 'approved') {
                BoatOwnerNotification::create([
                    'user_id' => $booking->assignedBoat->user_id,
                    'booking_id' => $booking->id,
                    'message' => 'Booking for ' . $booking->guest_name . ' on ' . $booking->assignedBoat->boat_name . ' has been cancelled. Your boat is now available.',
                    'type' => 'booking_deleted',
                    'is_read' => false,
                ]);
            }

            // Delete associated notifications first to avoid foreign key constraints
            TouristNotification::where('booking_id', $booking->id)->delete();
            ResortOwnerNotification::where('booking_id', $booking->id)->delete();
            BoatOwnerNotification::where('booking_id', $booking->id)->delete();

            $booking->delete();

            DB::commit();
            return redirect()->route('tourist.visit')->with('success', 'Booking record deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete booking record: " . $e->getMessage(), ['booking_id' => $booking->id, 'user_id' => Auth::id(), 'exception' => $e]);
            return back()->with('error', 'Failed to delete booking record. Please try again.');
        }
    }

    /**
     * Display booking notifications for the authenticated Boat Owner.
     * Accessible by GET /boat_owner/notification
     */
    public function showBoatOwnerNotifications()
    {
        if (!Auth::check() || Auth::user()->role !== 'boat_owner') {
            Log::warning('Unauthorized access attempt to boat owner notifications.', ['user_id' => Auth::id(), 'role' => Auth::check() ? Auth::user()->role : 'guest']);
            abort(403, 'Unauthorized action. Only boat owners can view notifications.');
        }

        $boatOwnerId = Auth::id();

        $boatOwnerNotifications = BoatOwnerNotification::where('user_id', $boatOwnerId)
                                                        ->with('booking', 'booking.room', 'booking.user', 'booking.assignedBoat')
                                                        ->orderBy('created_at', 'desc')
                                                        ->paginate(10);

        return view('boat_owner.notification', compact('boatOwnerNotifications'));
    }

    /**
     * Mark a boat owner notification as read.
     * Accessible by PUT /boat_owner/notifications/{notification}/mark-as-read
     */
    public function markBoatOwnerNotificationAsRead(BoatOwnerNotification $notification)
    {
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Delete a boat owner notification.
     * Accessible by DELETE /boat_owner/notifications/{notification}/destroy
     */
    public function destroyBoatOwnerNotification(BoatOwnerNotification $notification)
    {
        if (!Auth::check() || Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $notification->delete();
            return back()->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete boat owner notification: " . $e->getMessage(), ['notification_id' => $notification->id]);
            return back()->with('error', 'Failed to delete notification. Please try again.');
        }
    }
}