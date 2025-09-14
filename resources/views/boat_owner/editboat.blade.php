<x-app-layout>
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
        <div class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Boat: {{ $boat->boat_name }}</h2>
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

            <div class="card p-4">
                <form action="{{ route('boat.update', $boat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Use PUT method for updates --}}

                    <div class="mb-3">
                        <label for="boat_name" class="form-label">Boat Name</label>
                        <input type="text" class="form-control" id="boat_name" name="boat_name" value="{{ old('boat_name', $boat->boat_name) }}" required>
                        @error('boat_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="boat_number" class="form-label">Boat Number</label>
                        <input type="text"
                               class="form-control"
                               id="boat_number"
                               name="boat_number"
                               value="{{ old('boat_number', $boat->boat_number) }}"
                               placeholder="e.g., 09123456789"
                               pattern="[0-9]{11}" {{-- Allows exactly 11 digits --}}
                               maxlength="11" {{-- Restricts input to 11 characters --}}
                               minlength="11" {{-- Requires minimum 11 characters --}}
                               title="Please enter exactly 11 digits for the boat number." {{-- Tooltip for validation message --}}
                               inputmode="numeric" {{-- Optimizes virtual keyboard for numbers --}}
                               oninput="validateBoatNumber(this)"
                               required>
                        <div id="boat_number_error" class="text-danger mt-1" style="display: none;">
                        Invalid Contact Number. It must be exactly 11 digits.
                        </div>
                        @error('boat_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="boat_prices" class="form-label">Price</label>
                        <input type="number" class="form-control" id="boat_prices" name="boat_prices" value="{{ old('boat_prices', $boat->boat_prices) }}" step="0.01" required>
                        @error('boat_prices')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="boat_capacities" class="form-label">Capacity (pax)</label>
                        <input type="number" class="form-control" id="boat_capacities" name="boat_capacities" value="{{ old('boat_capacities', $boat->boat_capacities) }}" required>
                        @error('boat_capacities')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Boat Captain fields --}}
                    <div class="mb-3">
                        <label for="captain_name" class="form-label">Boat Captain Name</label>
                        <input type="text" class="form-control" id="captain_name" name="captain_name" value="{{ old('captain_name', $boat->captain_name ?? '') }}" placeholder="Enter captain full name">
                        @error('captain_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="captain_contact" class="form-label">Boat Captain Contact</label>
                        <input type="text" 
                               class="form-control" 
                               id="captain_contact" 
                               name="captain_contact" 
                               value="{{ old('captain_contact', $boat->captain_contact ?? '') }}" 
                               placeholder="e.g., 09123456789"
                               pattern="[0-9]{11}" 
                               maxlength="11" 
                               minlength="11"
                               title="Please enter exactly 11 digits for the captain contact number." 
                               inputmode="numeric"
                               oninput="validateCaptainContact(this)">
                        <div id="captain_contact_error" class="text-danger mt-1" style="display: none;">
                            Invalid Contact Number. It must be exactly 11 digits.
                        </div>
                        @error('captain_contact')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image_path" class="form-label">Boat Image</label>
                        <input type="file" class="form-control" id="image_path" name="image_path" accept="image/*">
                        @error('image_path')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if ($boat->image_path)
                            <div class="mt-2">
                                <p>Current Image:</p>
                                <img src="{{ asset($boat->image_path) }}" alt="{{ $boat->boat_name }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 5px;">
                            </div>
                        @else
                            <div class="mt-2">
                                <p>No image uploaded yet. Using default image.</p>
                                <img src="{{ asset('images/default_boat.png') }}" alt="Default Boat Image" style="width: 150px; height: 150px; object-fit: cover; border-radius: 5px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </form>

                <hr class="my-4"> {{-- Separator for clarity --}}

                {{-- Section for Boat Status Management --}}
                <h4>Boat Status</h4>
                <p class="text-muted mb-3">Current Status:
                    @php
                        $statusClass = '';
                        switch ($boat->status) {
                            case \App\Models\Boat::STATUS_OPEN:
                            case \App\Models\Boat::STATUS_APPROVED:
                                $statusClass = 'badge-light-success'; // Changed to light badge
                                break;
                            case \App\Models\Boat::STATUS_ASSIGNED:
                                $statusClass = 'badge-light-info'; // Changed to light badge
                                break;
                            case \App\Models\Boat::STATUS_CLOSED:
                            case \App\Models\Boat::STATUS_REJECTED:
                                $statusClass = 'badge-light-danger'; // Changed to light badge
                                break;
                            case \App\Models\Boat::STATUS_REHAB:
                                $statusClass = 'badge-light-warning'; // Changed to light badge
                                break;
                            case \App\Models\Boat::STATUS_PENDING:
                            default:
                                $statusClass = 'badge-light-warning'; // Changed to light badge
                                break;
                        }
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ ucfirst($boat->status ?? 'N/A') }}</span>
                    @if ($boat->status === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                        <br><small class="text-info">(Reason: {{ $boat->rejection_reason }})</small>
                    @elseif ($boat->status === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                        <br><small class="text-danger">(Reason: {{ $boat->rejection_reason }})</small>
                    @elseif ($boat->status === \App\Models\Boat::STATUS_ASSIGNED)
                        <br><small class="text-info">(Currently assigned to a booking - status will automatically change to "Open" when booking period ends)</small>
                    @endif
                </p>

                <div class="d-flex gap-2 mb-3">
                    {{-- Open Button --}}
                    {{-- Disable if already open/approved, or if pending/rejected by admin --}}
                    <form id="status-open-form" action="{{ route('boat.owner.update_status', $boat->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ \App\Models\Boat::STATUS_OPEN }}">
                        <button type="submit" class="btn btn-primary btn-sm" {{ ($boat->status === \App\Models\Boat::STATUS_OPEN || $boat->status === \App\Models\Boat::STATUS_APPROVED || $boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED || $boat->status === \App\Models\Boat::STATUS_ASSIGNED) ? 'disabled' : '' }}>Open</button>
                    </form>

                    {{-- Maintenance Button (now only controlled by custom JS) --}}
                    {{-- Disable if already in maintenance, or if pending/rejected by admin --}}
                    <button type="button" class="btn btn-danger btn-sm" id="rehab-button"
                            {{ ($boat->status === \App\Models\Boat::STATUS_REHAB || $boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED || $boat->status === \App\Models\Boat::STATUS_ASSIGNED) ? 'disabled' : '' }}
                            data-current-status="{{ $boat->status ?? '' }}">
                        Maintenance
                    </button>

                    {{-- Close Button (now triggers modal) --}}
                    {{-- Disable if already closed, or if pending/rejected by admin --}}
                    <button type="button" class="btn btn-danger btn-sm "
                            {{ ($boat->status === \App\Models\Boat::STATUS_CLOSED || $boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED || $boat->status === \App\Models\Boat::STATUS_ASSIGNED) ? 'disabled' : '' }}
                            data-bs-toggle="modal" data-bs-target="#closeConfirmationModal">
                        Close
                    </button>
                </div>

                {{-- NEW: Maintenance Reason Input in its own form (conditionally displayed) --}}
                {{-- This form is typically hidden and only shown via JS after modal confirmation,
                    or if the boat is ALREADY in maintenance status on page load. --}}
                <form id="status-rehab-form" action="{{ route('boat.owner.update_status', $boat->id) }}" method="POST"
                      style="display: {{ ($boat->status === \App\Models\Boat::STATUS_REHAB) ? 'block' : 'none' }};">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ \App\Models\Boat::STATUS_REHAB }}">
                    <div class="mb-3">
                        <label for="rehab_reason" class="form-label">Reason for Maintenance</label>
                        <textarea class="form-control" id="rehab_reason" name="rehab_reason" rows="3">{{ old('rehab_reason', $boat->rejection_reason) }}</textarea>
                        @error('rehab_reason')<div class="text-danger">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">This reason will be displayed on the public page when the boat is under maintenance.</small>
                        <button type="submit" class="btn btn-primary btn-sm mt-2 rounded-pill">Update Maintenance Status & Reason</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Close Confirmation Modal (for owner to close boat) --}}
    <div class="modal fade" id="closeConfirmationModal" tabindex="-1" aria-labelledby="closeConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeConfirmationModalLabel">Confirm Close Boat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this boat as **Closed**? This will make it unavailable for bookings.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <form id="closeStatusForm" method="POST" action="{{ route('boat.owner.update_status', $boat->id) }}" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ \App\Models\Boat::STATUS_CLOSED }}">
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill">Confirm Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Maintenance Confirmation Modal (for owner to put boat in maintenance) --}}
    <div class="modal fade" id="rehabConfirmationModal" tabindex="-1" aria-labelledby="rehabConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rehabConfirmationModalLabel">Confirm Maintenance Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this boat as **Under Maintenance**? You will need to provide a reason for the maintenance.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning btn-sm rounded-pill" id="confirmRehabAndShowReason">Confirm Maintenance</button>
                </div>
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

        /* Styles for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease-in-out;
            min-width: 1em; /* Ensure arrow takes up space */
            display: flex; /* Use flexbox for image alignment if needed */
            align-items: center; /* Center vertically if using an image */
            justify-content: center; /* Center horizontally if using an image */
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }

        /* Styles for active parent link */
        .nav-link.active-parent {
            background-color: #6c757d !important; /* A slightly darker gray for active parent */
        }

        /* Custom Light Background Badges (consistent with explore/showex.blade.php) */
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
            background-color: #f8f9fa !important;
            color: #212529 !important;
            border: 1px solid #dee2e6 !important;
        }
    </style>

    <script>
        // Function to validate boat number input
        function validateBoatNumber(input) {
            const value = input.value;
            const errorDiv = document.getElementById('boat_number_error');
            
            // Remove any non-digit characters
            const digitsOnly = value.replace(/\D/g, '');
            
            // Update the input value to only contain digits
            if (value !== digitsOnly) {
                input.value = digitsOnly;
            }
            
            // Check if the length is exactly 11 digits
            if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        // Function to validate captain contact input
        function validateCaptainContact(input) {
            const value = input.value;
            const errorDiv = document.getElementById('captain_contact_error');
            
            // Remove any non-digit characters
            const digitsOnly = value.replace(/\D/g, '');
            
            // Update the input value to only contain digits
            if (value !== digitsOnly) {
                input.value = digitsOnly;
            }
            
            // Check if the length is exactly 11 digits
            if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

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

            // Global function for image error handling (also used in other views)
            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null; // Prevent infinite looping if default image also fails
                imgElement.src = defaultImagePath;
            };

            const rehabButton = document.getElementById('rehab-button');
            const rehabReasonContainer = document.getElementById('status-rehab-form');
            const rehabReasonInput = document.getElementById('rehab_reason');
            const confirmRehabAndShowReasonButton = document.getElementById('confirmRehabAndShowReason');

            // Function to show/hide maintenance reason container
            function toggleRehabReasonVisibility(forceShow = false) {
                const currentStatusBadge = document.querySelector('p.text-muted .badge');
                // Check for null before accessing textContent
                const isCurrentlyMaintenance = currentStatusBadge && currentStatusBadge.textContent.trim().toLowerCase() === 'maintenance';

                if (forceShow || isCurrentlyMaintenance) {
                    rehabReasonContainer.style.display = 'block';
                    rehabReasonInput.setAttribute('required', 'required');
                    if (forceShow && !rehabReasonInput.value) { // Focus if forced show and input is empty
                        rehabReasonInput.focus();
                    }
                } else {
                    rehabReasonContainer.style.display = 'none';
                    rehabReasonInput.removeAttribute('required');
                    // Only clear the reason if it's not currently being edited for maintenance status
                    // And only if the status actually changed away from maintenance.
                    if (!isCurrentlyMaintenance) {
                        rehabReasonInput.value = '';
                    }
                }
            }

            // Event listener for the Maintenance button click
            if (rehabButton) {
                rehabButton.addEventListener('click', function(event) {
                    const currentStatusBadge = document.querySelector('p.text-muted .badge');
                    const isCurrentlyMaintenance = currentStatusBadge && currentStatusBadge.textContent.trim().toLowerCase() === 'maintenance';

                    if (isCurrentlyMaintenance) {
                        // If already in maintenance, just toggle visibility of reason input directly
                        rehabReasonContainer.style.display = (rehabReasonContainer.style.display === 'none' || rehabReasonContainer.style.display === '') ? 'block' : 'none';
                        rehabReasonInput.setAttribute('required', 'required');
                        if (rehabReasonContainer.style.display === 'block') {
                            rehabReasonInput.focus();
                        } else {
                            rehabReasonInput.removeAttribute('required');
                        }
                    } else {
                        // If not in maintenance, show the confirmation modal
                        var rehabModal = new bootstrap.Modal(document.getElementById('rehabConfirmationModal'));
                        rehabModal.show();
                    }
                });
            }

            // Event listener for "Confirm Rehab" button inside the Rehab modal
            if (confirmRehabAndShowReasonButton) {
                confirmRehabAndShowReasonButton.addEventListener('click', function() {
                    var rehabModal = bootstrap.Modal.getInstance(document.getElementById('rehabConfirmationModal'));
                    if (rehabModal) {
                        rehabModal.hide(); // Hide the modal
                    }
                    toggleRehabReasonVisibility(true); // Force show rehab reason input
                });
            }

            // Add click listener to 'Open' and 'Close' forms to hide rehab reason container if visible
            // And to potentially clear the reason if status is no longer rehab.
            const statusForms = document.querySelectorAll('.status-form'); // Get all status forms
            statusForms.forEach(form => {
                form.addEventListener('submit', function() {
                    const statusInput = this.querySelector('input[name="status"]');
                    if (statusInput && statusInput.value !== '{{ \App\Models\Boat::STATUS_REHAB }}') {
                        // If changing to 'open' or 'closed', hide and clear rehab reason input
                        toggleRehabReasonVisibility(false);
                    }
                });
            });

            // Initialize visibility on page load based on current boat status
            toggleRehabReasonVisibility();

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