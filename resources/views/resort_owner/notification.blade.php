<x-app-layout>
    <head>
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icon.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="modern-sidebar d-none d-md-block">
            {{-- Sidebar Header --}}
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
            
            {{-- Sidebar Navigation --}}
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
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Resort Management</span>
                            </a>
                        @else
                            <span class="nav-link disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" class="nav-icon-img disabled">
                                </div>
                                <span class="nav-text">Resort Management</span>
                                <span class="nav-badge">Locked</span>
                            </span>
                        @endif
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
                            @if(auth()->user()->canAccessMainFeatures())
                                <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                    <div class="nav-icon">
                                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                    </div>
                                    <span class="nav-text">Resort Management</span>
                                </a>
                            @else
                                <span class="nav-link disabled-link" 
                                      data-bs-toggle="tooltip" 
                                      data-bs-placement="right" 
                                      title="Upload your permits first to unlock this feature">
                                    <div class="nav-icon">
                                        <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" class="nav-icon-img disabled">
                                    </div>
                                    <span class="nav-text">Resort Management</span>
                                    <span class="nav-badge">Locked</span>
                                </span>
                            @endif
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
                                    <span class="nav-badge notification-badge" id="unreadBadgeMobile">{{ $unreadCount }}</span>
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

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header mb-4">
                            <h2 class="page-title">Notifications</h2>
                            <p class="page-subtitle">Manage your resort owner notifications</p>
                        </div>

            {{-- Display Session Messages --}}
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

            {{-- Display Error Messages from Validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0"> {{-- Added mb-0 to remove default bottom margin from ul --}}
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                        @if ($resortOwnerNotifications->isEmpty())
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
                                $unreadCount = $resortOwnerNotifications->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <div class="notification-header">
                                    <div class="unread-count">
                                        <span class="count-badge">{{ $unreadCount }}</span>
                                        <span class="count-text">unread notification{{ $unreadCount > 1 ? 's' : '' }}</span>
                                    </div>
                                    <form action="{{ route('resort.owner.notifications.markAllAsRead') }}" method="POST" class="d-inline markAllAsReadForm">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-check-double me-1"></i>Mark All as Read
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="notifications-list">
                                @foreach ($resortOwnerNotifications as $notification)
                                    <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" data-notification-id="{{ $notification->id }}">
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
                                    $hasWaiting = isset($resortOwnerNotifications) && $resortOwnerNotifications->contains(function($n) use ($docLabel) {
                                        return $n->type === 'permit_resubmit_waiting' && ($docLabel ? str_contains($n->message, $docLabel) : true);
                                    });
                                    $hasApproved = isset($resortOwnerNotifications) && $resortOwnerNotifications->contains(function($n) use ($docLabel) {
                                        return $n->type === 'permit_resubmit_approved' && ($docLabel ? str_contains($n->message, $docLabel) : true);
                                    });
                                @endphp
                                @if (!$hasWaiting && !$hasApproved)
                                    <form action="{{ route('resort.owner.upload-permits') }}" method="POST" enctype="multipart/form-data" class="mt-2 permit-resubmit-form">
                                        @csrf
                                        <div class="input-group input-group-sm align-items-center">
                                            <input type="file" name="{{ $docKey ?? 'owner_image' }}" class="form-control" required>
                                            <button type="submit" class="btn btn-primary ms-2 upload-again-btn">Upload again</button>
                                            <span class="ms-3 small text-muted thanks-msg" style="display:none;">Thank you for your patience.</span>
                                        </div>
                                    </form>
                                @endif
                            @endif

                            {{-- Display booking details for all relevant notification types --}}
                            @if ($notification->booking)
                                <p class="mb-1">Booking ID: <strong>{{ $notification->booking->id }}</strong></p>
                                <hr class="my-2">
                                <h6>Tourist Information:</h6>
                                <p class="mb-1">Name: <strong>{{ $notification->booking->user->first_name ?? 'N/A' }} {{ $notification->booking->user->middle_name ?? '' }} {{ $notification->booking->user->last_name ?? 'N/A' }}</strong></p>
                                {{-- Added fields for address, contact number, gender, and age --}}
                                <p class="mb-1">Address: <strong>{{ $notification->booking->user->address ?? 'N/A' }}</strong></p>
                                <p class="mb-1">Contact No. <strong>{{ $notification->booking->user->phone ?? 'N/A' }}</strong></p>
                                <p class="mb-1">Gender: <strong>{{ ucfirst($notification->booking->user->gender ?? 'N/A') }}</strong></p>
                                <p class="mb-1">Age: <strong>{{ $notification->booking->guest_age ?? 'N/A' }}</strong></p>
                                <hr class="my-2">
                                <h6>Resort & Room Information:</h6>
                                <p class="mb-1">Resort: <strong>{{ $notification->booking->room->resort->resort_name ?? 'N/A' }}</strong></p>
                                <p class="mb-1">Room Type: <strong>{{ $notification->booking->room->room_name ?? 'N/A' }}</strong></p>
                                <p class="mb-1">Room Price: <strong>₱{{ number_format($notification->booking->room->price_per_night ?? 0, 2) }}</strong></p>
                                <hr class="my-2">
                                <h6>Guest Information:</h6>
                                <p class="mb-1">Guest Names: <strong>{{ $notification->booking->guest_name ?? 'N/A' }}</strong></p>
                                <hr class="my-2">
                                <h6>Booking Details:</h6>
                                <p class="mb-1">Booking Type: <strong>{{ ucfirst(str_replace('_', ' ', $notification->booking->tour_type)) }}</strong></p>
                                <p class="mb-1">Check-in Date: <strong>
                                    @php
                                        try {
                                            $checkInDate = \Carbon\Carbon::parse($notification->booking->check_in_date)->format('M d, Y');
                                        } catch (\Exception $e) {
                                            $checkInDate = $notification->booking->check_in_date;
                                        }
                                    @endphp
                                    {{ $checkInDate }}
                                </strong></p>
                                @if ($notification->booking->tour_type === 'overnight' && $notification->booking->check_out_date)
                                    <p class="mb-1">Check-out Date: <strong>
                                        @php
                                            try {
                                                $checkOutDate = \Carbon\Carbon::parse($notification->booking->check_out_date)->format('M d, Y');
                                            } catch (\Exception $e) {
                                                $checkOutDate = $notification->booking->check_out_date;
                                            }
                                        @endphp
                                        {{ $checkOutDate }}
                                    </strong></p>
                                @endif
                                <p class="mb-1">Number of Guests: <strong>{{ $notification->booking->number_of_guests }}</strong></p>
                                @php
                                    $roomPrice = $notification->booking->room ? $notification->booking->room->price_per_night : 0;
                                    $boatPrice = 0;
                                    if ($notification->booking->assignedBoat) {
                                        $boatPrice = $notification->booking->assignedBoat->boat_prices ?? 0;
                                    } elseif ($notification->booking->boat_price) {
                                        $boatPrice = $notification->booking->boat_price;
                                    }
                                    $totalPrice = $roomPrice + $boatPrice;
                                @endphp
                                <p class="mb-1">Room Price: <strong>₱{{ number_format($roomPrice, 2) }}</strong></p>
                                <p class="mb-1">Boat Price: <strong>₱{{ number_format($boatPrice, 2) }}</strong></p>
                                <p class="mb-1">Total Price: <strong>₱{{ number_format($totalPrice, 2) }}</strong></p>

                                @if ($notification->type === 'booking_cancelled')
                                    <p class="mb-1 text-danger fw-bold">Cancelled by: {{ $notification->booking->user->name ?? 'N/A' }}</p>
                                    <p class="mb-1 text-danger fw-bold">Cancellation Reason: {{ $notification->booking->cancellation_reason ?? 'N/A' }}</p>
                                @endif

                                <p class="mb-1">Status:
                                    @if ($notification->booking->status === 'pending')
                                        <span class="status-badge status-badge-pending">Awaiting Your Approval</span>
                                    @elseif ($notification->booking->status === 'approved')
                                        <span class="status-badge status-badge-approved">Approved by You</span>
                                    @elseif ($notification->booking->status === 'rejected')
                                        <span class="status-badge status-badge-rejected">Rejected by You</span>
                                    @elseif ($notification->booking->status === 'cancelled')
                                        <span class="status-badge status-badge-rejected">Cancelled by Tourist</span>
                                    @elseif ($notification->booking->status === 'completed')
                                        <span class="status-badge status-badge-approved">Completed</span>
                                    @elseif ($notification->booking->status === 'updated_pending_approval')
                                        <span class="status-badge status-badge-pending">Updated, Awaiting Re-approval</span>
                                    @endif
                                </p>

                                {{-- Display Boat Details when booking is approved --}}
                                @if ($notification->booking->status === 'approved')
                                    @php
                                        $assignedBoatName = $notification->booking->assigned_boat ?? ($notification->booking->assignedBoat->boat_name ?? null);
                                        $captainName = $notification->booking->boat_captain_crew
                                            ?? ($notification->booking->assignedBoat->captain_name ?? null);
                                        
                                        // If captain name is still N/A or empty, try to get it from the boat
                                        if (empty($captainName) || $captainName === 'N/A') {
                                            $captainName = $notification->booking->assignedBoat->captain_name ?? 'N/A';
                                        }
                                        $captainContact = $notification->booking->boat_contact_number ?? ($notification->booking->assignedBoat->captain_contact ?? null);
                                        $boatPrice = 0;
                                        if ($notification->booking->assignedBoat) {
                                            $boatPrice = $notification->booking->assignedBoat->boat_prices ?? 0;
                                        } elseif ($notification->booking->boat_price) {
                                            $boatPrice = $notification->booking->boat_price;
                                        }
                                    @endphp
                                    @if($assignedBoatName || $captainName || $captainContact)
                                        <hr class="my-2">
                                        <h6>Assigned Boat Information:</h6>
                                        @if($assignedBoatName)
                                            <p class="mb-1">Boat: <strong>{{ $assignedBoatName }}</strong></p>
                                        @endif
                                        @if($boatPrice > 0)
                                            <p class="mb-1">Boat Price: <strong>₱{{ number_format($boatPrice, 2) }}</strong></p>
                                        @endif
                                        <p class="mb-1">Boat Captain: <strong>{{ $captainName ?? 'N/A' }}</strong></p>
                                        @if($captainContact)
                                            <p class="mb-1">Captain Contact: <strong>{{ $captainContact }}</strong></p>
                                        @endif
                                    @endif
                                @elseif ($notification->booking->status === 'pending' || $notification->booking->status === 'updated_pending_approval')
                                    <hr class="my-2">
                                    <h6>Boat Assignment:</h6>
                                    <p class="mb-1 text-muted"><em>Boat will be assigned automatically upon approval</em></p>
                                @endif

                                {{-- Conditional Display for Updated Booking Details --}}
                                @if($notification->type === 'booking_updated' && $notification->data)
                                    @php
                                        $notificationData = json_decode($notification->data, true);
                                        $originalData = $notificationData['original_data'] ?? [];
                                        $newData = $notificationData['new_data'] ?? [];
                                        $changedFieldsSummary = $notificationData['changed_fields_summary'] ?? [];
                                    @endphp

                                    <div class="mt-3 p-3 bg-light border rounded">
                                        <h6 class="mb-2">Booking Update Details:</h6>

                                        @if(!empty($changedFieldsSummary))
                                            <p class="fw-semibold mb-1">Changes Summary:</p>
                                            <ul class="list-unstyled mb-2 small">
                                                @foreach($changedFieldsSummary as $change)
                                                    <li class="text-dark"><i class="bi bi-arrow-right-short me-1"></i>{{ $change }}</li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        {{-- Displaying specific old vs. new values for key fields --}}
                                        <div class="row g-2 small">
                                            @if(isset($originalData['resort_address']) || isset($newData['room']['resort']['address']))
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Resort Address:</strong><br>
                                                        <span class="text-danger">Old: {{ $originalData['resort_address'] ?? 'N/A' }}</span><br>
                                                        <span class="text-success">New: {{ $newData['room']['resort']['address'] ?? 'N/A' }}</span>
                                                    </p>
                                                </div>
                                            @endif
                                            @if(isset($originalData['resort_contact_number']) || isset($newData['room']['resort']['contact_number']))
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Resort Contact No.:</strong><br>
                                                        <span class="text-danger">Old: {{ $originalData['resort_contact_number'] ?? 'N/A' }}</span><br>
                                                        <span class="text-success">New: {{ $newData['room']['resort']['contact_number'] ?? 'N/A' }}</span>
                                                    </p>
                                                </div>
                                            @endif
                                            @if(isset($originalData['room_price']) || isset($newData['room']['price']))
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Room Price:</strong><br>
                                                        <span class="text-danger">Old: ₱{{ number_format($originalData['room_price'] ?? 0, 2) }}</span><br>
                                                        <span class="text-success">New: ₱{{ number_format($newData['room']['price'] ?? 0, 2) }}</span>
                                                    </p>
                                                </div>
                                            @endif
                                            @if(isset($originalData['name_of_resort']) || isset($newData['room']['resort']['resort_name']))
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Resort Name:</strong><br>
                                                        <span class="text-danger">Old: {{ $originalData['name_of_resort'] ?? 'N/A' }}</span><br>
                                                        <span class="text-success">New: {{ $newData['room']['resort']['resort_name'] ?? 'N/A' }}</span>
                                                    </p>
                                                </div>
                                            @endif
                                            {{-- Add more fields here as needed for old vs. new comparison --}}
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-3 d-flex justify-content-end align-items-center">
                                    {{-- The key change is here: include 'updated_pending_approval' for the confirm/reject buttons --}}
                                    @if ($notification->booking->status === 'pending' || $notification->booking->status === 'updated_pending_approval')
                                        <form action="{{ route('resort.owner.bookings.confirm', $notification->booking->id) }}" method="POST" class="d-inline me-2">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
                                        </form>
                                        <form action="{{ route('resort.owner.bookings.reject', $notification->booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @elseif ($notification->booking->status === 'approved')
                                        <form action="{{ route('bookings.complete', $notification->booking->id) }}" method="POST" class="d-inline me-2" onsubmit="return confirm('Are you sure you want to mark this booking as completed?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary btn-sm">Mark as Completed</button>
                                        </form>
                                    @endif
                                    {{-- Action buttons moved to bottom for all notifications --}}
                                </div>
                            @endif {{-- End of @if ($notification->booking) --}}
                            
                                            {{-- Action buttons for ALL notifications (including permit notifications) --}}
                                            <div class="notification-actions">
                                                @unless ($notification->is_read)
                                                    <form action="{{ route('resort.owner.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline me-2">
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
                
                            {{-- Pagination --}}
                            @if ($resortOwnerNotifications->hasPages())
                                <div class="pagination-wrapper">
                                    {{ $resortOwnerNotifications->links('vendor.pagination.resort-owner') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Active parent for collapsed menu */
        .nav-link.text-white.active-parent {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Style for the rotated icon */
        .collapse-icon img {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        /* Custom styles for status badges */
        .status-badge {
            display: inline-block;
            padding: .35em .65em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem; /* Bootstrap's default badge border-radius */
        }

        .status-badge-pending {
            background-color: #fff3cd; /* Light yellow from Bootstrap bg-warning */
            color: #664d03; /* Dark yellow text from Bootstrap text-dark for warning */
            border: 1px solid #ffecb5; /* Slightly darker light yellow border */
        }

        .status-badge-approved {
            background-color: #d1e7dd; /* Light green from Bootstrap bg-success */
            color: #0f5132; /* Dark green text from Bootstrap text-success */
            border: 1px solid #badbcc; /* Slightly darker light green border */
        }

        .status-badge-rejected {
            background-color: #f8d7da; /* Light red from Bootstrap bg-danger */
            color: #842029; /* Dark red text from Bootstrap text-danger */
            border: 1px solid #f5c2c7; /* Slightly darker light red border */
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

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom JavaScript to handle arrow rotation and mobile sidebar behavior --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            collapseToggles.forEach(function(toggle) {
                // Initialize arrow state based on collapse 'show' class
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

                // Add click listener for arrow rotation
                toggle.addEventListener('click', function() {
                    var icon = this.querySelector('.collapse-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // --- JavaScript for Offcanvas Hiding on Desktop ---
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
            // --- End JavaScript for Offcanvas Hiding ---

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
                    console.log('Intercepting markAsRead form submission');
                    e.preventDefault();
                    
                    fetch(e.target.action, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Response received:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data received:', data);
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

            // Handle Mark All as Read form submission
            document.addEventListener('submit', function(e) {
                if (e.target.classList.contains('markAllAsReadForm')) {
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
                            // Show SweetAlert2 success message
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: "All notifications marked as read!",
                                    icon: "success",
                                    draggable: true
                                });
                            } else {
                                console.error('SweetAlert2 is not loaded');
                                alert('All notifications marked as read!');
                            }
                            
                            // Reload the page to update all notifications
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error('Error marking all notifications as read:', error);
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
                            
                            fetch(`/resort_owner/notifications/${notificationId}`, {
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

        .disabled-link {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .disabled-link .nav-icon-img.disabled {
            opacity: 0.5;
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
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

        /* Main Content */
        .main-content {
            padding: 2rem;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
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
            .main-content {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
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
    </style>
</x-app-layout>