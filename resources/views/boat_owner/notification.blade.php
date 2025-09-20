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
                            <div class="notification-header">
                                <div class="unread-count">
                                    <span class="count-badge">{{ $unreadCount }}</span>
                                    <span class="count-text">{{ $unreadCount }} unread</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('boat.owner.notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-check-double me-1"></i>Mark All as Read
                                        </button>
                                    </form>
                                    <button type="button" id="deleteAllBoatNotificationsBtn" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i>Delete All
                                    </button>
                                </div>
                            </div>
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
                                            <p class="mb-1">Number of Guests: <strong>{{ $notification->booking->number_of_guests }}</strong></p>
                                            
                                            {{-- Guest Information Table --}}
                                            @if($notification->booking->guest_name)
                                                <hr class="my-2">
                                                <h6>Guest Information:</h6>
                                                @php
                                                    // Parse guest information from the concatenated string
                                                    $guestNames = explode(';', $notification->booking->guest_name ?? '');
                                                    $guestAges = [];
                                                    $guestNationalities = [];
                                                    
                                                    // Also check separate nationality field
                                                    $separateNationalities = explode(';', $notification->booking->guest_nationality ?? '');
                                                    
                                                    // Extract ages and nationalities from the guest names
                                                    foreach ($guestNames as $index => $guestInfo) {
                                                        $guestInfo = trim($guestInfo);
                                                        if (empty($guestInfo)) continue;
                                                        
                                                        // Look for age pattern (number in parentheses)
                                                        if (preg_match('/\((\d+)\)/', $guestInfo, $ageMatches)) {
                                                            $guestAges[$index] = $ageMatches[1];
                                                            $guestInfo = preg_replace('/\s*\(\d+\)/', '', $guestInfo);
                                                        }
                                                        
                                                        // Look for nationality pattern (after dash)
                                                        if (preg_match('/\s*-\s*(.+)$/', $guestInfo, $nationalityMatches)) {
                                                            $guestNationalities[$index] = trim($nationalityMatches[1]);
                                                            $guestInfo = preg_replace('/\s*-\s*.+$/', '', $guestInfo);
                                                        }
                                                        
                                                        // If no nationality found in name, check separate nationality field
                                                        if (!isset($guestNationalities[$index]) && isset($separateNationalities[$index])) {
                                                            $nationality = trim($separateNationalities[$index]);
                                                            if (!empty($nationality)) {
                                                                $guestNationalities[$index] = $nationality;
                                                            }
                                                        }
                                                        
                                                        // For the primary guest (index 0), also check user nationality as fallback
                                                        if ($index === 0 && !isset($guestNationalities[$index])) {
                                                            $userNationality = $notification->booking->user->nationality ?? null;
                                                            if (!empty($userNationality)) {
                                                                $guestNationalities[$index] = $userNationality;
                                                            }
                                                        }
                                                        
                                                        $guestNames[$index] = trim($guestInfo);
                                                    }
                                                @endphp
                                                
                                                <div class="guest-info-table">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Guest Name</th>
                                                                <th>Age</th>
                                                                <th>Nationality</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($guestNames as $index => $name)
                                                                @if(!empty(trim($name)))
                                                                    <tr>
                                                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                                                        <td class="fw-semibold">{{ $name }}</td>
                                                                        <td>
                                                                            <span class="badge bg-info">
                                                                                {{ $guestAges[$index] ?? 'N/A' }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            @if(isset($guestNationalities[$index]) && !empty($guestNationalities[$index]))
                                                                                <span class="badge bg-secondary">
                                                                                    {{ $guestNationalities[$index] }}
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-warning text-dark">
                                                                                    <i class="fas fa-question-circle me-1"></i>Not Specified
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
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
                                                <p class="mb-1">Departure (to resort): <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->day_tour_departure_time)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->day_tour_departure_time;
                                                        }
                                                    @endphp
                                                </strong></p>
                                                <p class="mb-1">Pick-up (leaving): <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->day_tour_time_of_pickup)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->day_tour_time_of_pickup;
                                                        }
                                                    @endphp
                                                </strong></p>
                                            @elseif ($notification->booking->tour_type === 'overnight')
                                                <p class="mb-1">Departure (to resort): <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->overnight_departure_time)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->overnight_departure_time;
                                                        }
                                                    @endphp
                                                </strong></p>
                                                <p class="mb-1">Pick-up (leaving): <strong>
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
                                                    $assignedBoatModel = $notification->booking->assignedBoat;
                                                    $assignedBoatName = $notification->booking->assigned_boat ?? ($assignedBoatModel->boat_name ?? null);
                                                    $captainName = $notification->booking->boat_captain_crew
                                                        ?? ($assignedBoatModel->captain_name ?? null);
                                                    $boatNumber = $assignedBoatModel->boat_number ?? null;
                                                    $boatLength = $assignedBoatModel->boat_length ?? null;
                                                @endphp
                                                @if ($assignedBoatName || $captainName)
                                                    <div class="mt-2">
                                                        @if($assignedBoatName)
                                                            <p class="mb-1">Assigned Boat: <strong>{{ $assignedBoatName }}</strong></p>
                                                        @endif
                                                        @if($boatNumber)
                                                            <p class="mb-1">Boat No: <strong>{{ $boatNumber }}</strong></p>
                                                        @endif
                                                        @if($boatLength)
                                                            <p class="mb-1">Boat Length: <strong>{{ $boatLength }}</strong></p>
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

        /* Modern Sidebar Styling - Dark Theme */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
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

        .brand-text {
            flex: 1;
        }

        .brand-title {
            color: white;
            font-size: 1.25rem;
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
            transition: all 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .nav-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        .notification-badge {
            background: linear-gradient(135deg, #ff6b6b, #ff4757);
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
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 85vw !important;
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
            padding: 2rem;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
        }

        /* Simple Notifications Design */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .page-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin: 0.75rem 0 0 0;
            font-weight: 400;
            position: relative;
            z-index: 1;
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
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .notification-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .unread-count {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .count-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            font-size: 1rem;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
            border-radius: 25px;
            min-width: 32px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            animation: pulse 2s infinite;
        }

        .count-text {
            color: #4a5568;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .notifications-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .notification-item {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .notification-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border-color: rgba(0, 123, 255, 0.2);
        }

        .notification-item.unread {
            border-left: 5px solid #007bff;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #0056b3);
        }

        .notification-item.read {
            opacity: 0.8;
            background: #f8f9fa;
        }

        .notification-content {
            padding: 2rem;
            position: relative;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f4;
        }

        .notification-title {
            color: #1a202c;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.4;
            letter-spacing: -0.025em;
        }

        .notification-time {
            color: #718096;
            font-size: 0.875rem;
            white-space: nowrap;
            margin-left: 1rem;
            background: #f7fafc;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .notification-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #f1f3f4;
        }

        /* Button Enhancements */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ff5252 0%, #e53e3e 100%);
        }

        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
        }

        .btn-outline-danger {
            border: 2px solid #ff6b6b;
            color: #ff6b6b;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: #ff6b6b;
            color: white;
        }

        /* Guest Information Table Styling */
        .guest-info-table {
            margin: 1rem 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .guest-info-table .table {
            margin-bottom: 0;
            border: none;
        }

        .guest-info-table .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .guest-info-table .table tbody tr {
            transition: all 0.3s ease;
        }

        .guest-info-table .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }

        .guest-info-table .table tbody td {
            padding: 1rem;
            border: none;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }

        .guest-info-table .table tbody tr:last-child td {
            border-bottom: none;
        }

        .guest-info-table .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .guest-info-table .badge.bg-info {
            background: linear-gradient(135deg, #17a2b8, #138496) !important;
        }

        .guest-info-table .badge.bg-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268) !important;
        }

        /* Section Headers */
        .notification-content h6 {
            color: #2d3748;
            font-size: 1rem;
            font-weight: 700;
            margin: 1.5rem 0 1rem 0;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .notification-content h6:first-of-type {
            margin-top: 0;
        }

        /* Information paragraphs */
        .notification-content p {
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f7fafc;
        }

        .notification-content p:last-child {
            border-bottom: none;
        }

        .notification-content strong {
            color: #2d3748;
            font-weight: 600;
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
            
            // Function to update notification count badges (decrement by 1)
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

            // Function to clear notification count badges (set to 0)
            function clearNotificationCount() {
                const desktopBadge = document.querySelector('#unreadBadgeDesktop');
                const mobileBadge = document.querySelector('#unreadBadgeMobile');
                if (desktopBadge) desktopBadge.remove();
                if (mobileBadge) mobileBadge.remove();
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

            // Handle Delete All notifications (Boat Owner)
            const deleteAllBoatBtn = document.getElementById('deleteAllBoatNotificationsBtn');
            if (deleteAllBoatBtn) {
                deleteAllBoatBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: "Delete all notifications?",
                        text: "This will permanently delete all your notifications.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete all",
                        cancelButtonText: "Cancel",
                        customClass: { popup: 'swal2-popup-responsive', title: 'swal2-title-responsive', content: 'swal2-content-responsive', confirmButton: 'swal2-confirm-responsive', cancelButton: 'swal2-cancel-responsive' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({ title: "Deleting...", allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading(), customClass: { popup: 'swal2-popup-responsive' } });
                            fetch(`{{ route('boat.owner.notifications.destroyAll') }}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(r => r.json()).then(data => {
                                if (data.success) {
                                    document.querySelectorAll('.notification-item').forEach(el => el.remove());
                                    const desktopBadge = document.querySelector('#unreadBadgeDesktop');
                                    const mobileBadge = document.querySelector('#unreadBadgeMobile');
                                    if (desktopBadge) desktopBadge.remove();
                                    if (mobileBadge) mobileBadge.remove();
                                    Swal.fire({ title: "Deleted!", text: "All notifications deleted.", icon: "success" });
                                } else { throw new Error('Failed'); }
                            }).catch(() => {
                                Swal.fire({ title: "Error", text: "Failed to delete all notifications.", icon: "error" });
                            });
                        }
                    });
                });
            }

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
                            
                            // Update unread counters in header to 0
                            const countBadge = document.querySelector('.count-badge');
                            const countText = document.querySelector('.count-text');
                            if (countBadge) countBadge.textContent = '0';
                            if (countText) countText.textContent = '0 unread';

                            // Remove sidebar badges
                            clearNotificationCount();
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
