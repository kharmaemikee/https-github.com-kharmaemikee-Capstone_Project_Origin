<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
                        <a href="{{ route('resort.owner.information') }}" class="nav-link active" aria-current="page">
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
                        
                        <li class="nav-item"></li>
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
            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-title-section">
                    <h1 class="page-title">
                        <i class="fas fa-hotel me-2"></i>
                        {{ $resort->resort_name }}
                    </h1>
                    <p class="page-subtitle">Manage your resort rooms, cottages, and settings</p>
                </div>
                <div class="page-actions">
                    <a href="{{ route('resort.owner.rooms.create', $resort->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add Room
                    </a>
                </div>
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

            {{-- Resort Information Card --}}
            <div class="resort-details-card">
                <div class="resort-header">
                    <h3 class="resort-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Resort Details
                    </h3>
                </div>
                <div class="resort-content">
                    <div class="resort-image-section">
                        @if ($resort->image_path)
                            <img src="{{ asset($resort->image_path) }}" alt="{{ $resort->resort_name }}" class="resort-image">
                        @else
                            <img src="{{ asset('images/default_resort.png') }}" alt="Default Resort Image" class="resort-image">
                        @endif
                    </div>
                    <div class="resort-info-section">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Location
                                </div>
                                <div class="info-value">{{ $resort->location }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Contact
                                </div>
                                <div class="info-value">{{ $resort->contact_number }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status
                                </div>
                                <div class="info-value">
                                    <span @class([
                                        'status-badge',
                                        'status-open' => ($resort->status ?? '') === 'open',
                                        'status-closed' => ($resort->status ?? '') === 'closed',
                                        'status-maintenance' => ($resort->status ?? '') === 'rehab',
                                        'status-unknown' => !in_array(($resort->status ?? ''), ['open', 'closed', 'rehab']),
                                    ])>
                                        {{ ucfirst($resort->status ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Admin Status
                                </div>
                                <!-- <div class="info-value">
                                    <span class="status-badge status-approved">Approved</span>
                                    <small class="status-note">Automatically approved on registration</small>
                                </div> -->
                            </div>
                            
                            @if ($resort->facebook_page_link)
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fab fa-facebook me-1"></i>
                                    Facebook
                                </div>
                                <div class="info-value">
                                    <a href="{{ $resort->facebook_page_link }}" target="_blank" class="social-link">
                                        <i class="fab fa-facebook me-1"></i>
                                        Visit Page
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="resort-actions">
                            <a href="{{ route('resort.owner.edit', $resort->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>
                                Edit Resort
                            </a>
                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#statusModal">
                                <i class="fas fa-cog me-2"></i>
                                Change Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rooms Management Section --}}
            <div class="management-section">
                <div class="section-header">
                    <div class="section-title">
                        <h3 class="section-title-text">
                            <i class="fas fa-bed me-2"></i>
                            Rooms Management
                        </h3>
                        <div class="section-stats">
                            <span class="stat-item">
                                <i class="fas fa-bed me-1"></i>
                                {{ $rooms->where('accommodation_type','room')->count() }} Rooms
                            </span>
                        </div>
                    </div>
                    <div class="section-actions">
                        <a href="{{ route('resort.owner.rooms.create', ['resort' => $resort->id, 'type' => 'room']) }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>
                            Add Room
                        </a>
                        <a href="{{ route('resort.owner.rooms.archive.index', $resort->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-archive me-2"></i>
                            Archived
                        </a>
                    </div>
                </div>
                <div class="section-content">
                    <div class="rooms-grid">
                        @forelse ($rooms->where('accommodation_type','room') as $room)
                            <div class="room-card">
                                <div class="room-image">
                                    @if ($room->image_path)
                                        <img src="{{ asset($room->image_path) }}" alt="{{ $room->room_name }}" class="room-img">
                                    @else
                                        <img src="{{ asset('images/default_room.png') }}" alt="Default Room Image" class="room-img">
                                    @endif
                                    <div class="room-status-overlay">
                                        @php
                                            $roomStatusClass = '';
                                            $roomStatusText = ucfirst($room->status ?? 'Unknown');
                                            switch ($room->status) {
                                                case 'open':
                                                    $roomStatusClass = 'status-open';
                                                    break;
                                                case 'closed':
                                                    $roomStatusClass = 'status-closed';
                                                    break;
                                                case 'maintenance':
                                                    $roomStatusClass = 'status-maintenance';
                                                    break;
                                                case 'rejected':
                                                    $roomStatusClass = 'status-rejected';
                                                    break;
                                                default:
                                                    $roomStatusClass = 'status-unknown';
                                                    break;
                                            }
                                        @endphp
                                        <span class="status-badge {{ $roomStatusClass }}">
                                            {{ $roomStatusText }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="room-content">
                                    <h4 class="room-name">{{ $room->room_name }}</h4>
                                    
                                    <div class="room-details">
                                        <div class="detail-item">
                                            <i class="fas fa-money-bill-wave me-1"></i>
                                            <span class="detail-label">Price:</span>
                                            <span class="detail-value">₱{{ number_format($room->price_per_night, 2) }}</span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <i class="fas fa-users me-1"></i>
                                            <span class="detail-label">Max Guests:</span>
                                            <span class="detail-value">{{ $room->max_guests }}</span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <i class="fas fa-toggle-on me-1"></i>
                                            <span class="detail-label">Availability:</span>
                                            <span class="availability-badge {{ $room->is_available ? 'available' : 'unavailable' }}">
                                                {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if (($room->status ?? '') === 'maintenance' && $room->rehab_reason)
                                        <div class="maintenance-reason">
                                            <i class="fas fa-tools me-1"></i>
                                            <span class="reason-text">{{ Str::limit($room->rehab_reason, 60) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="room-actions">
                                        <a href="{{ route('resort.owner.rooms.edit', $room->id) }}" class="btn btn-primary btn-sm" title="Edit Room">
                                            <i class="fas fa-edit me-1"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#archiveRoomConfirmationModal" data-room-id="{{ $room->id }}" title="Archive Room">
                                            <i class="fas fa-archive me-1"></i>
                                            Archive
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm view-images-btn" data-bs-toggle="modal" data-bs-target="#viewImagesModal" data-room-id="{{ $room->id }}" title="View Images">
                                            <i class="fas fa-images me-1"></i>
                                            View Images
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <h4 class="empty-title">No Rooms Added Yet</h4>
                                <p class="empty-description">Start by adding your first room to get started with managing your resort.</p>
                                <a href="{{ route('resort.owner.rooms.create', ['resort' => $resort->id, 'type' => 'room']) }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Add Your First Room
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Cottages Management Section --}}
            <div class="management-section">
                <div class="section-header">
                    <div class="section-title">
                        <h3 class="section-title-text">
                            <i class="fas fa-home me-2"></i>
                            Cottages Management
                        </h3>
                        <div class="section-stats">
                            <span class="stat-item">
                                <i class="fas fa-home me-1"></i>
                                {{ $rooms->where('accommodation_type','cottage')->count() }} Cottages
                            </span>
                        </div>
                    </div>
                    <div class="section-actions">
                        <a href="{{ route('resort.owner.rooms.create', ['resort' => $resort->id, 'type' => 'cottage']) }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>
                            Add Cottage
                        </a>
                        <a href="{{ route('resort.owner.rooms.archive.index', $resort->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-archive me-2"></i>
                            Archived
                        </a>
                    </div>
                </div>
                <div class="section-content">
                    <div class="rooms-grid">
                        @forelse ($rooms->where('accommodation_type','cottage') as $room)
                            <div class="room-card">
                                <div class="room-image">
                                    @if ($room->image_path)
                                        <img src="{{ asset($room->image_path) }}" alt="{{ $room->room_name }}" class="room-img">
                                    @else
                                        <img src="{{ asset('images/default_room.png') }}" alt="Default Cottage Image" class="room-img">
                                    @endif
                                    <div class="room-status-overlay">
                                        @php
                                            $roomStatusClass = '';
                                            $roomStatusText = ucfirst($room->status ?? 'Unknown');
                                            switch ($room->status) {
                                                case 'open':
                                                    $roomStatusClass = 'status-open';
                                                    break;
                                                case 'closed':
                                                    $roomStatusClass = 'status-closed';
                                                    break;
                                                case 'maintenance':
                                                    $roomStatusClass = 'status-maintenance';
                                                    break;
                                                case 'rejected':
                                                    $roomStatusClass = 'status-rejected';
                                                    break;
                                                default:
                                                    $roomStatusClass = 'status-unknown';
                                                    break;
                                            }
                                        @endphp
                                        <span class="status-badge {{ $roomStatusClass }}">
                                            {{ $roomStatusText }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="room-content">
                                    <h4 class="room-name">{{ $room->room_name }}</h4>
                                    
                                    <div class="room-details">
                                        <div class="detail-item">
                                            <i class="fas fa-money-bill-wave me-1"></i>
                                            <span class="detail-label">Price/Day:</span>
                                            <span class="detail-value">₱{{ number_format($room->price_per_night, 2) }}</span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <i class="fas fa-users me-1"></i>
                                            <span class="detail-label">Max Guests:</span>
                                            <span class="detail-value">{{ $room->max_guests }}</span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <i class="fas fa-toggle-on me-1"></i>
                                            <span class="detail-label">Availability:</span>
                                            <span class="availability-badge {{ $room->is_available ? 'available' : 'unavailable' }}">
                                                {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if (($room->status ?? '') === 'maintenance' && $room->rehab_reason)
                                        <div class="maintenance-reason">
                                            <i class="fas fa-tools me-1"></i>
                                            <span class="reason-text">{{ Str::limit($room->rehab_reason, 60) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="room-actions">
                                        <a href="{{ route('resort.owner.rooms.edit', $room->id) }}" class="btn btn-primary btn-sm" title="Edit Cottage">
                                            <i class="fas fa-edit me-1"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#archiveRoomConfirmationModal" data-room-id="{{ $room->id }}" title="Archive Cottage">
                                            <i class="fas fa-archive me-1"></i>
                                            Archive
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm view-images-btn" data-bs-toggle="modal" data-bs-target="#viewImagesModal" data-room-id="{{ $room->id }}" title="View Images">
                                            <i class="fas fa-images me-1"></i>
                                            View Images
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <h4 class="empty-title">No Cottages Added Yet</h4>
                                <p class="empty-description">Start by adding your first cottage to expand your resort offerings.</p>
                                <a href="{{ route('resort.owner.rooms.create', ['resort' => $resort->id, 'type' => 'cottage']) }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Add Your First Cottage
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Change Modal --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Resort Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('resort.owner.update_status', $resort->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="open" {{ $resort->status === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ $resort->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="maintenance" {{ $resort->status === 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3" id="rehabReasonDiv" style="display: none;">
                                                            <label for="rehab_reason" class="form-label">Maintenance Reason</label>
                                                            <textarea class="form-control" id="rehab_reason" name="rehab_reason" rows="3" placeholder="Please provide a reason for maintenance...">{{ $resort->rehab_reason }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Archive Room Confirmation Modal --}}
    <div class="modal fade" id="archiveRoomConfirmationModal" tabindex="-1" aria-labelledby="archiveRoomConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archiveRoomConfirmationModalLabel">Confirm Archive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to archive this room? Archived rooms will be hidden from the main view but can be restored later.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="archiveRoomForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning">Confirm Archive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Room Confirmation Modal --}}
    <div class="modal fade" id="deleteRoomConfirmationModal" tabindex="-1" aria-labelledby="deleteRoomConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this room? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteRoomForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- View Images Modal --}}
    <div class="modal fade" id="viewImagesModal" tabindex="-1" aria-labelledby="viewImagesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content modern-image-modal">
                <div class="modal-header">
                    <div class="modal-title-section">
                        <h5 class="modal-title" id="viewImagesModalLabel">
                            <i class="fas fa-images me-2"></i>
                            Room Images
                        </h5>
                        <p class="modal-subtitle">View and manage room images</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewImagesModalBody">
                    <div class="loading-state">
                        <div class="loading-spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <p class="loading-text">Loading images...</p>
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
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        .badge-light-green {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }

        .badge-light-yellow {
            background-color: #fff3cd !important;
            color: #856404 !important;
            border: 1px solid #ffeeba !important;
        }

        .badge-light-red {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }

        /* Set width for mobile offcanvas sidebar */
        #mobileSidebar {
            width: 50vw; /* This makes it half the viewport width */
        }

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease; /* Smooth transition for rotation */
        }

        .collapse-icon.rotated {
            transform: rotate(180deg); /* Rotates the arrow downwards */
        }
    </style>

    <style>
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

            // Status modal logic
            var statusSelect = document.getElementById('status');
            var rehabReasonDiv = document.getElementById('rehabReasonDiv');
            var rehabReasonInput = document.getElementById('rehab_reason');

                    function toggleRehabReason() {
            if (statusSelect.value === 'maintenance') {
                rehabReasonDiv.style.display = 'block';
                rehabReasonInput.required = true;
            } else {
                rehabReasonDiv.style.display = 'none';
                rehabReasonInput.required = false;
            }
        }

            statusSelect.addEventListener('change', toggleRehabReason);
            toggleRehabReason(); // Initial call

            // Delete room modal logic
            var viewImagesModal = document.getElementById('viewImagesModal');
            viewImagesModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var roomId = button.getAttribute('data-room-id');
                var body = document.getElementById('viewImagesModalBody');
                body.innerHTML = '<div class="text-center text-muted">Loading images...</div>';
                window.loadRoomImages = function(url) {
                    fetch(url || ("{{ url('/resort_owner/rooms') }}/" + roomId + "/images"))
                        .then(function(res){ return res.text(); })
                        .then(function(html){ body.innerHTML = html; })
                        .catch(function(){ body.innerHTML = '<div class="text-danger">Failed to load images.</div>'; });
                };
                window.loadRoomImages();
            });

            // Archive room modal logic
            var archiveRoomConfirmationModal = document.getElementById('archiveRoomConfirmationModal');
            if (archiveRoomConfirmationModal) {
                archiveRoomConfirmationModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var roomId = button.getAttribute('data-room-id');
                    var archiveForm = archiveRoomConfirmationModal.querySelector('#archiveRoomForm');
                    archiveForm.action = '/resort_owner/rooms/' + roomId + '/archive';
                });
            }

            // --- New JavaScript for Offcanvas Hiding ---
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
            // --- End New JavaScript ---
            
            // Initialize Bootstrap tooltips for better tooltip functionality
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    placement: 'top',
                    trigger: 'hover'
                });
            });
        });
    </script>

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
            z-index: 1000;
            overflow-y: auto;
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
            gap: 0.75rem;
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
            padding: 1rem 0;
        }

        .sidebar-nav .nav {
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.25rem;
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
            pointer-events: none;
        }

        .disabled-link .nav-icon-img.disabled {
            opacity: 0.5;
        }

        /* Modern Image Modal Styling */
        .modern-image-modal {
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: none;
            overflow: hidden;
        }

        .modern-image-modal .modal-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title-section {
            flex: 1;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .modal-title i {
            color: #3498db;
        }

        .modal-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin: 0.5rem 0 0 0;
        }

        .modern-image-modal .modal-body {
            padding: 2rem;
            background: #f8f9fa;
            min-height: 400px;
        }

        .loading-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            text-align: center;
        }

        .loading-spinner {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 1rem;
        }

        .loading-text {
            color: #6c757d;
            font-size: 1rem;
            margin: 0;
        }

        /* Image Gallery Styles */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .image-item {
            position: relative;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .image-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .image-item:hover .gallery-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-item:hover .image-overlay {
            opacity: 1;
        }

        .image-actions {
            display: flex;
            gap: 0.5rem;
        }

        .image-action-btn {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            color: #2c3e50;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .image-action-btn:hover {
            background: white;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .image-info {
            padding: 1rem;
        }

        .image-title {
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
        }

        .image-meta {
            color: #6c757d;
            font-size: 0.8rem;
            margin: 0;
        }

        /* Empty State */
        .empty-gallery {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
        }

        .empty-gallery-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .empty-gallery-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .empty-gallery-text {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-image-modal .modal-header {
                padding: 1rem 1.5rem;
            }
            
            .modal-title {
                font-size: 1.25rem;
            }
            
            .modern-image-modal .modal-body {
                padding: 1.5rem;
            }
            
            .image-gallery {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
            }
            
            .image-container {
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .modern-image-modal .modal-header {
                padding: 1rem;
            }
            
            .modern-image-modal .modal-body {
                padding: 1rem;
            }
            
            .image-gallery {
                grid-template-columns: 1fr;
                gap: 1rem;
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
            margin-bottom: 0;
        }

        .mobile-brand-icon {
            width: 40px;
            height: 40px;
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
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-sidebar-nav .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .mobile-sidebar-nav .nav-icon-img.disabled {
            opacity: 0.5;
        }

        .mobile-sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            margin-left: auto;
            font-weight: 600;
        }

        .mobile-sidebar-nav .disabled-link {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        .mobile-sidebar-nav .disabled-link:hover {
            transform: none;
            box-shadow: none;
        }

        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border-left: 4px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-title i {
            color: #007bff;
            font-size: 1.8rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        .page-actions .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .page-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Resort Details Card */
        .resort-details-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .resort-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 1.5rem 2rem;
        }

        .resort-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .resort-content {
            display: flex;
            padding: 2rem;
            gap: 2rem;
        }

        .resort-image-section {
            flex: 0 0 300px;
        }

        .resort-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 100%;
        }

        .resort-info-section {
            flex: 1;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .info-label i {
            color: #6c757d;
            margin-right: 0.5rem;
        }

        .info-value {
            color: #2c3e50;
            font-size: 1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-open {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-closed {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .status-maintenance {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .status-approved {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-unknown {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .status-note {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .social-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .social-link:hover {
            color: #0056b3;
        }

        .resort-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .resort-actions .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .resort-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Management Sections */
        .management-section {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .section-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-title-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .section-title-text i {
            color: #007bff;
        }

        .section-stats {
            display: flex;
            gap: 1rem;
        }

        .stat-item {
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #495057;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-actions {
            display: flex;
            gap: 1rem;
        }

        .section-actions .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .section-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .section-content {
            padding: 2rem;
        }

        /* Rooms Grid */
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .room-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .room-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .room-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .room-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .room-card:hover .room-img {
            transform: scale(1.05);
        }

        .room-status-overlay {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .room-content {
            padding: 1.5rem;
        }

        .room-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 1rem 0;
        }

        .room-details {
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .detail-item i {
            color: #6c757d;
            width: 16px;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            margin-right: 0.5rem;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 500;
        }

        .availability-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .availability-badge.available {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .availability-badge.unavailable {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .maintenance-reason {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: #856404;
        }

        .reason-text {
            font-style: italic;
        }

        .room-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .room-actions .btn {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .room-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .view-images-btn {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .view-images-btn:hover {
            background: linear-gradient(135deg, #138496, #117a8b);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
        }

        .view-images-btn i {
            font-size: 0.9rem;
        }

        /* Modern Carousel Styling */
        .modern-carousel {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modern-carousel .carousel-inner {
            border-radius: 12px;
        }

        .modern-carousel .image-container {
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .modern-carousel .gallery-image {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        /* Carousel Control Arrows - High Contrast Black for visibility */
        .modern-carousel-prev,
        .modern-carousel-next {
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.8);
            border: 3px solid #fff;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            z-index: 10;
        }

        .modern-carousel-prev {
            left: 15px;
        }

        .modern-carousel-next {
            right: 15px;
        }

        .modern-carousel-prev:hover,
        .modern-carousel-next:hover {
            background: rgba(0, 0, 0, 0.95);
            transform: translateY(-50%) scale(1.15);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
            border-color: #fff;
        }

        .modern-carousel-prev .carousel-control-prev-icon,
        .modern-carousel-next .carousel-control-next-icon {
            width: 24px;
            height: 24px;
            background-color: #fff;
            border-radius: 3px;
            background-size: 24px 24px;
        }

        .modern-carousel-prev .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='m11.354 1.646-.708.708L5.707 8l5.94 5.646.708.708L15.354 8l-3.646-3.646z'/%3e%3cpath d='m4.646 1.646-.708.708L-1.707 8l5.94 5.646.708.708L7.354 8 4.646 5.354z'/%3e%3c/svg%3e");
        }

        .modern-carousel-next .carousel-control-next-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='m4.646 1.646.708.708L10.293 8l-5.94 5.646-.708.708L.646 8l3.646-3.646z'/%3e%3cpath d='m11.354 1.646.708.708L17.293 8l-5.94 5.646-.708.708L12.646 8l3.646-3.646z'/%3e%3c/svg%3e");
        }

        /* Alternative approach - Use Font Awesome icons for better visibility */
        .modern-carousel-prev::before,
        .modern-carousel-next::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 20px;
            color: #000;
            z-index: 11;
        }

        .modern-carousel-prev::before {
            content: '\f053'; /* fa-chevron-left */
        }

        .modern-carousel-next::before {
            content: '\f054'; /* fa-chevron-right */
        }

        /* Hide the default Bootstrap icons */
        .modern-carousel-prev .carousel-control-prev-icon,
        .modern-carousel-next .carousel-control-next-icon {
            display: none;
        }

        /* Carousel Indicators */
        .modern-carousel-indicators {
            bottom: 20px;
        }

        .modern-carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid white;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .modern-carousel-indicators button.active {
            background: white;
            transform: scale(1.2);
        }

        .modern-carousel-indicators button:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.1);
        }

        /* Amenities Section Styling */
        .amenities-section {
            margin-top: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .amenities-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .amenities-title i {
            color: #f39c12;
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 0.75rem;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            transition: all 0.3s ease;
        }

        .amenity-item:hover {
            background: #e9ecef;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .amenity-icon {
            color: #28a745;
            font-size: 0.9rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .amenity-text {
            color: #495057;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Responsive Design for Carousel and Amenities */
        @media (max-width: 768px) {
            .modern-carousel .image-container {
                height: 300px;
            }
            
            .modern-carousel-prev,
            .modern-carousel-next {
                width: 50px;
                height: 50px;
            }
            
            .modern-carousel-prev::before,
            .modern-carousel-next::before {
                font-size: 18px;
            }
            
            .modern-carousel-prev {
                left: 10px;
            }
            
            .modern-carousel-next {
                right: 10px;
            }
            
            .amenities-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .amenity-item {
                padding: 0.5rem 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .modern-carousel .image-container {
                height: 250px;
            }
            
            .modern-carousel-prev,
            .modern-carousel-next {
                width: 45px;
                height: 45px;
            }
            
            .modern-carousel-prev::before,
            .modern-carousel-next::before {
                font-size: 16px;
            }
            
            .modern-carousel-prev {
                left: 8px;
            }
            
            .modern-carousel-next {
                right: 8px;
            }
            
            .amenities-section {
                padding: 1rem;
            }
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem 2rem;
            background: #f8f9fa;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
        }

        .empty-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: #6c757d;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .empty-state .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            /* Stack resort info earlier to avoid cramped layout around ~861px */
            .resort-content {
                flex-direction: column;
                padding: 1.5rem;
            }

            .resort-image-section {
                flex: none;
                width: 100%;
                max-width: 100%;
            }

            .resort-image {
                width: 100%;
                max-width: 100%;
                height: auto;
                min-height: 220px;
                object-fit: cover;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .resort-actions {
                flex-wrap: wrap;
            }
        }

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
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .resort-content {
                flex-direction: column;
                padding: 1.5rem;
            }
            
            .resort-image-section {
                flex: none;
                width: 100%;
                max-width: 100%;
            }
            
            .resort-image {
                width: 100%;
                max-width: 100%;
                height: auto;
                min-height: 200px;
                object-fit: cover;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
            }
            
            .section-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .rooms-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .room-actions {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .page-header {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .resort-content {
                padding: 1rem;
            }
            
            .resort-image {
                height: 150px;
                min-height: 150px;
            }
            
            .section-header {
                padding: 1rem;
            }
            
            .section-content {
                padding: 1rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }
    </style>
</x-app-layout>