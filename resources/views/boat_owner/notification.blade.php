<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Boat Management</span>
                        </a>
                    @else
                            <span class="nav-link disabled-link" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="right" 
                              title="Upload your permits first to unlock this feature">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img disabled">
                                </div>
                                <span class="nav-text">Boat Management</span>
                                <span class="nav-badge">Locked</span>
                        </span>
                    @endif
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
                {{-- Icon added here for Boat Owner in mobile sidebar using <img> --}}
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
                        @if(auth()->user()->canAccessMainFeatures())
                                <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                                    <div class="nav-icon">
                                        <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                                    </div>
                                    <span class="nav-text">Boat Management</span>
                            </a>
                        @else
                                <span class="nav-link disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                    <div class="nav-icon">
                                        <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img disabled">
                                    </div>
                                    <span class="nav-text">Boat Management</span>
                                    <span class="nav-badge">Locked</span>
                            </span>
                        @endif
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
        <div class="main-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header mb-4">
                            <h2 class="page-title">Notifications</h2>
                            <p class="page-subtitle">Manage your boat owner notifications</p>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($boatOwnerNotifications->isEmpty())
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-bell-slash"></i>
                                </div>
                                <h4>No Notifications</h4>
                                <p>You don't have any notifications yet.</p>
                            </div>
                        @else
                            {{-- Mark All as Read Button --}}
                            @php
                                $unreadCount = $boatOwnerNotifications->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <div class="notification-header">
                                    <div class="unread-count">
                                        <span class="count-badge">{{ $unreadCount }}</span>
                                        <span class="count-text">unread notification{{ $unreadCount > 1 ? 's' : '' }}</span>
                                    </div>
                                    <form action="{{ route('boat.owner.notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-check-double me-1"></i>Mark All as Read
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="notifications-list">
                                @foreach ($boatOwnerNotifications as $notification)
                                    <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" id="notification-{{ $notification->id }}" data-notification-id="{{ $notification->id }}">
                                        <div class="notification-content">
                                            <div class="notification-header">
                                                <h5 class="notification-title">{{ $notification->message }}</h5>
                                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        @if ($notification->type === 'permit_resubmit')
                                            @php
                                                $docMap = [
                                                    'BIR Permit' => 'bir_permit',
                                                    'DTI Permit' => 'dti_permit',
                                                    'Business Permit' => 'business_permit',
                                                    'Owner Image' => 'owner_image',
                                                ];
                                                $docKey = null;
                                                $docLabel = null;
                                                foreach ($docMap as $label => $key) {
                                                    if (str_contains($notification->message, $label)) { $docKey = $key; $docLabel = $label; break; }
                                                }
                                                $hasWaiting = isset($boatOwnerNotifications) && $boatOwnerNotifications->contains(function($n) use ($docLabel) {
                                                    return $n->type === 'permit_resubmit_waiting' && ($docLabel ? str_contains($n->message, $docLabel) : true);
                                                });
                                                $hasApproved = isset($boatOwnerNotifications) && $boatOwnerNotifications->contains(function($n) use ($docLabel) {
                                                    return $n->type === 'permit_resubmit_approved' && ($docLabel ? str_contains($n->message, $docLabel) : true);
                                                });
                                            @endphp
                                            @if (!$hasWaiting && !$hasApproved)
                                                <form action="{{ route('boat.owner.upload-permits') }}" method="POST" enctype="multipart/form-data" class="mt-2 permit-resubmit-form">
                                                    @csrf
                                                    <div class="input-group input-group-sm align-items-center">
                                                        <input type="file" name="{{ $docKey ?? 'owner_image' }}" class="form-control" required>
                                                        <button type="submit" class="btn btn-primary ms-2 upload-again-btn">Upload again</button>
                                                        <span class="ms-3 small text-muted thanks-msg" style="display:none;">Thank you for your patience.</span>
                                                    </div>
                                                </form>
                                            @endif
                                        @endif

                                        @if ($notification->booking)
                                            <p class="mb-1">Booking ID: <strong>{{ $notification->booking->id }}</strong></p>
                                            @if ($notification->booking->resort)
                                                <p class="mb-1">Resort: <strong>{{ $notification->booking->resort->resort_name }}</strong></p>
                                            @endif
                                            @if ($notification->booking->user)
                                                <p class="mb-1">Tourist: <strong>
                                                    {{ trim($notification->booking->user->first_name . ' ' . $notification->booking->user->middle_name . ' ' . $notification->booking->user->last_name) }}
                                                </strong></p>
                                            @endif
                                            @if ($notification->booking->room)
                                                <p class="mb-1">Room: <strong>{{ $notification->booking->room->room_name }}</strong></p>
                                            @endif
                                            <p class="mb-1">Guests: <strong>{{ $notification->booking->number_of_guests }}</strong></p>
                                            <p class="mb-1">Check-in: <strong>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($notification->booking->check_in_date)->format('M d, Y');
                                                    } catch(\Exception $e) {
                                                        echo $notification->booking->check_in_date;
                                                    }
                                                @endphp
                                            </strong></p>
                                            <p class="mb-1">Tour Type: <strong>{{ ucfirst(str_replace('_', ' ', $notification->booking->tour_type)) }}</strong></p>
                                            @if ($notification->booking->tour_type === 'day_tour')
                                                <p class="mb-1">Departure Time: <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->day_tour_departure_time)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->day_tour_departure_time;
                                                        }
                                                    @endphp
                                                </strong></p>
                                                <p class="mb-1">Pick-up Time: <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->day_tour_time_of_pickup)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->day_tour_time_of_pickup;
                                                        }
                                                    @endphp
                                                </strong></p>
                                            @elseif ($notification->booking->tour_type === 'overnight')
                                                <p class="mb-1">Date & Time of Pick-up: <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->overnight_date_time_of_pickup)->format('M d, Y h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->overnight_date_time_of_pickup;
                                                        }
                                                    @endphp
                                                </strong></p>
                                                @if ($notification->booking->check_out_date)
                                                    <p class="mb-1">Check-out Date: <strong>
                                                        @php
                                                            try {
                                                                echo \Carbon\Carbon::parse($notification->booking->check_out_date)->format('M d, Y');
                                                            } catch(\Exception $e) {
                                                                echo $notification->booking->check_out_date;
                                                            }
                                                        @endphp
                                                    </strong></p>
                                                @endif
                                                <p class="mb-1">Senior Citizens: <strong>{{ $notification->booking->num_senior_citizens }}</strong></p>
                                                <p class="mb-1">PWDs: <strong>{{ $notification->booking->num_pwds }}</strong></p>
                                            @endif
                                            <p class="mb-2 mt-2">Status:
                                                @if ($notification->booking->status === 'approved')
                                                    <span class="status-badge status-approved"><strong>Approved</strong></span>
                                                @elseif ($notification->booking->status === 'rejected')
                                                    <span class="status-badge status-rejected"><strong>Rejected</strong></span>
                                                @elseif ($notification->booking->status === 'cancelled')
                                                    <span class="status-badge status-rejected"><strong>Cancelled</strong></span>
                                                @elseif ($notification->booking->status === 'completed')
                                                    <span class="status-badge status-completed"><strong>Completed</strong></span>
                                                @else
                                                    <span class="status-badge status-pending"><strong>{{ ucfirst($notification->booking->status) }}</strong></span>
                                                @endif
                                            </p>

                                            {{-- Show assigned boat & captain if available --}}
                                            @if ($notification->booking->status === 'approved')
                                                @php
                                                    $assignedBoatName = $notification->booking->assigned_boat ?? ($notification->booking->assignedBoat->boat_name ?? null);
                                                    $captainName = $notification->booking->boat_captain_crew
                                                        ?? ($notification->booking->assignedBoat->captain_name ?? null);
                                                @endphp
                                                @if ($assignedBoatName || $captainName)
                                                    <div class="mt-2">
                                                        @if($assignedBoatName)
                                                            <p class="mb-1">Assigned Boat: <strong>{{ $assignedBoatName }}</strong></p>
                                                        @endif
                                                        <p class="mb-1">Boat Captain: <strong>{{ $captainName ?? 'N/A' }}</strong></p>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                            {{-- Action buttons for ALL notifications --}}
                                            <div class="notification-actions">
                                                @unless ($notification->is_read)
                                                    <form action="{{ route('boat.owner.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline me-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-check me-1"></i>Mark as Read
                                                        </button>
                                                    </form>
                                                @endunless
                                                <button type="button" class="btn btn-outline-danger btn-sm delete-notification-btn" data-notification-id="{{ $notification->id }}">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="pagination-wrapper">
                                {{ $boatOwnerNotifications->links('vendor.pagination.boat-owner') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Permit Resubmit Upload Box if notification is type permit_resubmit --}}
    @if(isset($boatOwnerNotifications))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.list-group-item').forEach(function(item){
                    const heading = item.querySelector('h5.mb-1');
                    if (!heading) return;
                });

            });
        </script>
    @endif



    {{-- Custom CSS for sidebar nav-link hover and focus and icon rotation --}}
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
            background: #2c3e50;
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

        /* Simple Notifications Design */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #adb5bd;
            margin: 0;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .unread-count {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .count-badge {
            background: #e74c3c;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            min-width: 24px;
            text-align: center;
        }

        .count-text {
            color: #6c757d;
            font-weight: 500;
        }

        .notifications-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .notification-item {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .notification-item.unread {
            border-left: 4px solid #007bff;
        }

        .notification-item.read {
            opacity: 0.7;
        }

        .notification-content {
            padding: 1.5rem;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .notification-title {
            color: #2c3e50;
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            line-height: 1.4;
        }

        .notification-time {
            color: #6c757d;
            font-size: 0.875rem;
            white-space: nowrap;
            margin-left: 1rem;
        }

        .notification-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
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

            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .notification-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .notification-header .notification-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .notification-time {
                margin-left: 0;
            }

            .notification-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }

            .notification-actions .btn {
                width: 100%;
            }
        }
        .collapse-icon {
            transition: transform 0.3s ease-in-out;
            min-width: 1em;
        }
        .collapse-icon.rotated {
            transform: rotate(180deg);
        }
        .nav-link.active-parent {
            background-color:rgb(6, 58, 170) !important;
        }
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

        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
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
    </style>

    {{-- Custom JavaScript to handle arrow rotation, offcanvas hiding, and AJAX deletion --}}
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

            // --- NEW: JavaScript for real-time notification count updates ---
            
            // Function to update notification count badges
            function updateNotificationCount() {
                var currentCount = parseInt(document.querySelector('#unreadBadgeDesktop')?.textContent || '0');
                if (currentCount > 0) {
                    currentCount--;
                    // Update both desktop and mobile badges
                    var desktopBadge = document.querySelector('#unreadBadgeDesktop');
                    var mobileBadge = document.querySelector('#unreadBadgeMobile');
                    
                    if (desktopBadge) {
                        if (currentCount > 0) {
                            desktopBadge.textContent = currentCount;
                        } else {
                            desktopBadge.remove();
                        }
                    }
                    
                    if (mobileBadge) {
                        if (currentCount > 0) {
                            mobileBadge.textContent = currentCount;
                        } else {
                            mobileBadge.remove();
                        }
                    }
                }
            }

            // Handle Mark as Read (AJAX + SweetAlert2)
            document.addEventListener('submit', function(e) {
                if (e.target.action && e.target.action.includes('mark-as-read')) {
                    e.preventDefault();
                    
                    fetch(e.target.action, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ title: 'Notification Mark as Read', icon: 'success', draggable: true });
                            }
                            // Update the notification item to show as read
                            var notificationItem = e.target.closest('.list-group-item');
                            if (notificationItem) {
                                notificationItem.classList.remove('border-primary');
                                notificationItem.classList.add('text-muted');
                                
                                // Hide the Mark as Read button
                                var markAsReadBtn = e.target.querySelector('button');
                                if (markAsReadBtn) {
                                    markAsReadBtn.style.display = 'none';
                                }
                            }
                            
                            // Update notification count
                            updateNotificationCount();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                        // Fallback to normal form submission
                        e.target.submit();
                    });
                }
            });

            // --- End NEW JavaScript for notification count updates ---

            // Handle delete notification button clicks
            document.querySelectorAll('.delete-notification-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-notification-id');
                    const notificationItem = this.closest('.list-group-item');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this! This will delete the notification.",
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
                            Swal.fire({
                                title: "Deleting...",
                                text: "Please wait while we delete the notification.",
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
                            
                            fetch(`/boat_owner/notifications/${notificationId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    if (notificationItem) notificationItem.remove();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The notification has been deleted successfully.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                    
                                    // Update notification count
                                    updateNotificationCount();
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting notification:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete notification. Please try again.",
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

            // Handle "Mark All as Read" form submission
            document.addEventListener('submit', function(e) {
                if (e.target.action && e.target.action.includes('mark-all-as-read')) {
                    e.preventDefault();
                    
                    fetch(e.target.action, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ title: 'Notification Mark as Read', icon: 'success', draggable: true });
                            }
                            
                            // Update all notification items to show as read
                            document.querySelectorAll('.list-group-item').forEach(function(item) {
                                item.classList.remove('border-primary');
                                item.classList.add('text-muted');
                                
                                // Hide all Mark as Read buttons
                                var markAsReadBtn = item.querySelector('button[type="submit"]');
                                if (markAsReadBtn) {
                                    markAsReadBtn.style.display = 'none';
                                }
                            });
                            
                            // Update notification count to 0
                            updateNotificationCount();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking all notifications as read:', error);
                        // Fallback to normal form submission
                        e.target.submit();
                    });
                }
            });

            
            // Disable upload button and show thank-you message after resubmit
            document.querySelectorAll('.permit-resubmit-form').forEach(function(form){
                form.addEventListener('submit', function(){
                    const btn = form.querySelector('.upload-again-btn');
                    const thanks = form.querySelector('.thanks-msg');
                    if (btn) {
                        btn.disabled = true;
                        btn.textContent = 'Uploading...';
                    }
                    if (thanks) {
                        thanks.style.display = 'inline';
                    }
                });
            });
        });
    </script>
</x-app-layout>
