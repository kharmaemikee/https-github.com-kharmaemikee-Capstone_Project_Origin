<x-app-layout>
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
                    <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start active">
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
                        <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start active">
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

        <div class="container py-5 flex-grow-1">
            <h4 class="fw-bold">HOME</h4>
            <h5 class="text-muted">RECOMMENDATIONS</h5>

            <div class="container py-5">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                    <div class="col">
                        <div class="card shadow rounded-3 border-0 h-100 d-flex flex-column">
                            <a href="{{ route('tourist.reminders') }}" class="text-decoration-none">
                                <img src="{{ asset('images/cottages.png') }}" class="card-img-top rounded-top" alt="Resorts" style="height: 180px; object-fit: cover;">
                            </a>
                            <div class="card-body bg-light d-flex flex-column justify-content-center">
                                <h5 class="fw-bold mb-0 text-center">Resorts</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mt-4">MOST VISITED RESORTS</h5>
            <div class="row flex-nowrap overflow-auto py-3 custom-scrollbar">

                @forelse ($mostVisitedResorts as $resort)
                    <div class="col-10 col-sm-6 col-md-4 col-lg-3 col-xl-2-5 mb-3">
                        <div class="card shadow-sm h-100 d-flex flex-column">
                            <img src="{{ asset($resort->image_path ?? 'images/cottages.png') }}" class="card-img-top" alt="{{ $resort->resort_name }}" style="height: 150px; object-fit: cover;" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title mb-1"><strong>{{ $resort->resort_name }}</strong></h6>
                                <p class="card-text text-muted small mb-2">{{ $resort->address }}</p>
                                <p class="card-text small mb-2">
                                    <strong class="text-primary">{{ $resort->visit_count ?? 0 }}</strong> visits
                                </p>
                                <div class="mt-auto">
                                    <a href="{{ route('explore.show', $resort->id) }}" class="btn btn-sm btn-primary resort-view-rooms-btn">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No most visited resorts to display yet.</p>
                    </div>
                @endforelse
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
        /* Added general card image styling for consistency */
        .card-img-top {
            height: 180px; /* Consistent height for images in the main recommendation cards */
            object-fit: cover; /* Ensures images fill space without distortion */
        }
        .card-body.bg-light.d-flex.flex-column.justify-content-center {
            padding: 1rem; /* Ensure standard padding */
        }

        /* Styles for Horizontal Scrolling Sections (kept for future use, even though content is commented out) */
        .flex-nowrap {
            flex-wrap: nowrap !important;
        }

        .overflow-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* For smoother scrolling on iOS */
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .custom-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .custom-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        /* Specific column width for horizontal scrolling to show partial next card */
        .col-xl-2-5 {
            flex: 0 0 auto;
            width: 25%; /* Roughly 4 cards on large screens */
        }
        @media (min-width: 1200px) { /* Extra large devices (xl) */
            .col-xl-2-5 {
                width: 20%; /* 5 cards on very large screens */
            }
        }
        @media (min-width: 992px) and (max-width: 1199.98px) { /* Large devices (lg) */
            .col-lg-3 {
                width: 33.333333%; /* 3 cards on large screens */
            }
        }
        @media (min-width: 768px) and (max-width: 991.98px) { /* Medium devices (md) */
            .col-md-4 {
                width: 33.333333%; /* 3 cards on medium screens */
            }
        }
        @media (min-width: 576px) and (max-width: 767.98px) { /* Small devices (sm) */
            .col-sm-6 {
                width: 50%; /* 2 cards on small screens */
            }
        }
        @media (max-width: 575.98px) { /* Extra small devices (xs) */
            .col-10 {
                width: 80%; /* Show one full card and part of the next on extra small screens */
            }
        }
        /* Custom button style for 'View' button in horizontal scroll sections */
        .resort-view-rooms-btn {
            background-color: rgb(9, 135, 219);
            border-color: rgb(9, 135, 219);
            color: #fff;
        }
        .resort-view-rooms-btn:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }
    </style>

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