<x-app-layout>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="modern-sidebar d-none d-md-block">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Welcome {{ auth()->user()->first_name }}</h4>
                        <p class="brand-subtitle">Boat Owner Portal</p>
                    </div>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('boat.owner.dashboard') }}" class="nav-link {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                    <li class="nav-item">
                        <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Boat Management</span>
                    </a>
                </li>
                    <li class="nav-item">
                        <a href="{{ route('boat.owner.verified') }}" class="nav-link {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Account Management</span>
                    </a>
                </li>
                    <li class="nav-item">
                        <a href="{{ route('boat.owner.notification') }}" class="nav-link {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Notifications</span>
                        @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="nav-badge notification-badge" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
            </div>
        </div>

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="mobile-toggle d-md-none">
            <button class="mobile-toggle-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start modern-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <div class="mobile-sidebar-brand">
                    <div class="mobile-brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title" id="mobileSidebarLabel">Welcome {{ auth()->user()->first_name }}</h5>
                        <p class="mobile-brand-subtitle">Boat Owner Portal</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mobile-sidebar-nav">
                <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('boat.owner.dashboard') }}" class="nav-link {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                        <li class="nav-item">
                            <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Boat Management</span>
                        </a>
                    </li>
                        <li class="nav-item">
                            <a href="{{ route('boat.owner.verified') }}" class="nav-link {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Account Management</span>
                        </a>
                    </li>
                        <li class="nav-item">
                            <a href="{{ route('boat.owner.notification') }}" class="nav-link {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Notifications</span>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                    <span class="nav-badge notification-badge" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Manage Boat</h2>
                <a href="{{ route('boat.owner.add') }}" class="btn btn-dark d-flex align-items-center gap-2 text-white text-decoration-none">
                    Add Boat
                    <span style="font-size: 1.2rem;">+</span>
                </a>
            </div>


            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Assign No</th>
                            <th scope="col">Boat Image</th>
                            <th scope="col">Boat Name</th>
                            <th scope="col">Boat Plate Number</th>
                            <th scope="col">Price</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Length</th>
                            <th scope="col">Boat Captain</th>
                            <th scope="col">Captain Contact</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($boats as $boat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($boat->image_path)
                                        <img src="{{ asset($boat->image_path) }}"
                                             alt="{{ $boat->boat_name }}"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                             onerror="handleImageError(this, '{{ asset('images/boat.png') }}')">
                                    @else
                                        <img src="{{ asset('images/boat.png') }}"
                                             alt="Default Boat Image"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                </td>
                                <td>{{ $boat->boat_name }}</td>
                                <td>{{ $boat->boat_number }}</td>
                                <td>₱{{ number_format($boat->boat_prices, 2) }}</td>
                                <td>{{ $boat->boat_capacities }} pax</td>
                                <td>{{ $boat->boat_length ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $captainName = !empty($boat->captain_name) ? $boat->captain_name : null;
                                        $hasCaptain = false;
                                        if ($captainName) {
                                            $hasCaptain = true;
                                        } elseif (!empty($boat->has_captain)) {
                                            $hasCaptain = (bool) $boat->has_captain;
                                        } elseif (!empty($boat->captain_user_id)) {
                                            $hasCaptain = true;
                                        }
                                    @endphp
                                    {{ $captainName ?? ($hasCaptain ? 'Yes' : 'No') }}
                                </td>
                                <td>{{ $boat->captain_contact ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statusClass = '';
                                        $displayText = '';
                                        switch ($boat->status) {
                                            case \App\Models\Boat::STATUS_APPROVED:
                                                $statusClass = 'badge-light-success';
                                                $displayText = 'Approved';
                                                break;
                                            case \App\Models\Boat::STATUS_REJECTED:
                                                $statusClass = 'badge-light-danger';
                                                $displayText = 'Rejected';
                                                break;
                                            case \App\Models\Boat::STATUS_PENDING:
                                                $statusClass = 'badge-light-info';
                                                $displayText = 'Pending';
                                                break;
                                            case \App\Models\Boat::STATUS_OPEN:
                                                $statusClass = 'badge-light-success';
                                                $displayText = 'Open';
                                                break;
                                            case \App\Models\Boat::STATUS_ASSIGNED:
                                                $statusClass = 'badge-light-info';
                                                $displayText = 'Assigned';
                                                break;
                                            case \App\Models\Boat::STATUS_CLOSED:
                                                $statusClass = 'badge-light-secondary'; // You can define a new badge style if you want a specific color for 'Not Available'
                                                $displayText = 'Not Available'; // Changed text here
                                                break;
                                            case \App\Models\Boat::STATUS_REHAB:
                                                $statusClass = 'badge-light-warning';
                                                $displayText = 'Rehab';
                                                break;
                                            default:
                                                $statusClass = 'badge-light-secondary';
                                                $displayText = 'N/A';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ $displayText }}
                                    </span>
                                    @if (($boat->status ?? '') === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                                        <small class="d-block text-muted">Reason: {{ $boat->rejection_reason }}</small>
                                    @elseif (($boat->status ?? '') === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                                        <small class="d-block text-muted">Rehab Reason: {{ $boat->rejection_reason }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Edit button is now always enabled --}}
                                        <a href="{{ route('boat.edit', $boat->id) }}" class="btn btn-primary btn-sm action-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm action-btn delete-btn"
                                                data-boat-id="{{ $boat->id }}"
                                                data-boat-name="{{ $boat->boat_name }}"
                                                data-bs-placement="top" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No boats added yet. Click "Add Boat" to get started!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Modern Sidebar Styles */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: #2c3e50;
            border-right: 1px solid #34495e;
            position: relative;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .brand-icon-img {
            width: 28px;
            height: 28px;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            flex: 1;
        }

        .brand-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            margin: 0;
            line-height: 1.2;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-badge {
            background: #e74c3c;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            font-weight: 600;
        }

        .notification-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            background: linear-gradient(135deg, rgb(35, 46, 26) 0%, #16213e 50%, #0f3460 100%);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .mobile-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .mobile-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            width: 85vw !important;
            max-width: 350px;
        }

        .mobile-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-brand-icon-img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .mobile-brand-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .mobile-brand-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
            margin: 0;
        }

        .mobile-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0.25rem 1rem;
        }

        .mobile-sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
        }


        /* Main Content */
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-sidebar {
                display: none;
            }
            
            .main-content {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
            
            .main-content {
                padding: 0.75rem;
            }
        }

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
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
            border: 1px solid #f5c2c7 !important;
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

        /* Action button styles */
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .action-btn i {
            font-size: 14px;
        }

        /* Custom tooltip for delete button */
        .delete-btn {
            position: relative;
        }

        .delete-btn::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
            margin-bottom: 5px;
        }

        .delete-btn:hover::after {
            opacity: 1;
            visibility: visible;
        }

        /* SweetAlert2 Responsive Styles */
        .swal2-popup-responsive {
            font-size: 14px !important;
            max-width: 90% !important;
            width: 400px !important;
        }

        .swal2-title-responsive {
            font-size: 18px !important;
            line-height: 1.4 !important;
        }

        .swal2-content-responsive {
            font-size: 14px !important;
            line-height: 1.5 !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .swal2-popup-responsive {
                font-size: 12px !important;
                max-width: 95% !important;
                width: 350px !important;
                margin: 10px !important;
            }

            .swal2-title-responsive {
                font-size: 16px !important;
            }

            .swal2-content-responsive {
                font-size: 12px !important;
            }
        }

        @media (max-width: 480px) {
            .swal2-popup-responsive {
                font-size: 11px !important;
                max-width: 98% !important;
                width: 320px !important;
                margin: 5px !important;
            }

            .swal2-title-responsive {
                font-size: 14px !important;
            }

            .swal2-content-responsive {
                font-size: 11px !important;
            }
        }
    </style>

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

            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null;
                imgElement.src = defaultImagePath;
            };

            // Handle delete buttons with SweetAlert2
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const boatId = this.getAttribute('data-boat-id');
                    const boatName = this.getAttribute('data-boat-name');
                    
                    Swal.fire({
                        title: "Are you sure you want to delete this boat?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive',
                            confirmButton: 'swal2-confirm-responsive',
                            cancelButton: 'swal2-cancel-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the boat.',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-popup-responsive',
                                    title: 'swal2-title-responsive',
                                    content: 'swal2-content-responsive'
                                }
                            });
                            
                            // Create form data for delete request
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');
                            
                            // Send delete request
                            fetch(`/boats/${boatId}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    // Remove the boat row from the table immediately
                                    const boatRow = this.closest('tr');
                                    if (boatRow) {
                                        boatRow.remove();
                                    }
                                    
                                    // Show success message
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting boat:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete boat. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive',
                                        confirmButton: 'swal2-confirm-responsive'
                                    }
                                });
                            });
                        }
                    });
                });
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

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Check for success message and show SweetAlert2 popup
            @if (session('success'))
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "You have successfully added the boats, wait for admin approval.",
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'swal2-popup-responsive',
                        title: 'swal2-title-responsive',
                        content: 'swal2-content-responsive'
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
