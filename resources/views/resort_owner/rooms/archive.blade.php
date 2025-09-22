<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar (same style as resort-information) --}}
        <div class="modern-sidebar d-none d-md-block">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Resorts Menu</h4>
                        <p class="brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Resort Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Account Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.notification') }}" class="nav-link {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Notifications</span>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="nav-badge notification-badge" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.documentation') }}" class="nav-link {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Documentation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start modern-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <div class="mobile-sidebar-brand">
                    <div class="mobile-brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title" id="mobileSidebarLabel">Resorts Menu</h5>
                        <p class="mobile-brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mobile-sidebar-nav">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('resort.owner.dashboard') }}" class="nav-link {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Resort Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resort.owner.verified') }}" class="nav-link {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Account Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resort.owner.notification') }}" class="nav-link {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Notifications</span>
                                @if(isset($unreadCount) && $unreadCount > 0)
                                    <span class="nav-badge" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resort.owner.documentation') }}" class="nav-link {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Documentation</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content flex-grow-1">
            <div class="container-fluid flex-grow-1 p-0">
                {{-- Page Header --}}
                <div class="page-header">
                    <div class="page-title-section">
                        <h1 class="page-title">
                            <i class="fas fa-archive me-2"></i>
                            Archived Rooms
                        </h1>
                        <p class="page-subtitle">Manage archived rooms for {{ $resort->resort_name }}</p>
                    </div>
                    <div class="page-actions">
                        <a href="{{ route('resort.owner.information') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Resort Management
                        </a>
                    </div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Archive Content --}}
                <div class="archive-container">
                    <div class="archive-card">
                        @if($archivedRooms->count() > 0)
                            <div class="archive-stats">
                                <div class="stat-item">
                                    <i class="fas fa-archive"></i>
                                    <span>{{ $archivedRooms->count() }} Archived Room{{ $archivedRooms->count() !== 1 ? 's' : '' }}</span>
                                </div>
                            </div>

                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table archive-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <i class="fas fa-image me-1"></i>
                                                    Image
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-bed me-1"></i>
                                                    Room Name
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-tag me-1"></i>
                                                    Price / Night
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-users me-1"></i>
                                                    Max Guests
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Archived Date
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-cogs me-1"></i>
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($archivedRooms as $room)
                                                <tr class="archive-row">
                                                    <td class="room-image-cell">
                                                        <div class="room-image-wrapper">
                                                            @if ($room->image_path)
                                                                <img src="{{ asset($room->image_path) }}"
                                                                    alt="{{ $room->room_name }}"
                                                                    class="room-image"
                                                                    data-fallback="{{ asset('images/default_room.png') }}">
                                                            @else
                                                                <img src="{{ asset('images/default_room.png') }}"
                                                                    alt="Default Room Image"
                                                                    class="room-image">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="room-name-cell">
                                                        <div class="room-name">{{ $room->room_name }}</div>
                                                    </td>
                                                    <td class="price-cell">
                                                        <span class="price-amount">₱{{ number_format($room->price_per_night, 2) }}</span>
                                                    </td>
                                                    <td class="guests-cell">
                                                        <span class="guests-count">{{ $room->max_guests }}</span>
                                                        <small class="guests-label">guests</small>
                                                    </td>
                                                    <td class="date-cell">
                                                        <div class="archived-date">
                                                            @if($room->archived_at)
                                                                @if($room->archived_at instanceof \Carbon\Carbon)
                                                                    <div class="date-main">{{ $room->archived_at->format('M d, Y') }}</div>
                                                                    <div class="date-time">{{ $room->archived_at->format('H:i') }}</div>
                                                                @else
                                                                    <div class="date-main">{{ is_string($room->archived_at) ? $room->archived_at : 'Invalid Date' }}</div>
                                                                @endif
                                                            @else
                                                                <div class="date-main text-muted">Unknown</div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="actions-cell">
                                                        <div class="action-buttons">
                                                            <button type="button" class="btn btn-success btn-sm action-btn restore-btn" 
                                                                    data-room-id="{{ $room->id }}" 
                                                                    data-room-name="{{ $room->room_name }}" 
                                                                    title="Restore Room">
                                                                <i class="fas fa-undo me-1"></i>
                                                                Restore
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm action-btn delete-btn" 
                                                                    data-room-id="{{ $room->id }}" 
                                                                    data-room-name="{{ $room->room_name }}" 
                                                                    title="Delete Room">
                                                                <i class="fas fa-trash me-1"></i>
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-archive"></i>
                                </div>
                                <h3 class="empty-title">No Archived Rooms</h3>
                                <p class="empty-description">There are no archived rooms for this resort.</p>
                                <a href="{{ route('resort.owner.information') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Manage Rooms
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($archivedRooms->hasPages())
                        <div class="pagination-container">
                            {{ $archivedRooms->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Adjust navbar width to match sidebar */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        /* Hide hamburger button by default on larger screens */
        .hamburger-btn {
            display: none !important;
        }

        /* Modern Sidebar Styling - Dark Theme */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .modern-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            pointer-events: none;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .brand-icon-img {
            width: 28px;
            height: 28px;
            filter: brightness(0) invert(1);
        }

        .brand-title {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin: 0;
            font-weight: 400;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav .nav {
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
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

        .sidebar-nav .nav-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-nav .nav-icon-img {
            width: 22px;
            height: 22px;
            filter: brightness(0) invert(1);
        }

        .sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
        }

        /* Custom CSS for icon buttons */
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-icon:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-icon i {
            font-size: 14px;
        }
        
        /* Enhanced tooltip styling */
        .tooltip {
            font-size: 12px;
            font-weight: 500;
        }
        
        .tooltip-inner {
            background-color: #333;
            color: white;
            border-radius: 4px;
            padding: 6px 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* SweetAlert2 Responsive Styles */
        .swal2-popup-responsive {
            font-size: 14px !important;
            max-width: 90% !important;
        }

        .swal2-title-responsive {
            font-size: 18px !important;
            line-height: 1.4 !important;
        }

        .swal2-content-responsive {
            font-size: 14px !important;
            line-height: 1.4 !important;
        }

        .swal2-confirm-responsive {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        .swal2-cancel-responsive {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .swal2-popup-responsive {
                font-size: 12px !important;
                max-width: 95% !important;
                margin: 10px !important;
            }

            .swal2-title-responsive {
                font-size: 16px !important;
            }

            .swal2-content-responsive {
                font-size: 12px !important;
            }

            .swal2-confirm-responsive,
            .swal2-cancel-responsive {
                font-size: 12px !important;
                padding: 6px 12px !important;
            }
        }


        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 55vw !important;
        }

        .mobile-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
        }

        .mobile-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin: 0;
            font-weight: 400;
        }

        .mobile-sidebar-nav {
            padding: 1rem 0;
        }

        .mobile-sidebar-nav .nav {
            padding: 0 1rem;
        }

        .mobile-sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .mobile-sidebar-nav .nav-link {
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

        .mobile-sidebar-nav .nav-link::before {
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

        .mobile-sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .mobile-sidebar-nav .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .mobile-sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                margin-left: 0;
            }
            
            .modern-sidebar {
                display: none !important;
            }
            
            /* Ensure hamburger button is visible */
            .hamburger-btn {
                display: block !important;
            }
            
            .modern-navbar {
                left: 0;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
            }
            
            .modern-mobile-sidebar {
                width: 95vw !important;
            }
            
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border-left: 4px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title-section {
            flex: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .page-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Archive Container */
        .archive-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .archive-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Archive Stats */
        .archive-stats {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: #495057;
        }

        .stat-item i {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Table Container */
        .table-container {
            padding: 0;
        }

        .archive-table {
            margin-bottom: 0;
            border: none;
        }

        .archive-table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
        }

        .archive-table tbody tr {
            border: none;
            transition: all 0.3s ease;
        }

        .archive-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .archive-table tbody td {
            padding: 1.5rem;
            border: none;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }

        /* Room Image */
        .room-image-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .room-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .room-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Room Name */
        .room-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        /* Price */
        .price-amount {
            font-weight: 700;
            color: #28a745;
            font-size: 1.2rem;
        }

        /* Guests */
        .guests-count {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }

        .guests-label {
            color: #6c757d;
            font-size: 0.85rem;
            margin-left: 0.25rem;
        }

        /* Date */
        .archived-date {
            text-align: center;
        }

        .date-main {
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
        }

        .date-time {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .restore-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }

        .restore-btn:hover {
            background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
            color: white;
        }

        .delete-btn {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            border: none;
            color: white;
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #c82333 0%, #e55a00 100%);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 1rem;
        }

        .empty-description {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* Pagination */
        .pagination-container {
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .archive-table thead th {
                padding: 1rem 0.75rem;
                font-size: 0.8rem;
            }

            .archive-table tbody td {
                padding: 1rem 0.75rem;
            }

            .room-image {
                width: 60px;
                height: 60px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }

            .action-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.3rem;
            }

            .archive-table thead th {
                padding: 0.75rem 0.5rem;
                font-size: 0.75rem;
            }

            .archive-table tbody td {
                padding: 0.75rem 0.5rem;
            }

            .room-image {
                width: 50px;
                height: 50px;
            }

            .room-name {
                font-size: 0.9rem;
            }

            .price-amount {
                font-size: 1rem;
            }

            .guests-count {
                font-size: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image error handling
            const roomImages = document.querySelectorAll('.room-image[data-fallback]');
            roomImages.forEach(img => {
                img.addEventListener('error', function() {
                    this.src = this.getAttribute('data-fallback');
                });
            });

            // Restore room button logic
            document.querySelectorAll('.restore-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-room-id');
                    const roomName = this.getAttribute('data-room-name');
                    const roomRow = this.closest('tr');
                    
                    Swal.fire({
                        title: "Restore Room",
                        html: `Are you sure you want to restore <strong>${roomName}</strong>? This will make the room available again.`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, restore it!",
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
                            Swal.fire({
                                title: "Restoring...",
                                text: "Please wait while we restore the room.",
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
                            
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');
                            
                            fetch(`/resort_owner/rooms/restore/${roomId}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    if (roomRow) roomRow.remove();
                                    Swal.fire({
                                        title: "Restored!",
                                        text: "The room has been restored successfully.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                } else {
                                    throw new Error('Restore failed');
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to restore room. Please try again.",
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

            // Delete room button logic
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-room-id');
                    const roomName = this.getAttribute('data-room-name');
                    const roomRow = this.closest('tr');
                    
                    Swal.fire({
                        title: "Permanently Delete Room",
                        html: `
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Warning:</strong> This action cannot be undone. The room and all associated data will be permanently deleted.
                            </div>
                            Are you sure you want to permanently delete <strong>${roomName}</strong>?
                        `,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, delete permanently!",
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
                            Swal.fire({
                                title: "Deleting...",
                                text: "Please wait while we permanently delete the room.",
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
                            
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');
                            
                            fetch(`/resort_owner/rooms/${roomId}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    if (roomRow) roomRow.remove();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The room has been permanently deleted.",
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
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete room. Please try again.",
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
            
            // Initialize Bootstrap tooltips for better tooltip functionality
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    placement: 'top',
                    trigger: 'hover'
                });
            });
        });

        // Offcanvas behavior for mobile sidebar
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
