<x-app-layout>
    <head>
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icon.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                {{ Auth::user()->username }}
            </h4>
            <ul class="nav flex-column mt-3">
                {{-- Dashboard Nav Item --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.dashboard') }}"
                       class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>

                {{-- Resort Information Nav Item --}}
                <li class="nav-item mt-2">
                    @if(auth()->user()->canAccessMainFeatures())
                        <a href="{{ route('resort.owner.information') }}"
                           class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Information
                        </a>
                    @else
                        <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="right" 
                              title="Upload your permits first to unlock this feature">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                            Resort Information
                            <span class="badge bg-warning ms-2">Locked</span>
                        </span>
                    @endif
                </li>

                {{-- Verified Nav Item --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.verified') }}"
                       class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
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
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    {{ Auth::user()->username }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    {{-- Dashboard Nav Item (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.dashboard') }}"
                           class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>

                    {{-- Resort Information Nav Item (Mobile) --}}
                    <li class="nav-item mt-2">
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('resort.owner.information') }}"
                               class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Resort Information
                            </a>
                        @else
                            <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                                Resort Information
                                <span class="badge bg-warning ms-2">Locked</span>
                            </span>
                        @endif
                    </li>

                    {{-- Verified Nav Item (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.verified') }}"
                           class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
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
            <h2 class="mb-4">Resort Owner Notifications</h2>

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
                <div class="alert alert-info">You have no notifications.</div>
            @else
                <div class="list-group">
                    @foreach ($resortOwnerNotifications as $notification)
                        <div class="list-group-item list-group-item-action {{ $notification->is_read ? 'text-muted' : 'border-primary' }}" data-notification-id="{{ $notification->id }}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h5 class="mb-1">{{ $notification->message }}</h5>
                                <small class="text-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
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
                            <div class="mt-3 d-flex justify-content-end align-items-center">
                                @unless ($notification->is_read)
                                    <form action="{{ route('resort.owner.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline me-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Mark as Read</button>
                                    </form>
                                @endunless

                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                @if ($resortOwnerNotifications->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $resortOwnerNotifications->links('vendor.pagination.resort-owner') }}
                    </div>
                @endif
            @endif
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
    </style>

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

            // Handle Mark as Read form submissions
            document.addEventListener('submit', function(e) {
                if (e.target.action && e.target.action.includes('markAsRead')) {
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