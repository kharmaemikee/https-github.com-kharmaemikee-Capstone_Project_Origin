<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Boat Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Boat Menu
            </h4>
            <ul class="nav flex-column mt-3">
                
                <li class="nav-item mt-2 position-relative">
                    {{-- 'active' class for the Dashboard link --}}
                    <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    @if(auth()->user()->canAccessMainFeatures())
                        <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat') ? 'active' : '' }}">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Management
                        </a>
                    @else
                        <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="right" 
                              title="Upload your permits first to unlock this feature">
                            <img src="{{ asset('images/information.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                            Boat Management
                            <span class="badge bg-warning ms-2">Locked</span>
                        </span>
                    @endif
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Account Management
                    </a>
                </li>
                {{-- Notification Direct Link (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Notifications
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
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
                {{-- Icon added here for Boat Owner in mobile sidebar using <img> --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Boat Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                   
                    <li class="nav-item mt-2 position-relative">
                        <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat') ? 'active' : '' }}">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Boat Management
                            </a>
                        @else
                            <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <img src="{{ asset('images/information.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                                Boat Management
                                <span class="badge bg-warning ms-2">Locked</span>
                            </span>
                        @endif
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    {{-- Notification Direct Link (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notifications
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="row">
                {{-- Overall Boat Usage Statistics --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Overall Boat Usage</h5>
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

                {{-- Boat Usage Bar Graph --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Boat Usage Statistics</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="boatUsageChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Boat Usage Line Graph --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Monthly Booking Trends</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="boatTrendChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN (include this at the end of your body or in your main layout) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom CSS for sidebar nav-link hover and focus --}}
    <style>
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Set width for mobile offcanvas sidebar */
        #mobileSidebar {
            width: 50vw; /* This makes it half the viewport width */
        }

        /* Styles for the collapse icon rotation */
        .collapse-icon img {
            transition: transform 0.3s ease-in-out;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        /* Styles for active parent link - matched with boat.blade.php if applicable or kept for consistency */
        .nav-link.active-parent {
             background-color: rgb(6, 58, 170) !important; /* This ensures consistency with the active link color from boat.blade.php */
        }
    </style>

    {{-- Custom JavaScript to handle arrow rotation and chart --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle collapse toggles for notifications
            const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
            collapseElements.forEach(element => {
                element.addEventListener('click', function() {
                    const targetId = this.getAttribute('href');
                    const target = document.querySelector(targetId);
                    if (target) {
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';
                        this.setAttribute('aria-expanded', !isExpanded);
                        
                        // Rotate arrow icon
                        const icon = this.querySelector('.collapse-icon img');
                        if (icon) {
                            if (isExpanded) {
                                icon.style.transform = 'rotate(0deg)';
                            } else {
                                icon.style.transform = 'rotate(180deg)';
                            }
                        }
                    }
                });
            });

        // NEW: Chart.js initialization with dynamic data for boat usage
        const ctx = document.getElementById('boatUsageChart').getContext('2d');
        
        // Gamitin ang data na galing sa Laravel backend
        const boatLabels = {!! json_encode($boatLabels ?? ['Boat 1', 'Boat 2', 'Boat 3', 'Boat 4', 'Boat 5']) !!};
        const boatUsageData = {!! json_encode($boatUsageData ?? [12, 19, 8, 15, 7]) !!};
        const boatRevenueData = {!! json_encode($boatRevenueData ?? [24000, 38000, 16000, 30000, 14000]) !!};

        const boatUsageChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: boatLabels,
                datasets: [{
                    label: 'Number of Bookings',
                    data: boatUsageData,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Revenue (₱)',
                    data: boatRevenueData,
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Boats'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Bookings'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (₱)'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return context.dataset.label + ': ' + context.raw + ' bookings';
                                } else {
                                    return context.dataset.label + ': ₱' + context.raw.toLocaleString();
                                }
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

        // Line Chart for Monthly Trends
        const ctx2 = document.getElementById('boatTrendChart').getContext('2d');
        const boatTrendChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: boatLabels,
                datasets: [{
                    label: 'Monthly Bookings',
                    data: boatUsageData,
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
                            text: 'Boats'
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

        // --- JavaScript for Offcanvas Hiding ---
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
        // --- End JavaScript ---
    });
</script>
</x-app-layout>