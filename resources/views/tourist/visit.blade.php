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
            
            @php
                $unreadCount = 0;
                try {
                    if (Auth::check()) {
                        $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
                    }
                } catch (\Throwable $e) { $unreadCount = 0; }
            @endphp
            
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
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('tourist.notifications') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                        <i class="fas fa-bell me-2" style="width: 20px; height: 20px;"></i>
                        Notifications
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
                        <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">  
                        Your Visit
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('tourist.notifications') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start">
                            <i class="fas fa-bell me-2"></i>
                            Notifications
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
                <h2 class="fw-bold mb-4">Your Visits</h2>

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
                                        <p class="card-text mb-1">Check-in Date: <strong>
                                            @php
                                                try {
                                                    echo \Carbon\Carbon::parse($booking->check_in_date)->format('F d, Y');
                                                } catch(\Exception $e) {
                                                    echo $booking->check_in_date;
                                                }
                                            @endphp
                                        </strong></p>
                                        @if ($booking->tour_type === 'overnight' && $booking->check_out_date)
                                            <p class="card-text mb-1">Check-out Date: <strong>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($booking->check_out_date)->format('F d, Y');
                                                    } catch(\Exception $e) {
                                                        echo $booking->check_out_date;
                                                    }
                                                @endphp
                                            </strong></p>
                                        @endif
                                        <p class="card-text mb-1">Guests: <strong>{{ $booking->number_of_guests }}</strong></p>
                                        
                                        {{-- Room Price Information --}}
                                        @if($booking->room)
                                            <p class="card-text mb-1">Room Price: <strong>₱{{ number_format($booking->room->price_per_night, 2) }}</strong> per night</p>
                                        @endif

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
                                            <p class="card-text mb-1"><small>Pickup Time: <strong>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('h:i A');
                                                    } catch(\Exception $e) {
                                                        echo $booking->day_tour_time_of_pickup;
                                                    }
                                                @endphp
                                            </strong></small></p>
                                            <p class="card-text mb-1"><small>Departure Time: <strong>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('h:i A');
                                                    } catch(\Exception $e) {
                                                        echo $booking->day_tour_departure_time;
                                                    }
                                                @endphp
                                            </strong></small></p>
                                        @elseif ($booking->tour_type === 'overnight')
                                            <h6 class="mt-3 mb-2 fw-bold">Overnight Details:</h6>
                                            <p class="card-text mb-1"><small>Pickup Date/Time: <strong>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('F d, Y h:i A');
                                                    } catch(\Exception $e) {
                                                        echo $booking->overnight_date_time_of_pickup;
                                                    }
                                                @endphp
                                            </strong></small></p>
                                        @endif

                                        {{-- Total Price Calculation --}}
                                        @php
                                            $roomPrice = $booking->room ? $booking->room->price_per_night : 0;
                                            $boatPrice = 0;
                                            if ($booking->assignedBoat) {
                                                $boatPrice = $booking->assignedBoat->boat_prices ?? 0;
                                            } elseif ($booking->boat_price) {
                                                $boatPrice = $booking->boat_price;
                                            }
                                            $totalPrice = $roomPrice + $boatPrice;
                                        @endphp
                                        
                                        @if($totalPrice > 0)
                                            <div class="mt-3 p-2 bg-light rounded">
                                                <h6 class="mb-2 fw-bold text-primary">💰 Total Cost Breakdown:</h6>
                                                @if($roomPrice > 0)
                                                    <p class="mb-1"><small>Room: <strong>₱{{ number_format($roomPrice, 2) }}</strong></small></p>
                                                @endif
                                                @if($boatPrice > 0)
                                                    <p class="mb-1"><small>Boat: <strong>₱{{ number_format($boatPrice, 2) }}</strong></small></p>
                                                @endif
                                                <hr class="my-1">
                                                <p class="mb-0 fw-bold"><small>Total: <strong>₱{{ number_format($totalPrice, 2) }}</strong></small></p>
                                            </div>
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