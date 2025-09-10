<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Resort Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Resorts Menu
            </h4>
            <ul class="nav flex-column mt-3">
                
                <li class="nav-item mt-2 position-relative">
                    {{-- Active link for Dashboard --}}
                    <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    @if(auth()->user()->canAccessMainFeatures())
                        <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    @else
                        <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="right" 
                              title="Upload your permits first to unlock this feature">
                            <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                            Resort Management
                            <span class="badge bg-warning ms-2">Locked</span>
                        </span>
                    @endif
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Account Management
                    </a>
                </li>
                {{-- Notifications (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Notifications
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                {{-- Documentation (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                        <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Documentation
                    </a>
                </li>
            </ul>
        </div>

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                &#9776;
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
            <div class="offcanvas-header">
                {{-- Icon added here for Resort Owner in mobile sidebar using <img> --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Resorts Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                   
                    <li class="nav-item mt-2 position-relative">
                        {{-- Active link for Dashboard --}}
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Resort Management
                            </a>
                        @else
                            <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                                Resort Management
                                <span class="badge bg-warning ms-2">Locked</span>
                            </span>
                        @endif
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    {{-- Notifications (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notifications
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- Documentation (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                            <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Documentation
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="row">
                {{-- Overall Resort Usage Statistics --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Overall Resort Usage</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="text-center">
                                        <div class="h2 text-primary mb-1">{{ $totalBookings ?? 0 }}</div>
                                        <div class="text-muted">Total Bookings</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="text-center">
                                        <div class="h2 text-success mb-1">{{ $activeBookings ?? 0 }}</div>
                                        <div class="text-muted">Active Bookings</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="text-center">
                                        <div class="h2 text-info mb-1">{{ $totalGuests ?? 0 }}</div>
                                        <div class="text-muted">Total Guests Served</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="text-center">
                                        <div class="h2 text-warning mb-1">{{ $totalRevenue ?? 0 }}</div>
                                        <div class="text-muted">Total Revenue (₱)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resort Usage Bar Graph --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Resort Usage Statistics</h5>
                        </div>
                        <div class="card-body">
                            {{-- Check if there is data to display --}}
                            @if(count($data) > 0)
                                <canvas id="resortUsageChart" height="100"></canvas>
                            @else
                                <div class="text-center p-5">
                                    <p>No booking data available for the last 12 months. Start by adding rooms to your resort!</p>
                                    <a href="{{ route('resort.owner.information') }}" class="btn btn-primary">Manage Resort</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Resort Usage Line Graph --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Monthly Booking Trends</h5>
                        </div>
                        <div class="card-body">
                            {{-- Check if there is data to display --}}
                            @if(count($data) > 0)
                                <canvas id="resortTrendChart" height="100"></canvas>
                            @else
                                <div class="text-center p-5">
                                    <p>No booking data available for the last 12 months. Start by adding rooms to your resort!</p>
                                    <a href="{{ route('resort.owner.information') }}" class="btn btn-primary">Manage Resort</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN (include this at the end of your body or in your main layout) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color:rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Style for the rotated icon */
        .collapse-icon img {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }
    </style>

    {{-- Custom JavaScript to handle arrow rotation and chart --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            collapseToggles.forEach(function(toggle) {
                var targetId = toggle.getAttribute('href');
                if (targetId) {
                    var targetCollapse = document.querySelector(targetId);
                    if (targetCollapse && targetCollapse.classList.contains('show')) {
                        var icon = toggle.querySelector('.collapse-icon');
                        if (icon) {
                            icon.classList.add('rotated');
                        }
                    }
                }

                toggle.addEventListener('click', function() {
                    var icon = this.querySelector('.collapse-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // Check if chart data exists before initializing
            @if(count($data) > 0)
                // Bar Chart
                const ctx = document.getElementById('resortUsageChart').getContext('2d');
                const labels = @json($labels);
                const data = @json($data);

                const resortUsageChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of Bookings',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Bookings'
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw + ' bookings';
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });

                // Line Chart
                const ctx2 = document.getElementById('resortTrendChart').getContext('2d');
                const resortTrendChart = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Bookings',
                            data: data,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Bookings'
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw + ' bookings';
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            @endif

            // --- New JavaScript for Offcanvas Hiding ---
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
        });
    </script>
</x-app-layout>