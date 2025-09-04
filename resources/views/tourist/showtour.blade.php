<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                {{-- Tourist Icon --}}
                <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Tourist
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                        {{-- Home Icon --}}
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
                    <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                        {{-- Your Visit Icon --}}
                        <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Your Visit
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
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
                        <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Your Visit
                            @if(($unreadCount ?? 0) > 0)
                                <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area (Resort Details and Rooms) --}}
        <main class="py-4 px-3 flex-grow-1">
            <h2 class="mb-2 d-flex align-items-center">
                {{ $resort->resort_name }}
                {{-- Display Resort Status Badge next to resort name, using custom light badges --}}
                @php
                    $resortStatusClass = '';
                    $resortStatusText = ucfirst($resort->status ?? 'Unknown');
                    switch ($resort->status) {
                        case 'open':
                            $resortStatusClass = 'badge-light-success';
                            break;
                        case 'closed':
                            $resortStatusClass = 'badge-light-black';
                            break;
                        case 'maintenance':
                            $resortStatusClass = 'badge-light-warning';
                            break;
                        default:
                            $resortStatusClass = 'badge-light-secondary';
                            break;
                    }
                @endphp
                <span class="badge {{ $resortStatusClass }} ms-3 fs-6 px-3 py-2 rounded-pill">{{ $resortStatusText }}</span>
            </h2>

            {{-- Display Resort-level Maintenance Reason if applicable --}}
            @if (($resort->status ?? '') === 'maintenance' && $resort->rehab_reason)
                <div class="alert alert-warning mt-3" role="alert">
                    <strong>Resort Under Maintenance:</strong> {{ $resort->rehab_reason }}
                </div>
            @elseif (($resort->status ?? '') === 'closed')
                <div class="alert alert-danger mt-3" role="alert">
                    <strong>Resort Closed:</strong> This resort is currently not operating.
                </div>
            @endif

            {{-- Display Contact Number if available --}}
            @if ($resort->contact_number)
                <p class="text-muted mb-1 d-flex align-items-center">
                    <img src="{{ asset('images/phone.png') }}" alt="Phone Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    <strong style="margin-right: 10px;">Contact:</strong> {{ $resort->contact_number }}
                </p>
            @else
                <p class="text-muted mb-1 d-flex align-items-center">
                    <img src="{{ asset('images/phone.png') }}" alt="Phone Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    <strong>Contact:</strong> N/A
                </p>
            @endif

            {{-- Display Facebook Page Link if available and valid URL --}}
            @if ($resort->facebook_page_link)
                <p class="text-muted mb-4 d-flex align-items-center">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    <strong style="margin-right: 10px;">Facebook Page:</strong>
                    <a href="{{ $resort->facebook_page_link }}" target="_blank" rel="noopener noreferrer">
                        {{ $resort->facebook_page_link }}
                    </a>
                </p>
            @else
                <p class="text-muted mb-4 d-flex align-items-center">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    <strong>Facebook Page:</strong> N/A
                </p>
            @endif

            <div class="container py-4">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mb-4">Our Rooms</h2>
                        <hr class="mb-4">
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @forelse ($resort->rooms as $room)
                        <div class="col">
                            {{-- The card itself is no longer the direct modal trigger --}}
                            <div class="card shadow-sm h-100 rounded">
                                {{-- This new div will be the clickable area for the modal --}}
                                <div class="room-card-content-clickable"
                                    data-bs-toggle="modal" data-bs-target="#roomDetailsModal"
                                    data-room-image="{{ asset('storage/' . ($room->image_path ?? 'images/default_room.png')) }}"
                                    data-room-name="{{ $room->room_name }}"
                                    data-room-description="{{ $room->description }}"
                                    data-room-max-guests="{{ $room->max_guests }}"
                                    data-room-price="₱{{ number_format($room->price_per_night, 2) }} / Night"
                                    data-room-status-text="{{ ucfirst($room->status ?? 'Unknown') }}"
                                    data-room-status-class="@php
                                            switch ($room->status) {
                                                case 'open': echo 'badge-light-success'; break;
                                                case 'closed': echo 'badge-light-black'; break;
                                                case 'maintenance': echo 'badge-light-warning'; break;
                                                default: echo 'badge-light-secondary'; break;
                                            }
                                        @endphp
                                    data-room-rehab-reason="{{ (($room->status ?? '') === 'maintenance' && $room->rehab_reason) ? 'Reason: ' . $room->rehab_reason : '' }}"
                                    data-room-admin-status="{{ $room->admin_status ?? '' }}"
                                    data-resort-status="{{ $resort->status ?? '' }}"
                                    data-room-id="{{ $room->id }}" {{-- Pass room ID to the modal trigger --}}
                                    style="cursor: pointer;"> {{-- Add cursor pointer for visual cue --}}

                                    <img src="{{ asset('storage/' . ($room->image_path ?? 'images/default_room.png')) }}"
                                        class="card-img-top rounded-top"
                                        alt="{{ $room->room_name }}"
                                        style="height: 150px; object-fit: cover;"
                                        onerror="handleImageError(this, '{{ asset('images/default_room.png') }}')">
                                    <div class="card-body d-flex flex-column justify-content-between pb-0"> {{-- pb-0 to make space for button --}}
                                        <div>
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title mb-0">{{ $room->room_name }}</h5>
                                                {{-- Display Room Status Badge, using custom light badges --}}
                                                @php
                                                    $roomStatusClass = '';
                                                    $roomStatusText = ucfirst($room->status ?? 'Unknown');
                                                    switch ($room->status) {
                                                        case 'open':
                                                            $roomStatusClass = 'badge-light-success';
                                                            break;
                                                        case 'closed':
                                                            $roomStatusClass = 'badge-light-black';
                                                            break;
                                                        case 'rehab':
                                                            $roomStatusClass = 'badge-light-warning';
                                                            break;
                                                        default:
                                                            $roomStatusClass = 'badge-light-secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="badge {{ $roomStatusClass }} fs-6 px-3 py-1 rounded-pill">{{ $roomStatusText }}</span>
                                            </div>

                                            <p class="card-text text-muted small mb-1">
                                                {{-- Max Guests Icon --}}
                                                <i class="bi bi-people-fill me-1"></i> Max Guests: {{ $room->max_guests }}
                                            </p>
                                            <p class="card-text text-muted small mb-3">
                                                {{-- Price Icon --}}
                                                <i class="bi bi-currency-dollar me-1"></i> Price: ₱{{ number_format($room->price_per_night, 2) }} / Night
                                            </p>
                                            @if($room->description)
                                                <p class="card-text small room-description-truncated">{{ Str::limit($room->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <div>
                                            {{-- Display Room Rehab Reason if applicable --}}
                                            @if (($room->status ?? '') === 'rehab' && $room->rehab_reason)
                                                <p class="card-text text-danger small mt-0 mb-3 text-start">
                                                    <small>Reason: {{ $room->rehab_reason }}</small>
                                                </p>
                                            @else
                                                <p class="card-text text-muted small mt-0 mb-3" style="min-height: 20px; text-align: start;">
                                                    {{-- Placeholder to maintain consistent height --}}
                                                </p>
                                            @endif
                                        </div>
                                    </div> {{-- End room-card-content-clickable --}}
                                </div>

                                {{-- "Book Now" button remains a regular button, outside the modal trigger div --}}
                                <div class="mt-auto text-end p-3 pt-0"> {{-- Added padding to align with card-body, pt-0 to prevent double padding --}}
                                    @if ($room->status === 'open' && $room->admin_status === 'approved' && ($resort->status === 'open' || $resort->status === 'rehab'))
                                        <a href="#" class="btn btn-sm btn-book-now"
                                            data-bs-toggle="modal" data-bs-target="#termsAndConditionsModal"
                                            data-room-id="{{ $room->id }}"
                                            data-room-name="{{ $room->room_name }}">Book Now</a>
                                    @elseif ($room->admin_status !== 'approved')
                                        <button class="btn btn-secondary btn-sm" disabled>Awaiting Approval</button>
                                    @elseif ($room->status === 'closed')
                                        <button class="btn btn-secondary btn-sm" disabled>Closed</button>
                                    @elseif ($room->status === 'rehab')
                                        <button class="btn btn-secondary btn-sm" disabled>Under Rehab</button>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Unavailable</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No rooms available for this resort yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    {{-- Room Details Modal (Existing) --}}
    <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomDetailsModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalRoomImage" src="" class="img-fluid rounded mb-3" alt="Room Image" style="width: 100%; max-height: 400px; object-fit: cover;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 id="modalRoomName" class="mb-0"></h4>
                        <span id="modalRoomStatus" class="badge fs-6 px-3 py-1 rounded-pill"></span>
                    </div>
                    <p class="text-muted mb-1">
                        {{-- Max Guests Icon in Modal --}}
                        <i class="bi bi-people-fill me-1"></i> Max Guests: <span id="modalRoomMaxGuests"></span>
                    </p>
                    <p class="text-muted mb-3">
                        {{-- Price Icon in Modal --}}
                        <i class="bi bi-currency-dollar me-1"></i> Price: <span id="modalRoomPrice"></span>
                    </p>
                    <p id="modalRoomDescription" class="mb-3"></p>
                    <p id="modalRoomRehabReason" class="text-danger small mt-0 mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- The "Book Now" button in the modal will now trigger the terms and conditions modal --}}
                    <a href="#" id="modalBookNowBtn" class="btn btn-book-now d-none"
                        data-bs-toggle="modal" data-bs-target="#termsAndConditionsModal">Book Now</a>
                </div>
            </div>
        </div>
    </div>

    {{-- NEW: Terms and Conditions Modal --}}
    <div class="modal fade" id="termsAndConditionsModal" tabindex="-1" aria-labelledby="termsAndConditionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsAndConditionsModalLabel">Terms and Conditions for Booking <span id="roomNameForTerms"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please read the following terms and conditions carefully before proceeding with your booking.</p>
                    <div class="border p-3 mb-3" style="max-height: 300px; overflow-y: auto;">
                        <h6>1. Booking Confirmation</h6>
                        <p>All bookings are subject to availability and confirmation. A booking is not confirmed until you receive a confirmation email or notification from us.</p>

                        <h6>2. Payment</h6>
                        <p>Full payment is required at the time of booking unless otherwise stated. We accept [List accepted payment methods, e.g., credit card, debit card, bank transfer].</p>

                        <h6>3. Cancellation Policy</h6>
                        <ul>
                            <li><strong>Free Cancellation:</strong> Cancellations made [X days/hours] before the check-in date will receive a full refund.</li>
                            <li><strong>Late Cancellation:</strong> Cancellations made less than [X days/hours] before check-in will incur a charge equal to [e.g., one night's stay, 50% of the total booking].</li>
                            <li><strong>No-Show:</strong> In case of a no-show, the total amount of the reservation will be charged.</li>
                        </ul>

                        <h6>4. Check-in and Check-out Times</h6>
                        <p>Check-in time is [e.g., 2:00 PM] on the day of arrival. Check-out time is [e.g., 12:00 PM] on the day of departure. Late check-out may be available upon request and may incur additional charges.</p>

                        <h6>5. Guests and Occupancy</h6>
                        <p>The maximum number of guests for each room type is specified. Exceeding this limit is not permitted and may result in additional charges or cancellation of your booking.</p>

                        <h6>6. Damage to Property</h6>
                        <p>Guests are responsible for any damage caused to the room or resort property during their stay. Charges for repairs or replacement will be applied to the credit card on file or collected upon check-out.</p>

                        <h6>7. Resort Rules</h6>
                        <p>Guests are expected to abide by all resort rules and regulations, which will be provided upon check-in or are available upon request. This includes rules regarding noise, pool usage, and prohibited items.</p>

                        <h6>8. Force Majeure</h6>
                        <p>The resort is not liable for any failure or delay in performance due to circumstances beyond its reasonable control, including but not limited to natural disasters, acts of war, terrorism, or government regulations.</p>

                        <h6>9. Privacy Policy</h6>
                        <p>Your personal information collected during the booking process will be handled in accordance with our Privacy Policy. We do not share your information with third parties without your consent.</p>

                        <h6>10. Governing Law</h6>
                        <p>These terms and conditions are governed by the laws of [Your Country/Region/State]. Any disputes arising from these terms will be subject to the exclusive jurisdiction of the courts in [Your City/Region].</p>

                        <p>By proceeding with the booking, you acknowledge that you have read, understood, and agreed to these terms and conditions.</p>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            I have read and agree to the terms and conditions.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-book-now" id="proceedToBookBtn" disabled>Proceed to Book</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Custom styles for cards, similar to your explore page */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .card-img-top {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .card-body {
            padding: 1rem;
            background-color: var(--bs-light);
        }
        .card-title {
            font-weight: bold;
            color: #333;
            font-size: 1.15rem;
        }
        .card-text {
            font-size: 0.95rem;
            color: #6c757d;
        }
        .card-text strong {
            font-weight: bold;
        }
        /* Removed btn-primary overrides and added btn-book-now */
        .flex-grow-1 {
            flex-grow: 1;
        }
        .h-100.d-flex.flex-column {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Make room card content clickable for modal */
        .room-card-content-clickable {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            height: 100%; /* Ensure this div fills the card height minus the button */
            display: flex;
            flex-direction: column;
        }

        .room-card-content-clickable:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        /* CUSTOM LIGHT BACKGROUND BADGES (Copied from previous response for consistency) */
        .badge-light-success {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }

        .badge-light-warning {
            background-color: #fff3cd !important;
            color: #85640a !important;
            border: 1px solid #ffeeba !important;
        }

        .badge-light-danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }

        .badge-light-info {
            background-color: #e0f7fa !important;
            color: #0c5460 !important;
            border: 1px solid #b8daff !important;
        }

        .badge-light-secondary {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #d3d6da !important;
        }

        .badge-light-black {
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        /* CUSTOM "BOOK NOW" BUTTON STYLE */
        .btn-book-now {
            background-color: rgb(9, 135, 219); /* Blue color from your explore page's "View Rooms" button */
            border-color: rgb(9, 135, 219);
            color: #fff;
            border-radius: 6px; /* Added border-radius for rounded shape */
            padding: 7px 10px;   /* Adjusted padding for smaller button */
            font-weight: bold;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-book-now:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }
    </style>

    {{-- Custom JavaScript for image error handling, mobile sidebar behavior, and modals --}}
    <script>
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null;
            imgElement.src = defaultImagePath;
        }

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

            // JavaScript for handling the room details modal
            var roomDetailsModal = document.getElementById('roomDetailsModal');
            var termsAndConditionsModal = document.getElementById('termsAndConditionsModal');
            var proceedToBookBtn = document.getElementById('proceedToBookBtn');
            var agreeTermsCheckbox = document.getElementById('agreeTerms');
            var roomNameForTerms = document.getElementById('roomNameForTerms');
            var selectedRoomId = null; // To store the ID of the room being booked

            // Query modal elements once for efficiency
            var modalTitle = roomDetailsModal.querySelector('.modal-title');
            var modalRoomImage = roomDetailsModal.querySelector('#modalRoomImage');
            var modalRoomName = roomDetailsModal.querySelector('#modalRoomName');
            var modalRoomStatus = roomDetailsModal.querySelector('#modalRoomStatus');
            var modalRoomMaxGuests = roomDetailsModal.querySelector('#modalRoomMaxGuests');
            var modalRoomPrice = roomDetailsModal.querySelector('#modalRoomPrice');
            var modalRoomDescription = roomDetailsModal.querySelector('#modalRoomDescription');
            var modalRoomRehabReason = roomDetailsModal.querySelector('#modalRoomRehabReason');
            var modalBookNowBtn = roomDetailsModal.querySelector('#modalBookNowBtn');


            roomDetailsModal.addEventListener('show.bs.modal', function (event) {
                // Button or element that triggered the modal (now, it's the .room-card-content-clickable div or a button)
                var element = event.relatedTarget;

                // Extract info from data-* attributes
                var roomImage = element.getAttribute('data-room-image');
                var roomName = element.getAttribute('data-room-name');
                var roomDescription = element.getAttribute('data-room-description');
                var roomMaxGuests = element.getAttribute('data-room-max-guests');
                var roomPrice = element.getAttribute('data-room-price');
                var roomStatusText = element.getAttribute('data-room-status-text');
                var roomStatusClass = element.getAttribute('data-room-status-class');
                var roomRehabReason = element.getAttribute('data-room-rehab-reason');
                // Get admin_status and resort_status
                var roomAdminStatus = element.getAttribute('data-room-admin-status');
                var resortStatus = element.getAttribute('data-resort-status');
                selectedRoomId = element.getAttribute('data-room-id'); // Get the room ID from the clicked element

                // Update the modal's content.
                modalTitle.textContent = roomName; // Set modal title to room name
                modalRoomImage.src = roomImage;
                modalRoomImage.alt = roomName;
                modalRoomName.textContent = roomName;

                // Update status badge
                modalRoomStatus.textContent = roomStatusText;
                modalRoomStatus.className = 'badge fs-6 px-3 py-1 rounded-pill ' + roomStatusClass;

                modalRoomMaxGuests.textContent = roomMaxGuests;
                modalRoomPrice.textContent = roomPrice;
                modalRoomDescription.textContent = roomDescription;

                if (roomRehabReason) {
                    modalRoomRehabReason.textContent = roomRehabReason;
                    modalRoomRehabReason.classList.remove('d-none'); // Show if reason exists
                } else {
                    modalRoomRehabReason.textContent = '';
                    modalRoomRehabReason.classList.add('d-none'); // Hide if no reason
                }

                // Logic for the "Book Now" button in the room details modal
                if (roomStatusText.toLowerCase() === 'open' && roomAdminStatus === 'approved' && (resortStatus === 'open' || resortStatus === 'rehab')) {
                    modalBookNowBtn.classList.remove('d-none');
                    // Ensure data attributes are correctly set for the terms and conditions modal
                    modalBookNowBtn.setAttribute('data-room-id', selectedRoomId);
                    modalBookNowBtn.setAttribute('data-room-name', roomName);
                } else {
                    modalBookNowBtn.classList.add('d-none');
                }

                // Reset terms and conditions checkbox and button state when opening room details modal
                agreeTermsCheckbox.checked = false;
                proceedToBookBtn.disabled = true;
            });

            // Event listener for the terms and conditions modal
            termsAndConditionsModal.addEventListener('show.bs.modal', function (event) {
                // The relatedTarget for this modal could be a "Book Now" button from a room card or from the room details modal
                var button = event.relatedTarget;
                var roomName = button.getAttribute('data-room-name');
                selectedRoomId = button.getAttribute('data-room-id'); // Ensure selectedRoomId is updated

                roomNameForTerms.textContent = roomName;

                // Ensure the checkbox is unchecked and button disabled when the modal opens
                agreeTermsCheckbox.checked = false;
                proceedToBookBtn.disabled = true;

                // Hide the room details modal if it's open when the terms modal is triggered
                var roomDetailsBootstrapModal = bootstrap.Modal.getInstance(roomDetailsModal);
                if (roomDetailsBootstrapModal) {
                    roomDetailsBootstrapModal.hide();
                }
            });

            agreeTermsCheckbox.addEventListener('change', function() {
                proceedToBookBtn.disabled = !this.checked;
            });

            // THIS IS THE KEY CHANGE: Redirect to fillup.blade.php with room ID
            proceedToBookBtn.addEventListener('click', function() {
                if (agreeTermsCheckbox.checked && selectedRoomId) {
                    // Redirect to the tourist/fillup route, passing the selected room ID
                    window.location.href = `{{ url('tourist/fillup') }}/${selectedRoomId}`;
                }
            });
        });
    </script>
</x-app-layout>