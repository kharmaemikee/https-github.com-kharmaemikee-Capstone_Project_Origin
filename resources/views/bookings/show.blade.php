{{-- resources/views/bookings/show.blade.php --}}

<x-app-layout>
    <head>
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- Optional: Add custom CSS for badges if not in app.blade.php or other shared stylesheet --}}
        <style>
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
            .status-cancelled {
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
                color: #007bff;
                background-color: #e0f0ff;
                border-color: #007bff;
            }

             .nav-link.text-white:hover,
             .nav-link.text-white:focus,
             .nav-link.text-white.active {
                 background-color: rgb(6, 58, 170) !important;
             }
        </style>
    </head>

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                TOURIST
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
                    TOURIST
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
                <h2 class="fw-bold mb-4">Booking Details</h2>

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

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Booking Reference: #{{ $booking->id }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Booking Information:</h6>
                                <p class="mb-1"><strong>Status:</strong>
                                    @if ($booking->status === 'pending')
                                        <span class="status-badge status-pending">Awaiting Approval</span>
                                    @elseif ($booking->status === 'approved')
                                        <span class="status-badge status-approved">Approved!</span>
                                    @elseif ($booking->status === 'rejected')
                                        <span class="status-badge status-rejected">Rejected</span>
                                    @elseif ($booking->status === 'cancelled')
                                        <span class="status-badge status-rejected">Cancelled</span>
                                    @elseif ($booking->status === 'completed')
                                        <span class="status-badge status-completed">Completed</span>
                                    @else
                                        <span class="status-badge status-pending">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Booked On:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('F d, Y h:i A') }}</p>
                                <p class="mb-1"><strong>Tour Type:</strong> {{ ucfirst(str_replace('_', ' ', $booking->tour_type)) }}</p>
                                <p class="mb-1"><strong>Check-in Date:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('F d, Y') }}</p>
                                @if ($booking->tour_type === 'overnight' && $booking->check_out_date)
                                    <p class="mb-1"><strong>Check-out Date:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('F d, Y') }}</p>
                                @endif
                                <p class="mb-1"><strong>Number of Guests:</strong> {{ $booking->number_of_guests }}</p>
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
                                <p class="mb-1"><strong>Room Price:</strong> &#x20B1;{{ number_format($roomPrice, 2) }}</p>
                                <p class="mb-1"><strong>Boat Price:</strong> &#x20B1;{{ number_format($boatPrice, 2) }}</p>
                                <p class="mb-1"><strong>Total Price:</strong> &#x20B1;{{ number_format($totalPrice, 2) }}</p>

                                @if ($booking->tour_type === 'day_tour')
                                    <h6 class="mt-3 fw-bold">Day Tour Specifics:</h6>
                                    <p class="mb-1"><strong>Departure Time:</strong> {{ \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('h:i A') }}</p>
                                    <p class="mb-1"><strong>Pickup Time:</strong> {{ \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('h:i A') }}</p>
                                @elseif ($booking->tour_type === 'overnight')
                                    <h6 class="mt-3 fw-bold">Overnight Specifics:</h6>
                                    <p class="mb-1"><strong>Pickup Date/Time:</strong> {{ \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('F d, Y h:i A') }}</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h6 class="fw-bold">Tourist Information:</h6>
                                <p class="mb-1"><strong>Name:</strong> {{ $booking->guest_name }}</p>
                                <p class="mb-1"><strong>Age:</strong> {{ $booking->guest_age }}</p>
                                <p class="mb-1"><strong>Gender:</strong> {{ $booking->guest_gender }}</p>
                                <p class="mb-1"><strong>Address:</strong> {{ $booking->guest_address }}</p>
                                <p class="mb-1"><strong>Nationality:</strong> {{ $booking->guest_nationality }}</p>
                                <p class="mb-1"><strong>Contact Number:</strong> {{ $booking->phone_number }}</p>
                                @if ($booking->num_senior_citizens > 0)
                                    <p class="mb-1"><strong>Senior Citizens:</strong> {{ $booking->num_senior_citizens }}</p>
                                @endif
                                @if ($booking->num_pwds > 0)
                                    <p class="mb-1"><strong>PWDs:</strong> {{ $booking->num_pwds }}</p>
                                @endif

                                @if ($booking->user)
                                    <h6 class="mt-3 fw-bold">Account Information:</h6>
                                    <p class="mb-1"><strong>Booked By User:</strong> {{ $booking->user->name }}</p>
                                    <p class="mb-1"><strong>Contact No.:</strong> {{ $booking->user->phone }}</p>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Resort Information:</h5>
                                @if ($booking->room && $booking->room->resort)
                                    <p class="mb-1"><strong>Resort Name:</strong> {{ $booking->room->resort->resort_name }}</p>
                                    <p class="mb-1"><strong>Location:</strong> {{ $booking->room->resort->location }}</p>
                                    <p class="mb-1"><strong>Contact:</strong> {{ $booking->room->resort->contact_number }}</p>
                                @else
                                    <p class="mb-1 text-muted">Resort information not available.</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Room Information:</h5>
                                @if ($booking->room)
                                    <p class="mb-1"><strong>Room Name:</strong> {{ $booking->room->room_name }}</p>
                                    <p class="mb-1"><strong>Capacity:</strong> {{ $booking->room->capacity }} persons</p>
                                    <p class="mb-1"><strong>Price:</strong> &#x20B1;{{ number_format($booking->room->price_per_night, 2) }}</p>
                                    <p class="mb-1"><strong>Description:</strong> {{ $booking->room->description }}</p>
                                @else
                                    <p class="mb-1 text-muted">Room information not available.</p>
                                @endif
                            </div>
                        </div>

                        @if ($booking->status === 'approved' && ($booking->assignedBoat || $booking->boat_captain_crew))
                            <hr class="my-4">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="fw-bold">Assigned Boat Information:</h6>
                                    @if($booking->assignedBoat)
                                        <p class="mb-1"><strong>Boat Name:</strong> {{ $booking->assignedBoat->boat_name }}</p>
                                        <p class="mb-1"><strong>Boat Number:</strong> {{ $booking->assignedBoat->boat_number }}</p>
                                        <p class="mb-1"><strong>Boat Price:</strong> &#x20B1;{{ number_format($booking->assignedBoat->boat_prices ?? 0, 2) }}</p>
                                        <p class="mb-1"><strong>Capacity:</strong> {{ $booking->assignedBoat->boat_capacities }} persons</p>
                                        
                                        {{-- Captain Information --}}
                                        @if($booking->assignedBoat->captain_name)
                                            <p class="mb-1"><strong>Boat Captain:</strong> {{ $booking->assignedBoat->captain_name }}</p>
                                            <p class="mb-1"><strong>Captain Contact:</strong> {{ $booking->assignedBoat->captain_contact ?? 'N/A' }}</p>
                                        @elseif($booking->assignedBoat->user)
                                            <p class="mb-1"><strong>Boat Owner:</strong> {{ $booking->assignedBoat->user->name }}</p>
                                            <p class="mb-1"><strong>Owner Contact:</strong> {{ $booking->assignedBoat->user->phone ?? 'N/A' }}</p>
                                        @else
                                            <p class="mb-1 text-muted">Captain details not available.</p>
                                        @endif
                                    @elseif($booking->boat_captain_crew && $booking->boat_captain_crew !== 'N/A')
                                        <p class="mb-1"><strong>Boat Name:</strong> {{ $booking->assigned_boat ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Boat Price:</strong> &#x20B1;{{ number_format($booking->boat_price ?? 0, 2) }}</p>
                                        <p class="mb-1"><strong>Boat Captain:</strong> {{ $booking->boat_captain_crew }}</p>
                                        <p class="mb-1"><strong>Captain Contact:</strong> {{ $booking->boat_contact_number ?? 'N/A' }}</p>
                                    @else
                                        <p class="mb-1 text-muted">Boat information not available.</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="{{ route('tourist.visit') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to My Visits
                        </a>

                        {{-- Conditional Buttons for Bookings --}}
                        @if ($booking->status === 'pending')
                            {{-- Cancel Button (only if pending) --}}
                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning text-dark">
                                    Cancel Booking <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                        @endif

                        {{-- Delete Button (for approved, rejected, cancelled, or completed bookings) - Triggers Modal --}}
                        @if (in_array($booking->status, ['approved', 'rejected', 'cancelled', 'completed']))
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookingConfirmationModal" data-booking-id="{{ $booking->id }}">
                                Delete Booking <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Delete Booking Confirmation Modal (re-used from visit.blade.php) --}}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }
                hideOffcanvasOnDesktop();
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // JavaScript for Delete Booking Confirmation Modal
            var deleteBookingConfirmationModal = document.getElementById('deleteBookingConfirmationModal');
            if (deleteBookingConfirmationModal) {
                deleteBookingConfirmationModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var bookingId = button.getAttribute('data-booking-id');
                    var form = document.getElementById('deleteBookingForm');
                    form.action = '/tourist/bookings/' + bookingId; // Adjust this route as per your web.php
                });
            }
        });
    </script>
</x-app-layout>