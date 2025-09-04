<x-app-layout>
    <head>
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    </head>

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Tourist
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                        <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Home
                    </a>
                </li>
                @php
                    $unreadCount = 0;
                    try {
                        if (Auth::check()) {
                            $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
                        }
                    } catch (\Throwable $e) { $unreadCount = 0; }
                @endphp
                <li class="nav-item mt-2">
                    {{-- Active class for the current page --}}
                    <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 active d-flex align-items-center justify-content-start">
                        <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Your Visit
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                {{-- Add other tourist sidebar links here if any --}}
            </ul>
        </div>

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                &#9776;
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Tourist
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Home
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start active">
                            Your Visit
                            @if(($unreadCount ?? 0) > 0)
                                <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- Add other tourist sidebar links here if any --}}
                </ul>
            </div>
        </div>

        {{-- Main Content Area --}}
        <main class="py-4 px-3 flex-grow-1">
            <div class="container">
                <h2 class="fw-bold mb-4">Your Visits & Notifications</h2>

                {{-- Display Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Display Error Messages --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Notifications Section --}}
                <h3 class="mt-4 mb-3">My Notifications</h3>
                @if ($touristNotifications->isEmpty())
                    <div class="alert alert-info">You have no new notifications.</div>
                @else
                    <div class="row">
                        @foreach ($touristNotifications as $notification)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm {{ $notification->is_read ? 'bg-light text-muted' : 'border-primary' }}">
                                    <div class="card-body">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <h5 class="mb-1 card-title fw-bold">{{ $notification->message }}</h5>
                                            <small class="text-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if ($notification->booking)
                                            <p class="mb-1 text-sm">Booking for: {{ $notification->booking->room->room_name ?? 'N/A Room' }} at {{ $notification->booking->name_of_resort }}</p>
                                            <p class="mb-2">Status:
                                                @if ($notification->booking->status === 'approved')
                                                    <span class="status-badge status-approved">Approved!</span>
                                                    {{-- Prioritize stored values when available, fall back to relationship --}}
                                                    @if($notification->booking->assigned_boat && $notification->booking->boat_captain_crew && $notification->booking->boat_captain_crew !== 'N/A')
                                                        {{-- Use stored values (preferred) --}}
                                                        <small class="d-block mt-1">Assigned Boat: <strong>{{ $notification->booking->assigned_boat }}</strong></small>
                                                        <small class="d-block">Boat Captain: <strong>{{ $notification->booking->boat_captain_crew }}</strong></small>
                                                        <small class="d-block">Captain Contact: <strong>{{ $notification->booking->boat_contact_number ?? 'N/A' }}</strong></small>
                                                    @elseif($notification->booking->assignedBoat)
                                                        {{-- Fall back to boat fields, prioritize captain_name and captain_contact --}}
                                                        <small class="d-block mt-1">Assigned Boat: <strong>{{ $notification->booking->assignedBoat->boat_name }} ({{ $notification->booking->assignedBoat->boat_number }})</strong></small>
                                                        <small class="d-block">Boat Captain: <strong>{{ $notification->booking->assignedBoat->captain_name ?? 'N/A' }}</strong></small>
                                                        <small class="d-block">Captain Contact: <strong>{{ $notification->booking->assignedBoat->captain_contact ?? $notification->booking->boat_contact_number ?? 'N/A' }}</strong></small>
                                                    @else
                                                        <small class="d-block mt-1">Assigned Boat: <strong>Not assigned yet</strong></small>
                                                        <small class="d-block">Boat Captain: <strong>Not assigned yet</strong></small>
                                                        <small class="d-block">Captain Contact: <strong>Not assigned yet</strong></small>
                                                    @endif
                                                @elseif ($notification->booking->status === 'rejected')
                                                    <span class="status-badge status-rejected">Rejected</span>
                                                @elseif ($notification->booking->status === 'cancelled')
                                                    <span class="status-badge status-rejected">Cancelled</span>
                                                @elseif ($notification->booking->status === 'completed')
                                                    {{-- Notification message for 'completed' status removed as per request --}}
                                                    <span class="status-badge status-completed">Completed</span>
                                                @else
                                                    <span class="status-badge status-pending">{{ ucfirst($notification->booking->status) }}</span>
                                                @endif
                                            </p>
                                        @endif
                                        <div class="d-flex justify-content-end align-items-center mt-3">
                                            {{-- Mark as Read Button --}}
                                            @unless ($notification->is_read)
                                                <form action="{{ route('tourist.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline me-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Mark as Read</button>
                                                </form>
                                            @endunless
                                            {{-- Delete Button for Notification - Triggers Modal --}}
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteNotificationConfirmationModal" data-notification-id="{{ $notification->id }}">
                                                Delete <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination for Notifications --}}
                    @if ($touristNotifications->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $touristNotifications->links('vendor.pagination.tourist') }}
                        </div>
                    @endif
                @endif

                {{-- Bookings Section (assuming $bookings is passed from the controller) --}}
                <h3 class="mt-5 mb-3">My Bookings</h3>
                @if ($bookings->isEmpty())
                    <div class="alert alert-info">You have no current bookings.</div>
                @else
                    <div class="row">
                        @foreach ($bookings as $booking)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-bold">Booking for {{ $booking->room->room_name ?? 'N/A' }}</h5>
                                        <p class="card-text mb-1">Resort: <strong>{{ $booking->name_of_resort }}</strong></p>
                                        <p class="card-text mb-1">Check-in Date: <strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('F d, Y') }}</strong></p>
                                        @if ($booking->tour_type === 'overnight' && $booking->check_out_date)
                                            <p class="card-text mb-1">Check-out Date: <strong>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('F d, Y') }}</strong></p>
                                        @endif
                                        <p class="card-text mb-1">Guests: <strong>{{ $booking->number_of_guests }}</strong></p>

                                        {{-- Boat Owner/Captain Information --}}
                                        <h6 class="mt-3 mb-2 fw-bold">Boat Owner/Captain Information:</h6>
                                        @if($booking->assignedBoat && $booking->assignedBoat->user)
                                            <p class="card-text mb-1"><small>Name: <strong>{{ $booking->assignedBoat->user->name ?? 'N/A' }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Contact: <strong>{{ $booking->assignedBoat->user->phone ?? 'N/A' }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Boat: <strong>{{ $booking->assignedBoat->boat_name ?? 'N/A' }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Boat Price: <strong>₱{{ number_format($booking->assignedBoat->boat_prices ?? 0, 2) }}</strong></small></p>
                                        @elseif($booking->boat_captain_crew && $booking->boat_captain_crew !== 'N/A')
                                            <p class="card-text mb-1"><small>Name: <strong>{{ $booking->boat_captain_crew }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Contact: <strong>{{ $booking->boat_contact_number ?? 'N/A' }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Boat: <strong>{{ $booking->assigned_boat ?? 'N/A' }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Boat Price: <strong>₱{{ number_format($booking->boat_price ?? 0, 2) }}</strong></small></p>
                                        @else
                                            <p class="card-text mb-1"><small>Name: <strong>Not assigned yet</strong></small></p>
                                            <p class="card-text mb-1"><small>Contact: <strong>Not assigned yet</strong></small></p>
                                            <p class="card-text mb-1"><small>Boat: <strong>Not assigned yet</strong></small></p>
                                            <p class="card-text mb-1"><small>Boat Price: <strong>Not assigned yet</strong></small></p>
                                        @endif
                                        @if ($booking->num_senior_citizens > 0)
                                            <p class="card-text mb-1"><small>Senior Citizens: <strong>{{ $booking->num_senior_citizens }}</strong></small></p>
                                        @endif
                                        @if ($booking->num_pwds > 0)
                                            <p class="card-text mb-1"><small>PWDs: <strong>{{ $booking->num_pwds }}</strong></small></p>
                                        @endif

                                        {{-- Tour Type Specific Times --}}
                                        @if ($booking->tour_type === 'day_tour')
                                            <h6 class="mt-3 mb-2 fw-bold">Day Tour Details:</h6>
                                            <p class="card-text mb-1"><small>Departure Time: <strong>{{ \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('h:i A') }}</strong></small></p>
                                            <p class="card-text mb-1"><small>Pickup Time: <strong>{{ \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('h:i A') }}</strong></small></p>
                                        @elseif ($booking->tour_type === 'overnight')
                                            <h6 class="mt-3 mb-2 fw-bold">Overnight Details:</h6>
                                            <p class="card-text mb-1"><small>Pickup Date/Time: <strong>{{ \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('F d, Y h:i A') }}</strong></small></p>
                                        @endif

                                        <p class="card-text mb-2 mt-3">Status:
                                            @if ($booking->display_status === 'pending')
                                                <span class="status-badge status-pending">Awaiting Approval</span>
                                            @elseif ($booking->display_status === 'approved')
                                                <span class="status-badge status-approved">Approved!</span>
                                            @elseif ($booking->display_status === 'rejected')
                                                <span class="status-badge status-rejected">Rejected</span>
                                            @elseif ($booking->display_status === 'cancelled')
                                                <span class="status-badge status-rejected">Cancelled</span>
                                            @elseif ($booking->display_status === 'completed')
                                                <span class="status-badge status-completed">Completed</span>
                                            @endif
                                        </p>
                                        {{-- Link to a detailed booking view --}}
                                        <div class="mt-auto d-flex flex-wrap justify-content-end align-items-center pt-2"> {{-- Pushes the button to the bottom --}}
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary mt-2 me-2">View Details</a>

                                            {{-- Conditional Buttons for Bookings --}}
                                            @if ($booking->display_status === 'pending')
                                                {{-- Cancel Button (only if pending) - Now triggers a modal --}}
                                                <button type="button" class="btn btn-sm btn-warning text-dark mt-2" data-bs-toggle="modal" data-bs-target="#cancelBookingConfirmationModal" data-booking-id="{{ $booking->id }}">
                                                    Cancel <i class="bi bi-x-circle"></i>
                                                </button>
                                            @endif

                                            {{-- Delete Button (for approved, rejected, cancelled, or completed bookings) - Triggers Modal --}}
                                            @if (in_array($booking->display_status, ['approved', 'rejected', 'cancelled', 'completed']))
                                                <button type="button" class="btn btn-sm btn-danger ms-2 mt-2" data-bs-toggle="modal" data-bs-target="#deleteBookingConfirmationModal" data-booking-id="{{ $booking->id }}">
                                                    Delete <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination for Bookings --}}
                    @if ($bookings->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $bookings->links('vendor.pagination.tourist') }}
                        </div>
                    @endif
                @endif
            </div>
        </main>
    </div>

    {{-- Delete Notification Confirmation Modal --}}
    <div class="modal fade" id="deleteNotificationConfirmationModal" tabindex="-1" aria-labelledby="deleteNotificationConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteNotificationConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this notification? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteNotificationForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Booking Confirmation Modal --}}
    <div class="modal fade" id="deleteBookingConfirmationModal" tabindex="-1" aria-labelledby="deleteBookingConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBookingConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this booking record? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteBookingForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- NEW: Cancel Booking Confirmation Modal --}}
    <div class="modal fade" id="cancelBookingConfirmationModal" tabindex="-1" aria-labelledby="cancelBookingConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelBookingConfirmationModalLabel">Confirm Cancellation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel this booking? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <form id="cancelBookingForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT') {{-- Assuming your cancel route uses PUT/PATCH --}}
                        <button type="submit" class="btn btn-warning text-dark">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Custom "BOOK NOW" BUTTON STYLE - if this button style is used elsewhere */
        .btn-book-now {
            background-color: rgb(9, 135, 219);
            border-color: rgb(9, 135, 219);
            color: #fff;
            border-radius: 6px;
            padding: 7px 10px;
            font-weight: bold;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-book-now:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }

        /* NEW: Custom styles for status badges */
        .status-badge {
            display: inline-block;
            padding: 0.3em 0.8em;
            font-size: 0.875em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 0.75rem;
            border: 1px solid transparent;
            text-transform: capitalize;
        }

        .status-approved {
            color: #28a745;
            background-color: #e6ffe9;
            border-color: #28a745;
        }

        .status-rejected,
        .status-cancelled { /* Combined rejected and cancelled for similar styling */
            color: #dc3545;
            background-color: #ffe6e8;
            border-color: #dc3545;
        }

        .status-pending {
            color: #ffc107;
            background-color: #fffde6;
            border-color: #ffc107;
        }

        .status-completed {
            color: #007bff; /* Blue color for completed */
            background-color: #e0f0ff; /* Light blue background */
            border-color: #007bff;
        }
    </style>

    {{-- Custom JavaScript for mobile sidebar behavior and modal handling --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    // Bootstrap's 'md' breakpoint is 768px
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // JavaScript for Delete Notification Confirmation Modal
            var deleteNotificationConfirmationModal = document.getElementById('deleteNotificationConfirmationModal');
            if (deleteNotificationConfirmationModal) {
                deleteNotificationConfirmationModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    var button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    var notificationId = button.getAttribute('data-notification-id');
                    // Update the modal's form action
                    var form = document.getElementById('deleteNotificationForm');
                    form.action = '/tourist/notifications/' + notificationId; // Adjust this route as per your web.php
                });
            }

            // JavaScript for Delete Booking Confirmation Modal
            var deleteBookingConfirmationModal = document.getElementById('deleteBookingConfirmationModal');
            if (deleteBookingConfirmationModal) {
                deleteBookingConfirmationModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    var button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    var bookingId = button.getAttribute('data-booking-id');
                    // Update the modal's form action
                    var form = document.getElementById('deleteBookingForm');
                    form.action = '/tourist/bookings/' + bookingId; // Adjust this route as per your web.php
                });
            }

            // NEW: JavaScript for Cancel Booking Confirmation Modal
            var cancelBookingConfirmationModal = document.getElementById('cancelBookingConfirmationModal');
            if (cancelBookingConfirmationModal) {
                cancelBookingConfirmationModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    var button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    var bookingId = button.getAttribute('data-booking-id');
                    // Update the modal's form action
                    var form = document.getElementById('cancelBookingForm');
                    form.action = '/bookings/' + bookingId + '/cancel'; // Adjust this route as per your web.php (assuming 'bookings.cancel' route)
                });
            }
        });
    </script>
</x-app-layout>