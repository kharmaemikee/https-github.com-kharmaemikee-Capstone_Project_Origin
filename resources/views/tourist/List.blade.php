<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        @include('tourist.partials.sidebar')
        
        {{-- Main Content Area (Resorts List) --}}
        <div class="container py-4 flex-grow-1">
            <h4 class="fw-bold">RESORTS</h4>
            <div class="container py-4">
                {{-- *** MODIFIED THIS LINE *** --}}
                {{-- Changed row-cols-lg-3 to row-cols-lg-4 to make cards smaller on large screens --}}
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @forelse ($resorts as $resort)
                        <div class="col">
                            {{-- Added 'hover-effect-card' class to apply the hover animation --}}
                            <div class="card shadow-sm h-100 d-flex flex-column hover-effect-card">
                                @if ($resort->image_path)
                                    <img src="{{ asset($resort->image_path) }}"
                                         class="card-img-top"
                                         alt="{{ $resort->resort_name }}"
                                         style="height: 180px; object-fit: cover;" {{-- Adjusted height for more compact view --}}
                                         onerror="handleImageError(this, '{{ asset('images/default_resort.png') }}')">
                                @else
                                    <img src="{{ asset('images/default_resort.png') }}"
                                         class="card-img-top"
                                         alt="Default Resort Image"
                                         style="height: 180px; object-fit: cover;"> {{-- Adjusted height for more compact view --}}
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $resort->resort_name }}</h5>

                                        {{-- Display Resort Status with custom light badges --}}
                                        @php
                                            $resortStatusClass = '';
                                            $resortStatusText = ucfirst($resort->status ?? 'Unknown');
                                            switch ($resort->status) {
                                                case 'open':
                                                    $resortStatusClass = 'badge-light-success';
                                                    break;
                                                case 'closed':
                                                    $resortStatusClass = 'badge-light-black'; // Using badge-light-black for closed
                                                    break;
                                                case 'rehab':
                                                    $resortStatusClass = 'badge-light-warning';
                                                    break;
                                                default:
                                                    $resortStatusClass = 'badge-light-secondary';
                                                    break;
                                            }
                                        @endphp
                                        <span class="badge {{ $resortStatusClass }} fs-6 px-3 py-2 rounded-pill">{{ $resortStatusText }}</span>
                                    </div>

                                    <p class="card-text text-muted small mb-1">
                                        {{ $resort->location }}
                                    </p>

                                    {{-- Display Rehab Reason for Resort if applicable --}}
                                    @if (($resort->status ?? '') === 'rehab' && $resort->rehab_reason)
                                        <p class="card-text text-danger small mt-0 mb-3">
                                            <small>Reason: {{ $resort->rehab_reason }}</small>
                                        </p>
                                    @else
                                        <p class="card-text text-muted small mt-0 mb-3" style="min-height: 20px;">
                                            {{-- Placeholder to maintain consistent height --}}
                                        </p>
                                    @endif

                                    {{-- Summary of Room Statuses --}}
                                    @php
                                        $openRoomsCount = $resort->rooms->where('status', 'open')->count();
                                        // $closedRoomsCount = $resort->rooms->where('status', 'closed')->count(); // Not used in display logic below
                                        // $rehabRoomsCount = $resort->rooms->where('status', 'rehab')->count(); // Not used in display logic below
                                    @endphp

                                    <div class="mt-auto">
                                        @if ($resort->status === 'open' && $openRoomsCount > 0)
                                            <p class="card-text small text-success mb-2">{{ $openRoomsCount }} room(s) available for booking.</p>
                                            <a href="{{ route('explore.show', $resort->id) }}"
                                               class="btn btn-primary float-end px-4 resort-view-rooms-btn">View Rooms</a>
                                        @elseif ($resort->status === 'rehab')
                                            <p class="card-text small text-warning mb-2">Resort is under rehabilitation. Bookings may be limited.</p>
                                            <button type="button" class="btn btn-secondary float-end px-4" disabled>Under Rehab</button>
                                        @elseif ($resort->status === 'closed')
                                            <p class="card-text small text-danger mb-2">Resort is currently closed.</p>
                                            <button type="button" class="btn btn-secondary float-end px-4" disabled>Closed</button>
                                        @else
                                            <p class="card-text small text-muted mb-2">No rooms currently available or resort status unknown.</p>
                                            <button type="button" class="btn btn-secondary float-end px-4" disabled>Unavailable</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No resorts available to explore yet. Please check back later!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color:rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Custom CSS for light background badges */
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

        /* Custom styles for cards */
        .card-title {
            font-weight: bold;
            color: #333;
            font-size: 1.15rem;
        }
        .card-text {
            font-size: 0.95rem;
            color: #6c757d;
        }
        .resort-view-rooms-btn {
            background-color: rgb(9, 135, 219);
            border-color: rgb(9, 135, 219);
            color: #fff;
            border-radius: 6px; /* Added border-radius for rounded shape */
            padding: 7px 10px;    /* Adjusted padding for smaller button */
            transition: background-color 0.2s, border-color 0.2s;
        }
        .resort-view-rooms-btn:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }
        .card-body > *:first-child {
            margin-top: 0;
        }
        .flex-grow-1 {
            flex-grow: 1;
        }
        .h-100.d-flex.flex-column {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        /* Added / Adjusted for more compact cards */
        .card-img-top {
            height: 180px; /* Reduced slightly from 200px in your exploring example for potentially more compact cards */
            object-fit: cover;
        }

        /* Card Hover Effect */
        .hover-effect-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            cursor: pointer; /* Indicates it's interactive, even if not clickable */
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; /* Bootstrap default shadow */
        }

        .hover-effect-card:hover {
            transform: translateY(-5px); /* Moves the card up slightly */
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; /* Stronger shadow on hover */
        }
    </style>

    {{-- Custom JavaScript for image error handling and mobile sidebar behavior --}}
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
                    if (window.innerWidth >= 768) { // Bootstrap's 'md' breakpoint is 768px
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }
        });
    </script>
</x-app-layout>