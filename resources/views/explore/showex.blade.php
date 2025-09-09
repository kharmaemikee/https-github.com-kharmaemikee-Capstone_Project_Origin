<x-app-layout>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbf2);">
    <main class="py-4 px-3 flex-grow-1">
        <h2 class="mb-2 d-flex align-items-center">
            {{ $resort->resort_name }}
            @php
                $resortStatusClass = match($resort->status) {
                    'open' => 'badge-light-success',
                    'closed' => 'badge-light-black',
                    'maintenance' => 'badge-light-warning',
                    default => 'badge-light-secondary',
                };
            @endphp
            <span class="badge {{ $resortStatusClass }} ms-3 fs-6 px-3 py-2 rounded-pill">{{ ucfirst($resort->status ?? 'Unknown') }}</span>
        </h2>

        @if (($resort->status ?? '') === 'maintenance' && $resort->rehab_reason)
            <div class="alert alert-warning mt-3" role="alert">
                <strong>Resort Under Maintenance:</strong> {{ $resort->rehab_reason }}
            </div>
        @elseif (($resort->status ?? '') === 'closed')
            <div class="alert alert-danger mt-3" role="alert">
                <strong>Resort Closed:</strong> This resort is currently not operating.
            </div>
        @endif

        <p class="text-muted mb-1 d-flex align-items-center">
            <img src="{{ asset('images/phone.png') }}" alt="Phone Icon" style="width: 20px; height: 20px; margin-right: 8px;">
            <strong style="margin-right: 10px;">Contact:</strong> {{ $resort->contact_number ?? 'N/A' }}
        </p>

        <p class="text-muted mb-4 d-flex align-items-center">
            <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 20px; height: 20px; margin-right: 8px;">
            <strong style="margin-right: 10px;">Facebook Page:</strong>
            @if ($resort->facebook_page_link)
                <a href="{{ $resort->facebook_page_link }}" target="_blank">{{ $resort->facebook_page_link }}</a>
            @else
                N/A
            @endif
        </p>

        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-3">View Accommodations</h2>
                    <div class="d-flex gap-2 mb-4">
                        <a href="{{ request()->fullUrlWithQuery(['show' => 'rooms']) }}" class="btn btn-book-now">View Rooms</a>
                        <a href="{{ request()->fullUrlWithQuery(['show' => 'cottages']) }}" class="btn btn-outline-secondary">View Cottages</a>
                    </div>
                    <hr class="mb-4">
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @php
                    $show = request('show', 'rooms');
                    $list = $show === 'cottages' ? $resort->rooms->where('accommodation_type','cottage') : $resort->rooms->where('accommodation_type','room');
                @endphp
                @forelse ($list as $room)
                    <div class="col">
                        <div class="card shadow-sm h-100 rounded">
                            <div class="room-card-content-clickable"
                                 data-bs-toggle="modal" data-bs-target="#roomDetailsModal"
                                 data-room-image="{{ asset($room->image_path ? $room->image_path : 'images/default_room.png') }}"
                                 data-room-name="{{ $room->room_name }}"
                                 data-room-description="{{ $room->description }}"
                                 data-room-max-guests="{{ $room->max_guests }}"
                                 data-room-price="₱{{ number_format($room->price_per_night, 2) }} / Night"
                                 data-room-status-text="{{ ucfirst($room->status ?? 'Unknown') }}"
                                 data-room-status-class="@php
                                     echo match($room->status) {
                                         'open' => 'badge-light-success',
                                         'closed' => 'badge-light-black',
                                         'maintenance' => 'badge-light-warning',
                                         default => 'badge-light-secondary',
                                     };
                                 @endphp
                                 data-room-rehab-reason="{{ (($room->status ?? '') === 'maintenance' && $room->rehab_reason) ? 'Reason: ' . $room->rehab_reason : '' }}"
                                 data-room-admin-status="{{ $room->admin_status ?? '' }}"
                                 data-resort-status="{{ $resort->status ?? '' }}"
                                 data-room-id="{{ $room->id }}"
                                 style="cursor: pointer;">
                                <img src="{{ asset($room->image_path ? $room->image_path : 'images/default_room.png') }}"
                                     class="card-img-top rounded-top"
                                     alt="{{ $room->room_name }}"
                                     style="height: 150px; object-fit: cover;">

                                <div class="card-body d-flex flex-column justify-content-between pb-0">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ $room->room_name }}</h5>
                                            @php
                                                $roomStatusClass = match($room->status) {
                                                    'open' => 'badge-light-success',
                                                    'closed' => 'badge-light-black',
                                                    'maintenance' => 'badge-light-warning',
                                                    default => 'badge-light-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $roomStatusClass }} fs-6 px-3 py-1 rounded-pill">{{ ucfirst($room->status ?? 'Unknown') }}</span>
                                        </div>
                                        <p class="card-text text-muted small mb-1"><i class="bi bi-people-fill me-1"></i> Max Guests: {{ $room->max_guests }}</p>
                                        <p class="card-text text-muted small mb-3"><i class="bi me-1"></i> Price: ₱{{ number_format($room->price_per_night, 2) }} {{ $room->accommodation_type === 'cottage' ? '/ Stay' : '/ Night' }}</p>
                                        @if($room->description)
                                            <p class="card-text small room-description-truncated">{{ Str::limit($room->description, 100) }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        @if (($room->status ?? '') === 'maintenance' && $room->rehab_reason)
                                            <p class="card-text text-danger small mt-0 mb-3 text-start">
                                                <small>Reason: {{ $room->rehab_reason }}</small>
                                            </p>
                                        @else
                                            <p class="card-text text-muted small mt-0 mb-3" style="min-height: 20px;"></p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Book Now Button --}}
                            <div class="mt-auto text-end p-3 pt-0">
                                @php
                                    $canBook = $room->status === 'open' && $room->admin_status === 'approved' && in_array($resort->status, ['open', 'rehab']);
                                @endphp
                                @if ($canBook)
                                    @auth
                                        <a href="{{ route('booking.create', $room->id) }}" class="btn btn-sm btn-book-now">Book Now</a>
                                    @else
                                        <a href="#" class="btn btn-sm btn-book-now"
                                            data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                                            data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}">
                                            Book Now
                                        </a>
                                    @endauth
                                @elseif ($room->admin_status !== 'approved')
                                    <button class="btn btn-secondary btn-sm" disabled>Awaiting Approval</button>
                                @elseif ($room->status === 'closed')
                                    <button class="btn btn-secondary btn-sm" disabled>Closed</button>
                                                                        @elseif ($room->status === 'maintenance')
                                            <button class="btn btn-secondary btn-sm" disabled>Under Maintenance</button>
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

{{-- Login Modal --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginRequiredModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>You must be logged in to book <strong id="roomNameForLogin"></strong>.</p>
                <p>Please log in or register to continue.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-book-now">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    function handleImageError(imgElement, fallbackPath) {
        imgElement.onerror = null;
        imgElement.src = fallbackPath;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.btn-book-now').forEach(button => {
            button.addEventListener('click', () => {
                const roomName = button.getAttribute('data-room-name');
                if (roomName) {
                    document.getElementById('roomNameForLogin').textContent = roomName;
                }
            });
        });
    });
</script>

{{-- Your styles below if needed --}}
<style>

    /* Base card style */
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    /* Room image rounded only at top */
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

    /* Allow card to grow in layout */
    .flex-grow-1 {
        flex-grow: 1;
    }

    .h-100.d-flex.flex-column {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Make room card area clickable and hoverable */
    .room-card-content-clickable {
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Hover effect — card lift with shadow */
    .room-card-content-clickable:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    /* "Book Now" button styling */
    .btn-book-now {
        background-color: rgb(9, 135, 219);
        border-color: rgb(9, 135, 219);
        color: #fff;
        border-radius: 6px;
        padding: 7px 10px;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-book-now:hover {
        background-color: rgb(5, 95, 155) !important;
        border-color: rgb(5, 95, 155) !important;
        color: #fff;
    }

    .btn-book-now:disabled {
        background-color: #6c757d;
        border-color: #6c757d;
        cursor: not-allowed;
    }    


    .btn-book-now {
        background-color: rgb(9, 135, 219);
        border-color: rgb(9, 135, 219);
        color: #fff;
    }
    .btn-book-now:hover {
        background-color: rgb(5, 95, 155);
        border-color: rgb(5, 95, 155);
        color: #fff;
    }
    .badge-light-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .badge-light-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    .badge-light-black {
        background-color: #f8f9fa;
        color: #212529;
        border: 1px solid #dee2e6;
    }
    .badge-light-secondary {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d3d6da;
    }
</style>
</x-app-layout>
