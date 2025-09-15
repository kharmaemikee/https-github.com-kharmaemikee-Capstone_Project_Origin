<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\ResortOwner\ResortController;
use App\Models\Resort;
use App\Models\Room;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\Admin\AdminResortController;
use App\Http\Controllers\Admin\AdminBoatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TouristController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Session;
use App\Models\User; // Import User model
use App\Console\Commands\UpdateBookingStatuses;
use App\Models\Booking; // ADDED: Import the Booking model
use Carbon\Carbon; // ADDED: Import Carbon for date manipulation
use Illuminate\Support\Facades\Log; // ADDED: Import Log for debugging
use App\Models\ResortOwnerNotification;
use App\Models\BoatOwnerNotification;

// Set Login Page as the First Page
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Test route to check if verification works
Route::get('/test-verification', function () {
    return view('auth.verify-phone');
})->name('test.verification');


// Admin Dashboard Route
Route::get('/admin/admin', function () {
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
    // Updated: Pass totalForeigners and totalFilipinos data to the view
    $totalForeigners = User::whereRaw('LOWER(nationality) != ?', ['filipino'])->count();
    $totalFilipinos = User::whereRaw('LOWER(nationality) = ?', ['filipino'])->count();
    
    // Add tour type statistics for bar graph
    $dayTourCount = \App\Models\Booking::where('tour_type', 'day_tour')->where('status', '!=', 'rejected')->count();
    $overnightCount = \App\Models\Booking::where('tour_type', 'overnight')->where('status', '!=', 'rejected')->count();
    
    
    return view('admin.admin', compact(
        'totalForeigners', 
        'totalFilipinos', 
        'dayTourCount', 
        'overnightCount'
    ));
})->middleware(['auth', \App\Http\Middleware\AuthenticateWithPhone::class])->name('admin');


// Tourist Dashboard
Route::get('/tourist', [TouristController::class, 'dashboard'])
    ->middleware(['auth', \App\Http\Middleware\AuthenticateWithPhone::class])
    ->name('tourist.tourist');


// Resort Owner Dashboard (redirect to information page)
Route::get('/resort_owner/resort', function () {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    return redirect()->route('resort.owner.information');
})->middleware(['auth', \App\Http\Middleware\AuthenticateWithPhone::class])->name('resort');


// Resort Owner Information Page (will display the list of resorts)
Route::get('/resort_owner/resort-information', [ResortController::class, 'index'])
    ->middleware(['auth'])
    ->name('resort.owner.information')
    ->middleware('can:access-resort-features');

// --- CORRECTED/ADDED ROUTES FOR EDIT/UPDATE/DELETE ---
// Route for displaying the edit resort form
Route::get('/resorts/{resort}/edit', [ResortController::class, 'edit'])
    ->middleware(['auth'])
    ->name('resort.owner.edit');

// Route for handling the update of a resort (using PUT/PATCH method)
Route::put('/resorts/{resort}', [ResortController::class, 'update'])
    ->middleware(['auth'])
    ->name('resort.owner.update');

// NEW: Route for updating resort status
Route::put('/resorts/{resort}/status', [ResortController::class, 'updateStatus'])
    ->middleware(['auth'])
    ->name('resort.owner.update_status');

// Route for handling resort deletion
Route::delete('/resorts/{resort}', [ResortController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('resort.owner.destroy');
// --- END OF CORRECTED/ADDED ROUTES FOR RESORT CRUD ---


// NEW: Room Management Routes for Resort Owners
Route::get('/resort_owner/resorts/{resort}/rooms', function (Resort $resort) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    // Redirect legacy rooms index to consolidated resort information page
    return redirect()->route('resort.owner.information');
})->middleware(['auth'])->name('resort.owner.rooms.index');

Route::get('/resort_owner/resorts/{resort}/rooms/create', function (Resort $resort) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    return (new RoomController())->create($resort);
})->middleware(['auth'])->name('resort.owner.rooms.create');

Route::post('/resort_owner/resorts/{resort}/rooms', function (Request $request, Resort $resort) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    return (new RoomController())->store($request, $resort);
})->middleware(['auth'])->name('resort.owner.rooms.store');

// Room routes that do not need the resort context in the URL for editing/deleting a specific room
Route::get('/resort_owner/rooms/{room}/edit', function (App\Models\Room $room) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    return (new RoomController())->edit($room);
})->middleware(['auth'])->name('resort.owner.rooms.edit');

Route::put('/resort_owner/rooms/{room}', function (Request $request, App\Models\Room $room) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    return (new RoomController())->update($request, $room);
})->middleware(['auth'])->name('resort.owner.rooms.update');

Route::delete('/resort_owner/rooms/{roomId}', function ($roomId) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    
    // Find the room including archived ones
    $room = App\Models\Room::withArchived()->find($roomId);
    if (!$room) {
        abort(404, 'Room not found');
    }
    
    return (new RoomController())->destroy($room);
})->middleware(['auth'])->name('resort.owner.rooms.destroy');

// Archive room routes
Route::put('/resort_owner/rooms/{roomId}/archive', function ($roomId) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    
    // Find the room including archived ones
    $room = App\Models\Room::withArchived()->find($roomId);
    if (!$room) {
        abort(404, 'Room not found');
    }
    
    return (new RoomController())->archive($room);
})->middleware(['auth'])->name('resort.owner.rooms.archive');

Route::put('/resort_owner/rooms/restore/{roomId}', function ($roomId) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }

    // Debug: Log the roomId being received
    Log::info('Restore route called with roomId: ' . $roomId);
    
    // Find the room including archived ones
    $room = App\Models\Room::withArchived()->find($roomId);
    if (!$room) {
        Log::error('Room not found with ID: ' . $roomId);
        abort(404, 'Room not found');
    }
    
    return (new App\Http\Controllers\RoomController())->restore($room);
})->middleware(['auth'])->name('resort.owner.rooms.restore');

Route::get('/resort_owner/rooms/{resort}/archive', function (App\Models\Resort $resort) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    return (new RoomController())->archiveIndex($resort);
})->middleware(['auth'])->name('resort.owner.rooms.archive.index');

// Paginated room images fragment
Route::get('/resort_owner/rooms/{room}/images', function (App\Models\Room $room) {
    return (new RoomController())->images($room);
})->middleware(['auth'])->name('resort.owner.rooms.images');


// END NEW ROOM MANAGEMENT ROUTES


// Other Resort Owner specific pages
Route::get('/resort_owner/dashboard', function (Request $request) {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }

    // ADDED: Logic to fetch booking data through rooms
    $resortIds = Auth::user()->resorts()->pluck('id');
    
    // Debug logging
    Log::info('Resort Owner Dashboard - User ID: ' . Auth::id());
    Log::info('Resort Owner Dashboard - Resort IDs: ' . $resortIds->toJson());
    
    if ($resortIds->isEmpty()) {
        Log::info('Resort Owner Dashboard - No resorts found');
        $labels = [];
        $data = [];
    } else {
        // Get room IDs that belong to the resort owner's resorts
        $roomIds = Room::whereIn('resort_id', $resortIds)->pluck('id');
        
        Log::info('Resort Owner Dashboard - Room IDs: ' . $roomIds->toJson());
        
        if ($roomIds->isEmpty()) {
            Log::info('Resort Owner Dashboard - No rooms found');
            $labels = [];
            $data = [];
        } else {
            // Get bookings for rooms that belong to the resort owner's resorts
            // First, let's get ALL bookings for these rooms to debug
            $allBookings = Booking::whereIn('room_id', $roomIds)->get();
            Log::info('Resort Owner Dashboard - ALL bookings for rooms: ' . $allBookings->count());
            
            // Log each booking to see what we have
            foreach ($allBookings as $booking) {
                Log::info('Resort Owner Dashboard - Booking ID: ' . $booking->id . ', Room: ' . $booking->room_id . ', Date: ' . $booking->check_in_date . ', Status: ' . $booking->status);
            }
            
            // Now get bookings within the date range
            $bookings = Booking::whereIn('room_id', $roomIds)
                               ->whereBetween('check_in_date', [
                                   Carbon::now()->subMonths(11)->startOfMonth(),
                                   Carbon::now()->endOfMonth()
                               ])
                               ->get();
            
            Log::info('Resort Owner Dashboard - Bookings in date range: ' . $bookings->count());

            $monthlyBookings = [];
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthlyBookings[$month->format('M Y')] = 0;
            }

            foreach ($bookings as $booking) {
                $month = Carbon::parse($booking->check_in_date)->format('M Y');
                if (isset($monthlyBookings[$month])) {
                    $monthlyBookings[$month]++;
                }
            }

            $labels = array_keys($monthlyBookings);
            $data = array_values($monthlyBookings);
        }
    }
    
    // Calculate overall resort usage statistics
    $totalBookings = 0;
    $activeBookings = 0;
    $totalGuests = 0;
    $totalRevenue = 0;
    $revenueFilterLabel = null;
    $revenueBreakdown = collect();
    
    if (!$resortIds->isEmpty()) {
        $roomIds = Room::whereIn('resort_id', $resortIds)->pluck('id');
        if (!$roomIds->isEmpty()) {
            $allBookingsQuery = Booking::whereIn('room_id', $roomIds)->with(['assignedBoat','room']);

            // Clone query for stats without filters
            $allBookings = (clone $allBookingsQuery)->get();
            
            $totalBookings = $allBookings->count();
            $activeBookings = $allBookings->whereIn('status', ['approved', 'pending'])->count();
            $totalGuests = $allBookings->sum('number_of_guests');
            
            // Calculate total revenue from room bookings only (not boat services) with optional filters
            $filterType = $request->input('filter_type'); // 'day' | 'month'
            if ($filterType === 'day' && $request->filled('date')) {
                $date = Carbon::parse($request->input('date'))->toDateString();
                $revenueFilterLabel = 'for ' . Carbon::parse($date)->format('F d, Y');
                $revenueBookings = (clone $allBookingsQuery)
                    ->whereDate('check_in_date', $date)
                    ->where('status', 'approved')
                    ->get();
            } elseif ($filterType === 'date_range' && $request->filled('date_start') && $request->filled('date_end')) {
                $start = Carbon::parse($request->input('date_start'))->startOfDay();
                $end = Carbon::parse($request->input('date_end'))->endOfDay();
                if ($end->lessThan($start)) { [$start, $end] = [$end, $start]; }
                $revenueFilterLabel = 'from ' . $start->format('F d, Y') . ' to ' . $end->format('F d, Y');
                $revenueBookings = (clone $allBookingsQuery)
                    ->whereBetween('check_in_date', [$start, $end])
                    ->where('status', 'approved')
                    ->get();
            } elseif ($filterType === 'month' && $request->filled('month')) {
                $monthInput = $request->input('month'); // YYYY-MM
                $monthCarbon = Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth();
                $revenueFilterLabel = 'for ' . $monthCarbon->format('F Y');
                $revenueBookings = (clone $allBookingsQuery)
                    ->whereYear('check_in_date', $monthCarbon->year)
                    ->whereMonth('check_in_date', $monthCarbon->month)
                    ->where('status', 'approved')
                    ->get();
            } elseif ($filterType === 'month_range' && $request->filled('month_start') && $request->filled('month_end')) {
                $start = Carbon::createFromFormat('Y-m', $request->input('month_start'))->startOfMonth();
                $end = Carbon::createFromFormat('Y-m', $request->input('month_end'))->endOfMonth();
                if ($end->lessThan($start)) { [$start, $end] = [$end, $start]; }
                $revenueFilterLabel = 'from ' . $start->format('F Y') . ' to ' . $end->format('F Y');
                $revenueBookings = (clone $allBookingsQuery)
                    ->whereBetween('check_in_date', [$start, $end])
                    ->where('status', 'approved')
                    ->get();
            } elseif ($filterType === 'year' && $request->filled('year')) {
                $year = (int) $request->input('year');
                $revenueFilterLabel = 'for ' . $year;
                $revenueBookings = (clone $allBookingsQuery)
                    ->whereYear('check_in_date', $year)
                    ->where('status', 'approved')
                    ->get();
            } elseif ($filterType === 'year_range' && $request->filled('year_start') && $request->filled('year_end')) {
                $startYear = (int) $request->input('year_start');
                $endYear = (int) $request->input('year_end');
                if ($endYear < $startYear) { [$startYear, $endYear] = [$endYear, $startYear]; }
                $start = Carbon::create($startYear, 1, 1)->startOfYear();
                $end = Carbon::create($endYear, 12, 31)->endOfYear();
                $revenueFilterLabel = 'from ' . $startYear . ' to ' . $endYear;
                $revenueBookings = (clone $allBookingsQuery)
                    ->whereBetween('check_in_date', [$start, $end])
                    ->where('status', 'approved')
                    ->get();
            } else {
                $revenueBookings = (clone $allBookingsQuery)
                    ->where('status', 'approved')
                    ->get();
            }

            foreach ($revenueBookings as $booking) {
                $roomPrice = $booking->room ? $booking->room->price_per_night : 0;
                $totalRevenue += $roomPrice;
            }

            // Build per-room revenue breakdown using the same filtered set
            $revenueBreakdown = $revenueBookings
                ->groupBy('room_id')
                ->map(function ($bookings, $roomId) {
                    $room = optional($bookings->first())->room;
                    $roomName = $room ? ($room->room_name ?? ('Room #' . $roomId)) : ('Room #' . $roomId);
                    $bookingsCount = $bookings->count();
                    $revenue = $bookings->reduce(function ($carry, $b) {
                        $price = $b->room ? ($b->room->price_per_night ?? 0) : 0;
                        return $carry + $price;
                    }, 0);
                    return [
                        'room_id' => $roomId,
                        'room_name' => $roomName,
                        'bookings_count' => $bookingsCount,
                        'revenue' => $revenue,
                    ];
                })
                ->values()
                ->sortByDesc('revenue')
                ->values();
        }
    }
    
    $unreadCount = ResortOwnerNotification::where('user_id', Auth::id())
                                                        ->where('is_read', false)
                                                        ->count();
    return view('resort_owner.dashboard', compact('labels', 'data', 'totalBookings', 'activeBookings', 'totalGuests', 'totalRevenue', 'unreadCount', 'revenueFilterLabel', 'revenueBreakdown'));
})->middleware(['auth'])->name('resort.owner.dashboard');

Route::get('/resort_owner/verified', function () {
    if (Auth::user()->role !== 'resort_owner') {
        abort(403, 'Unauthorized');
    }
    $unreadCount = ResortOwnerNotification::where('user_id', Auth::id())
                                            ->where('is_read', false)
                                            ->count();
    return view('resort_owner.verified', compact('unreadCount'));
})->middleware(['auth'])->name('resort.owner.verified');

// Resort Owner Permit Upload Route
            Route::post('/resort_owner/upload-permits', function (Request $request) {
                if (Auth::user()->role !== 'resort_owner') {
                    abort(403, 'Unauthorized');
                }
                
                $request->validate([
                    'bir_permit' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'dti_permit' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'business_permit' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    'owner_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                    'tourism_registration' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                ]);
                
                $user = Auth::user();
                
                $lastUploadedLabel = null;

                if ($request->hasFile('bir_permit')) {
                    $file = $request->file('bir_permit');
                    $filename = 'bir_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/permits/bir'), $filename);
                    $user->bir_permit_path = 'images/permits/bir/' . $filename;
                    // Resubmitting BIR resets its approval and resubmit flag
                    $user->bir_approved = false;
                    $user->bir_resubmitted = false;
                    $lastUploadedLabel = 'BIR Permit';
                }
                
                if ($request->hasFile('dti_permit')) {
                    $file = $request->file('dti_permit');
                    $filename = 'dti_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/permits/dti'), $filename);
                    $user->dti_permit_path = 'images/permits/dti/' . $filename;
                    // Resubmitting DTI resets its approval and resubmit flag
                    $user->dti_approved = false;
                    $user->dti_resubmitted = false;
                    $lastUploadedLabel = 'DTI Permit';
                }
                
                if ($request->hasFile('business_permit')) {
                    $file = $request->file('business_permit');
                    $filename = 'business_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/permits/business'), $filename);
                    $user->business_permit_path = 'images/permits/business/' . $filename;
                    // Resubmitting Business Permit resets its approval and resubmit flag
                    $user->business_permit_approved = false;
                    $user->business_permit_resubmitted = false;
                    $lastUploadedLabel = 'Business Permit';
                }
                
                if ($request->hasFile('owner_image') && $user->role !== 'admin') {
                    $file = $request->file('owner_image');
                    $filename = 'owner_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/permits/owner_images'), $filename);
                    $user->owner_image_path = 'images/permits/owner_images/' . $filename;
                    // Owner images are auto-approved; no admin approval needed
                    $user->owner_pic_approved = true;
                    $lastUploadedLabel = 'Owner Image';
                }
                
                if ($request->hasFile('tourism_registration')) {
                    $file = $request->file('tourism_registration');
                    $filename = 'tourism_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/permits/tourism'), $filename);
                    $user->tourism_registration_path = 'images/permits/tourism/' . $filename;
                    // Resubmitting Tourism Registration resets its approval and resubmit flag
                    $user->tourism_registration_approved = false;
                    $user->tourism_registration_resubmitted = false;
                    $lastUploadedLabel = 'Tourism Registration';
                }
                
                $user->save();

                if ($lastUploadedLabel) {
                    ResortOwnerNotification::create([
                        'user_id' => $user->id,
                        'booking_id' => null,
                        'message' => 'We received your ' . $lastUploadedLabel . '. Please wait for approval.',
                        'type' => 'permit_resubmit_waiting',
                        'is_read' => false,
                    ]);
                }
                
                return redirect()->route('resort.owner.verified');
            })->middleware(['auth'])->name('resort.owner.upload-permits');

// Resort Owner Notification Page
Route::get('/resort_owner/notification', [BookingController::class, 'showNotifications'])
    ->middleware(['auth'])
    ->name('resort.owner.notification');

// NEW: Resort Owner Booking Actions
Route::put('/resort_owner/bookings/{booking}/confirm', [BookingController::class, 'confirmBooking'])
    ->middleware(['auth'])
    ->name('resort.owner.bookings.confirm');

Route::put('/resort_owner/bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])
    ->middleware(['auth'])
    ->name('resort.owner.bookings.reject');

Route::put('/resort_owner/notifications/{notification}/mark-as-read', [BookingController::class, 'markAsRead'])
    ->middleware(['auth'])
    ->name('resort.owner.notifications.markAsRead');

// NEW: Route for marking all Resort Owner Notifications as Read
Route::put('/resort_owner/notifications/mark-all-as-read', [BookingController::class, 'markAllResortOwnerNotificationsAsRead'])
    ->middleware(['auth'])
    ->name('resort.owner.notifications.markAllAsRead');

// NEW: Route for deleting Resort Owner Notifications
Route::delete('/resort_owner/notifications/{notification}', [BookingController::class, 'destroyResortOwnerNotification'])
    ->middleware(['auth'])
    ->name('resort_owner.notifications.destroy');


Route::get('/resort_owner/documentation', [\App\Http\Controllers\ResortOwner\DocumentationController::class, 'index'])
    ->middleware(['auth'])
    ->name('resort.owner.documentation');

Route::get('/resort_owner/documentation/export', [\App\Http\Controllers\ResortOwner\DocumentationController::class, 'export'])
    ->middleware(['auth'])
    ->name('resort.owner.documentation.export');

Route::get('/resort_owner/documentation/export-pdf', [\App\Http\Controllers\ResortOwner\DocumentationController::class, 'exportPdf'])
    ->middleware(['auth'])
    ->name('resort.owner.documentation.export_pdf');


// Boat Owner Routes
Route::middleware(['auth'])->group(function () {
    // Boat Information page for owner
    Route::get('/boat_owner/boat', [BoatController::class, 'index'])
        ->name('boat')
        ->middleware('can:access-boat-features');

    // Add Boat form
    Route::get('/add-boat', [BoatController::class, 'create'])->name('boat.owner.add');
    // Store new boat
    Route::post('/boats', [BoatController::class, 'store'])->name('boats.store');

    // Edit Boat form
    Route::get('/boats/{boat}/edit', [BoatController::class, 'edit'])->name('boat.edit');
    // Update existing boat
    Route::put('/boats/{boat}', [BoatController::class, 'update'])->name('boat.update');

    // Delete boat
    Route::delete('/boats/{boat}', [BoatController::class, 'destroy'])->name('boat.destroy');

    // (Removed boat owner rehab route)

    // Route for Boat Owner updating boat status (open/rehab/closed)
    Route::put('/boats/{boat}/status', [BoatController::class, 'updateStatus'])->name('boat.owner.update_status');

    // Boat Owner Dashboard
    Route::get('/boat_owner/dashboard', function (Request $request) {
        // Ensure the logged-in user is a boat_owner
        if (Auth::user()->role !== 'boat_owner') {
            abort(403, 'Unauthorized');
        }

        $userId = Auth::id();
        
        // Get all boats owned by this boat owner
        $userBoats = Auth::user()->boats;
        $boatIds = $userBoats->pluck('id')->toArray();
        
        // Get all bookings assigned to this boat owner's boats
        $allBookings = \App\Models\Booking::whereIn('assigned_boat_id', $boatIds)
            ->where('status', '!=', 'rejected')
            ->with(['assignedBoat', 'room'])
            ->get();

        // Calculate overall statistics
        $totalBookings = $allBookings->count();
        $activeBookings = $allBookings->whereIn('status', ['approved', 'pending'])->count();
        $totalGuests = $allBookings->sum('number_of_guests');
        
        // Calculate total revenue from boat services only (not room bookings) with optional filters
        $totalRevenue = 0;
        $revenueFilterLabel = null;
        $filterType = $request->input('filter_type'); // 'day' | 'month' | 'month_range' | 'date_range' | 'year' | 'year_range'
        if ($filterType === 'day' && $request->filled('date')) {
            $date = Carbon::parse($request->input('date'))->toDateString();
            $revenueFilterLabel = 'for ' . Carbon::parse($date)->format('F d, Y');
            $revenueBookings = $allBookings->where('status', 'approved')->filter(function ($b) use ($date) {
                return Carbon::parse($b->check_in_date)->toDateString() === $date;
            });
        } elseif ($filterType === 'date_range' && $request->filled('date_start') && $request->filled('date_end')) {
            $start = Carbon::parse($request->input('date_start'))->startOfDay();
            $end = Carbon::parse($request->input('date_end'))->endOfDay();
            if ($end->lessThan($start)) { [$start, $end] = [$end, $start]; }
            $revenueFilterLabel = 'from ' . $start->format('F d, Y') . ' to ' . $end->format('F d, Y');
            $revenueBookings = $allBookings->where('status', 'approved')->filter(function ($b) use ($start, $end) {
                $d = Carbon::parse($b->check_in_date);
                return $d->betweenIncluded($start, $end);
            });
        } elseif ($filterType === 'month' && $request->filled('month')) {
            $monthInput = $request->input('month'); // YYYY-MM
            $monthCarbon = Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth();
            $revenueFilterLabel = 'for ' . $monthCarbon->format('F Y');
            $revenueBookings = $allBookings->where('status', 'approved')->filter(function ($b) use ($monthCarbon) {
                $d = Carbon::parse($b->check_in_date);
                return $d->year === $monthCarbon->year && $d->month === $monthCarbon->month;
            });
        } elseif ($filterType === 'month_range' && $request->filled('month_start') && $request->filled('month_end')) {
            $start = Carbon::createFromFormat('Y-m', $request->input('month_start'))->startOfMonth();
            $end = Carbon::createFromFormat('Y-m', $request->input('month_end'))->endOfMonth();
            if ($end->lessThan($start)) { [$start, $end] = [$end, $start]; }
            $revenueFilterLabel = 'from ' . $start->format('F Y') . ' to ' . $end->format('F Y');
            $revenueBookings = $allBookings->where('status', 'approved')->filter(function ($b) use ($start, $end) {
                $d = Carbon::parse($b->check_in_date);
                return $d->betweenIncluded($start, $end);
            });
        } elseif ($filterType === 'year' && $request->filled('year')) {
            $year = (int) $request->input('year');
            $revenueFilterLabel = 'for ' . $year;
            $revenueBookings = $allBookings->where('status', 'approved')->filter(function ($b) use ($year) {
                return Carbon::parse($b->check_in_date)->year === $year;
            });
        } elseif ($filterType === 'year_range' && $request->filled('year_start') && $request->filled('year_end')) {
            $startYear = (int) $request->input('year_start');
            $endYear = (int) $request->input('year_end');
            if ($endYear < $startYear) { [$startYear, $endYear] = [$endYear, $startYear]; }
            $revenueFilterLabel = 'from ' . $startYear . ' to ' . $endYear;
            $revenueBookings = $allBookings->where('status', 'approved')->filter(function ($b) use ($startYear, $endYear) {
                $y = Carbon::parse($b->check_in_date)->year;
                return $y >= $startYear && $y <= $endYear;
            });
        } else {
            $revenueBookings = $allBookings->where('status', 'approved');
        }

        foreach ($revenueBookings as $booking) {
            $boatPrice = 0;
            
            if ($booking->assignedBoat) {
                $boatPrice = $booking->assignedBoat->boat_prices ?? 0;
            } elseif ($booking->boat_price) {
                $boatPrice = $booking->boat_price;
            }
            
            $totalRevenue += $boatPrice;
        }

        // Prepare data for bar chart - boat usage statistics
        $boatLabels = [];
        $boatUsageData = [];
        $boatRevenueData = [];

        foreach ($userBoats as $boat) {
            $boatBookings = $allBookings->where('assigned_boat_id', $boat->id);
            
            $boatLabels[] = $boat->boat_name;
            $boatUsageData[] = $boatBookings->count();
            
            // Calculate revenue for this boat from boat services only
            $boatRevenue = 0;
            $approvedBoatBookings = $boatBookings->where('status', 'approved');
            foreach ($approvedBoatBookings as $booking) {
                $boatPrice = 0;
                
                if ($booking->assignedBoat) {
                    $boatPrice = $booking->assignedBoat->boat_prices ?? 0;
                } elseif ($booking->boat_price) {
                    $boatPrice = $booking->boat_price;
                }
                
                $boatRevenue += $boatPrice;
            }
            $boatRevenueData[] = $boatRevenue;
        }

        // Build per-room revenue breakdown like resort_owner
        $revenueBreakdown = $revenueBookings
            ->groupBy('room_id')
            ->map(function ($bookings, $roomId) {
                $room = optional($bookings->first())->room;
                $roomName = $room ? ($room->room_name ?? ('Room #' . $roomId)) : ('Room #' . $roomId);
                $bookingsCount = $bookings->count();
                $revenue = $bookings->reduce(function ($carry, $b) {
                    $boatPrice = 0;
                    if ($b->assignedBoat) {
                        $boatPrice = $b->assignedBoat->boat_prices ?? 0;
                    } elseif ($b->boat_price) {
                        $boatPrice = $b->boat_price;
                    }
                    return $carry + $boatPrice;
                }, 0);
                return [
                    'room_id' => $roomId,
                    'room_name' => $roomName,
                    'bookings_count' => $bookingsCount,
                    'revenue' => $revenue,
                ];
            })
            ->values()
            ->sortByDesc('revenue')
            ->values();

        // Get unread notifications count
        $unreadCount = \App\Models\BoatOwnerNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return view('boat_owner.dashboard', compact(
            'totalBookings', 
            'activeBookings', 
            'totalGuests', 
            'totalRevenue',
            'boatLabels', 
            'boatUsageData', 
            'boatRevenueData', 
            'unreadCount',
            'revenueFilterLabel',
            'revenueBreakdown'
        ));
    })->middleware(['auth', \App\Http\Middleware\AuthenticateWithPhone::class])->name('boat.owner.dashboard');

    // Boat Owner Verified Page (if role-based verified status is used)
    Route::get('/boat_owner/verified', function () {
        if (Auth::user()->role !== 'boat_owner') {
            abort(403, 'Unauthorized');
        }
        $unreadCount = BoatOwnerNotification::where('user_id', Auth::id())
                                              ->where('is_read', false)
                                              ->count();
        return view('boat_owner.verified', compact('unreadCount'));
    })->name('boat.owner.verified');

    // Boat Owner Permit Upload Route
    Route::post('/boat_owner/upload-permits', function (Request $request) {
        if (Auth::user()->role !== 'boat_owner') {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'bir_permit' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dti_permit' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'business_permit' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'owner_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'lgu_resolution' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'marina_cpc' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'boat_association' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        $user = Auth::user();
        
        $lastUploadedLabel = null;

        if ($request->hasFile('bir_permit')) {
            $file = $request->file('bir_permit');
            $filename = 'bir_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/bir'), $filename);
            $user->bir_permit_path = 'images/permits/bir/' . $filename;
            // Resubmitting BIR resets its approval and resubmit flag
            $user->bir_approved = false;
            $user->bir_resubmitted = false;
            $lastUploadedLabel = 'BIR Permit';
        }
        
        if ($request->hasFile('dti_permit')) {
            $file = $request->file('dti_permit');
            $filename = 'dti_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/dti'), $filename);
            $user->dti_permit_path = 'images/permits/dti/' . $filename;
            // Resubmitting DTI resets its approval and resubmit flag
            $user->dti_approved = false;
            $user->dti_resubmitted = false;
            $lastUploadedLabel = 'DTI Permit';
        }
        
        if ($request->hasFile('business_permit')) {
            $file = $request->file('business_permit');
            $filename = 'business_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/business'), $filename);
            $user->business_permit_path = 'images/permits/business/' . $filename;
            // Resubmitting Business Permit resets its approval and resubmit flag
            $user->business_permit_approved = false;
            $user->business_permit_resubmitted = false;
            $lastUploadedLabel = 'Business Permit';
        }
        
        if ($request->hasFile('owner_image') && $user->role !== 'admin') {
            $file = $request->file('owner_image');
            $filename = 'owner_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/owner_images'), $filename);
            $user->owner_image_path = 'images/permits/owner_images/' . $filename;
            // Owner images are auto-approved; no admin approval needed
            $user->owner_pic_approved = true;
            $lastUploadedLabel = 'Owner Image';
        }
        
        if ($request->hasFile('lgu_resolution')) {
            $file = $request->file('lgu_resolution');
            $filename = 'lgu_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/lgu'), $filename);
            $user->lgu_resolution_path = 'images/permits/lgu/' . $filename;
            // Resubmitting LGU Resolution resets its approval and resubmit flag
            $user->lgu_resolution_approved = false;
            $user->lgu_resolution_resubmitted = false;
            $lastUploadedLabel = 'LGU Resolution';
        }
        
        if ($request->hasFile('marina_cpc')) {
            $file = $request->file('marina_cpc');
            $filename = 'marina_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/marina'), $filename);
            $user->marina_cpc_path = 'images/permits/marina/' . $filename;
            // Resubmitting Marina CPC resets its approval and resubmit flag
            $user->marina_cpc_approved = false;
            $user->marina_cpc_resubmitted = false;
            $lastUploadedLabel = 'Marina CPC';
        }
        
        if ($request->hasFile('boat_association')) {
            $file = $request->file('boat_association');
            $filename = 'association_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/permits/boat_association'), $filename);
            $user->boat_association_path = 'images/permits/boat_association/' . $filename;
            // Resubmitting Boat Association resets its approval and resubmit flag
            $user->boat_association_approved = false;
            $user->boat_association_resubmitted = false;
            $lastUploadedLabel = 'Boat Association Membership';
        }
        
        $user->save();

        if ($lastUploadedLabel) {
            BoatOwnerNotification::create([
                'user_id' => $user->id,
                'booking_id' => null,
                'message' => 'We received your ' . $lastUploadedLabel . '. Please wait for approval.',
                'type' => 'permit_resubmit_waiting',
                'is_read' => false,
            ]);
        }
        
        return redirect()->route('boat.owner.verified');
    })->name('boat.owner.upload-permits');

    // Boat Owner Notification Page
    Route::get('/boat_owner/notification', [NotificationController::class, 'showBoatOwnerNotifications'])
        ->name('boat.owner.notification');

    // NEW: Boat Owner Mark Notification as Read
    Route::put('/boat_owner/notifications/{notification}/mark-as-read', [NotificationController::class, 'markBoatOwnerNotificationAsRead'])
        ->name('boat.owner.notifications.markAsRead');

    // NEW: Boat Owner Mark All Notifications as Read
    Route::put('/boat_owner/notifications/mark-all-as-read', [NotificationController::class, 'markAllBoatOwnerNotificationsAsRead'])
        ->name('boat.owner.notifications.markAllAsRead');

    // NEW: Route for deleting Boat Owner Notifications - CORRECTED CONTROLLER
    Route::delete('/boat_owner/notifications/{notification}', [NotificationController::class, 'destroyBoatOwnerNotification'])
        ->name('boat.owner.notifications.destroy');

    // Boat Owner Documentation Page
    // Removed Boat Owner Documentation route
});


// Redirect users to their correct dashboard based on their role
Route::middleware(['auth', \App\Http\Middleware\AuthenticateWithPhone::class])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin'),
            'resort_owner' => redirect()->route('resort.owner.dashboard'), // Changed from 'resort' to 'resort.owner.dashboard'
            'boat_owner' => redirect()->route('boat.owner.dashboard'),     // Changed from 'boat' to 'boat.owner.dashboard'
            'tourist' => redirect()->route('tourist.tourist'),
            default => abort(403, 'Unauthorized'),
        };
    })->name('dashboard');
});

// Admin filtered users
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users/resorts', [\App\Http\Controllers\AdminUserController::class, 'resortUsers'])->name('admin.users.resorts');
    Route::get('/admin/users/boats', [\App\Http\Controllers\AdminUserController::class, 'boatUsers'])->name('admin.users.boats');
    Route::get('/admin/users/tourists', [\App\Http\Controllers\AdminUserController::class, 'touristUsers'])->name('admin.users.tourists');
});


// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});


// Tourist Pages

// NEW: Tourist Reminders Page (intermediary page, loads a static view)
Route::get('/tourist/reminders', [TouristController::class, 'showReminders'])
    ->middleware(['auth'])
    ->name('tourist.reminders');


// Route for the fill-up form, passing the room ID
Route::get('/tourist/fillup/{room}', [BookingController::class, 'showFillupForm'])
    ->middleware(['auth'])
    ->name('tourist.fillup');

// Route for the second step of the fill-up form
Route::get('/tourist/fillup2', [BookingController::class, 'showFillupForm2'])
    ->middleware(['auth'])
    ->name('tourist.fillup2');

// Route for handling post-login redirect for booking
Route::get('/tourist/handle-post-login-booking', [BookingController::class, 'handlePostLoginBooking'])
    ->middleware(['auth'])
    ->name('tourist.handle-post-login-booking');


// 'tourist.list' should continue to use ExploreController@index for consistency
Route::get('/tourist/list', [ExploreController::class, 'index'])
    ->middleware(['auth'])
    ->name('tourist.list');

// (Removed tourist spot route)


// This route previously returned a static view without data.
// Kukunin nito ngayon ang bookings at notifications sa BookingController@myBookings
Route::get('/tourist/visit', [BookingController::class, 'myBookings'])
    ->middleware(['auth'])
    ->name('tourist.visit');

Route::get('/tourist/notifications', function () {
    return view('tourist.notifications');
})->middleware(['auth'])->name('tourist.notifications');


// These static /tourist/booknow/* routes are problematic for dynamic data.
Route::get('/tourist/booknow/kuyaboy1', function () {
    return view('tourist.booknow.kuyaboy1');
})->name('tourist.booknow.kuyaboy1');

Route::get('/tourist/booknow/arcadia1', function () {
    return view('tourist.booknow.arcadia1');
})->name('tourist.booknow.arcadia1');

Route::get('/tourist/booknow/chariesplace1', function () {
    return view('tourist.booknow.chariesplace1');
})->name('tourist.booknow.chariesplace1');

Route::get('/tourist/booknow/oceanbreeze1', function () {
    return view('tourist.booknow.oceanbreeze1');
})->name('tourist.booknow.oceanbreeze1');


// --- NEW/MODIFIED: Booking & Notification Routes for Tourist ---
Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware(['auth'])
    ->name('bookings.store');

// Route for checking room availability
Route::post('/check-room-availability', [BookingController::class, 'checkAvailability'])
    ->middleware(['auth'])
    ->name('bookings.check-availability');

// Route for specific booking detail
Route::get('/bookings/{booking}', [BookingController::class, 'show'])
    ->middleware(['auth'])
    ->name('bookings.show');

Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
    ->middleware(['auth'])
    ->name('bookings.cancel');

// NEW: Route to mark a booking as completed (accessible by Resort Owner or Admin)
Route::put('/bookings/{booking}/complete', [BookingController::class, 'completeBooking'])
    ->middleware(['auth'])
    ->name('bookings.complete');

// Route to mark tourist notifications as read - CORRECTED CONTROLLER
Route::put('/tourist/notifications/{notification}/mark-as-read', [NotificationController::class, 'markTouristNotificationAsRead'])
    ->middleware(['auth'])
    ->name('tourist.notifications.markAsRead');

// NEW: Route for marking all Tourist Notifications as Read
Route::put('/tourist/notifications/mark-all-as-read', [NotificationController::class, 'markAllTouristNotificationsAsRead'])
    ->middleware(['auth'])
    ->name('tourist.notifications.markAllAsRead');

// NEW: Route for deleting Tourist Notifications - CORRECTED CONTROLLER
Route::delete('/tourist/notifications/{notification}', [NotificationController::class, 'destroyTouristNotification'])
    ->middleware(['auth'])
    ->name('tourist.notifications.destroy');

// NEW: Route for AJAX loading of Tourist Notifications
Route::get('/tourist/notifications/ajax', [NotificationController::class, 'getTouristNotificationsAjax'])
    ->middleware(['auth'])
    ->name('tourist.notifications.ajax');

// --- NEW TOURIST BOOKING EDIT/DELETE ROUTES ---
// Removed 'role:tourist' middleware as per your existing authorization logic in controllers
Route::get('/tourist/bookings/{booking}/edit', [BookingController::class, 'edit'])
    ->middleware(['auth'])
    ->name('tourist.bookings.edit');

Route::put('/tourist/bookings/{booking}', [BookingController::class, 'update'])
    ->middleware(['auth'])
    ->name('tourist.bookings.update');

Route::delete('/tourist/bookings/{booking}/delete', [BookingController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('tourist.bookings.destroy');
// --- END NEW TOURIST BOOKING EDIT/DELETE ROUTES ---


// =====================================================================================================
// Explore Routes (open to all users)
// =====================================================================================================

Route::get('/explore/exploring', [ExploreController::class, 'index'])
    ->name('explore.exploring');

Route::get('/explore/{resort}', [ExploreController::class, 'show'])
    ->name('explore.show');


// Admin Routes (Grouped under 'admin' prefix with authentication and role check)
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        // Updated: Pass totalForeigners and totalFilipinos data to the view
        $totalForeigners = User::whereRaw('LOWER(nationality) != ?', ['filipino'])->count();
        $totalFilipinos = User::whereRaw('LOWER(nationality) = ?', ['filipino'])->count();
        
        // Add tour type statistics for bar graph
        $dayTourCount = \App\Models\Booking::where('tour_type', 'day_tour')->where('status', '!=', 'rejected')->count();
        $overnightCount = \App\Models\Booking::where('tour_type', 'overnight')->where('status', '!=', 'rejected')->count();
        
        
        return view('admin.admin', compact(
            'totalForeigners', 
            'totalFilipinos', 
            'dayTourCount', 
            'overnightCount'
        ));
    })->name('admin.dashboard');

    // Resort Management
    Route::get('/resort', [AdminResortController::class, 'index'])->name('admin.resort');
    Route::get('/resort/{resort}', [AdminResortController::class, 'show'])->name('admin.resort.show');
    Route::patch('/resort/{resort}/approve', [AdminResortController::class, 'approveResort'])->name('admin.resort.approve');
    Route::patch('/resort/{resort}/reject', [AdminResortController::class, 'rejectResort'])->name('admin.resort.reject');

    // Room Approval/Rejection (assuming AdminResortController also handles rooms)
    Route::patch('/room/{room}/approve', [AdminResortController::class, 'approveRoom'])->name('admin.room.approve');
    Route::patch('/room/{room}/reject', [AdminResortController::class, 'rejectRoom'])->name('admin.room.reject');

    // Boat Management (All boat-related admin actions)
    Route::get('/boats', [AdminBoatController::class, 'index'])->name('admin.boat');
    Route::get('/boats/{boat}', [AdminBoatController::class, 'show'])->name('admin.boat.show');
    Route::post('/boats/{boat}/approve', [AdminBoatController::class, 'approve'])->name('admin.boat.approve');
    Route::post('/boats/{boat}/reject', [AdminBoatController::class, 'reject'])->name('admin.boat.reject');
    Route::delete('/boats/{boat}/delete', [AdminBoatController::class, 'destroy'])->name('admin.boat.delete');

    // NEW: Route for Admin updating boat status (open/rehab/closed)
    Route::put('/boats/{boat}/admin-status', [AdminBoatController::class, 'updateStatus'])->name('admin.boat.update_status');


    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/users/{id}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{id}/approve-permit', [AdminUserController::class, 'approvePermit'])->name('admin.users.approve_permit');
    Route::post('/users/{id}/request-resubmit-permit', [AdminUserController::class, 'requestPermitResubmit'])->name('admin.users.request_resubmit_permit');
    // (Resubmit removed)

    // Admin Documentation Page
    Route::get('/documentation', [\App\Http\Controllers\Admin\AdminDocumentationController::class, 'index'])->name('admin.documentation');
    Route::get('/documentation/export', [\App\Http\Controllers\Admin\AdminDocumentationController::class, 'export'])->name('admin.documentation.export');
    Route::get('/documentation/export-pdf', [\App\Http\Controllers\Admin\AdminDocumentationController::class, 'exportPdf'])->name('admin.documentation.export_pdf');


    // Routes for Foreigners and Filipinos lists
    Route::get('/foreign', [AdminUserController::class, 'showForeigners'])->name('admin.foreign');
    Route::get('/total-filipino', [AdminUserController::class, 'showFilipinos'])->name('admin.total-filipino');

    // Other admin-specific pages
    // (Removed admin.pending_resort and admin.customers routes)
});


require __DIR__ . '/auth.php';

// Manual trigger for testing booking status updates (remove in production)
Route::get('/test/update-booking-statuses', function() {
    \Illuminate\Support\Facades\Artisan::call('bookings:update-statuses');
    return response()->json(['message' => 'Booking statuses updated successfully']);
})->middleware(['auth'])->name('test.update-booking-statuses');