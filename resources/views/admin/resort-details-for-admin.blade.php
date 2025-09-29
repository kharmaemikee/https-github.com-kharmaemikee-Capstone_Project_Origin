<x-app-layout>
    {{-- Apply min-vh-100 to the main flex container and background gradient --}}
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="modern-sidebar d-none d-md-block">
            {{-- Sidebar Header --}}
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Admin Menu</h4>
                        <p class="brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
            </div>
            
            {{-- Sidebar Navigation --}}
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.resort') }}" class="nav-link {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Resort Management</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.boat') }}" class="nav-link {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Boat Management</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <button class="nav-link w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                            <div class="nav-icon">
                                <img src="{{ asset('images/users.png') }}" alt="Users Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Users</span>
                        <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                    </button>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapse">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.resorts') }}" class="nav-link {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.boats') }}" class="nav-link {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.tourists') }}" class="nav-link {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.documentation') }}" class="nav-link {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
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
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title" id="mobileSidebarLabel">Admin Menu</h5>
                        <p class="mobile-brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mobile-sidebar-nav">
                <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.resort') }}" class="nav-link {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Resort Management</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.boat') }}" class="nav-link {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Boat Management</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <button class="nav-link w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapseMobile" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapseMobile">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/users.png') }}" alt="Users Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Users</span>
                            <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                        </button>
                        <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapseMobile">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                        <a href="{{ route('admin.users.resorts') }}" class="nav-link {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                                </li>
                                <li class="nav-item">
                                        <a href="{{ route('admin.users.boats') }}" class="nav-link {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                                </li>
                                <li class="nav-item">
                                        <a href="{{ route('admin.users.tourists') }}" class="nav-link {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.documentation') }}" class="nav-link {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
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
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title mb-1">Resort Details</h1>
                        <p class="page-subtitle mb-0">View and manage resort information</p>
                    </div>
                    <!-- <div class="page-actions">
                        <a href="{{ route('admin.resort') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Resorts
                        </a>
                    </div> -->
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

            {{-- Resort Information Section --}}
            <div class="resort-info-card mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Resort Information</h4>
                            <p class="text-muted mb-0">{{ $resort->resort_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <div class="row">
                        {{-- Resort Image --}}
                        <div class="col-lg-4 mb-4">
                            <div class="resort-image-container">
                        @if ($resort->image_path)
                            <img src="{{ asset($resort->image_path) }}"
                                alt="{{ $resort->resort_name }}"
                                        class="resort-image">
                        @else
                            <img src="{{ asset('images/default_resort.png') }}"
                                alt="Default Resort Image"
                                        class="resort-image">
                        @endif
                                <div class="image-overlay">
                                    <i class="fas fa-camera"></i>
                    </div>
                            </div>
                        </div>
                        
                        {{-- Resort Details --}}
                        <div class="col-lg-8">
                            <div class="resort-details">
                                {{-- Basic Information --}}
                                <div class="info-section mb-4">
                                    <h5 class="section-title">Basic Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-building me-2"></i>Resort Name
                                                </div>
                                                <div class="info-value">{{ $resort->resort_name }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-map-marker-alt me-2"></i>Location
                                                </div>
                                                <div class="info-value">{{ $resort->location }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-phone me-2"></i>Contact Number
                                                </div>
                                                <div class="info-value">{{ $resort->contact_number }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status Information --}}
                                <div class="info-section mb-4">
                                    <h5 class="section-title">Status Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="status-item">
                                                <div class="status-label">Owner Status</div>
                            @php
                                $ownerStatusClass = '';
                                switch ($resort->status) {
                                                        case 'open': $ownerStatusClass = 'status-success'; break;
                                                        case 'closed': $ownerStatusClass = 'status-danger'; break;
                                                        case 'rehab': $ownerStatusClass = 'status-warning'; break;
                                                        default: $ownerStatusClass = 'status-secondary'; break;
                                }
                            @endphp
                                                <div class="status-badge {{ $ownerStatusClass }}">
                                                    <i class="fas fa-circle me-1"></i>{{ ucfirst($resort->status ?? 'N/A') }}
                                                </div>
                            @if ($resort->status === 'rehab' && $resort->rehab_reason)
                                                    <div class="status-note">{{ $resort->rehab_reason }}</div>
                            @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="status-item">
                                                <div class="status-label">Admin Status</div>
                            @php
                                $adminStatusClass = '';
                                switch ($resort->admin_status) {
                                                        case 'pending': $adminStatusClass = 'status-info'; break;
                                                        case 'approved': $adminStatusClass = 'status-success'; break;
                                                        case 'rejected': $adminStatusClass = 'status-danger'; break;
                                                        default: $adminStatusClass = 'status-secondary'; break;
                                }
                            @endphp
                                                <div class="status-badge {{ $adminStatusClass }}">
                                                    <i class="fas fa-circle me-1"></i>{{ ucfirst($resort->admin_status ?? 'N/A') }}
                                                </div>
                            @if (($resort->admin_status ?? '') === 'rejected' && $resort->rejection_reason)
                                                    <div class="status-note text-danger">{{ $resort->rejection_reason }}</div>
                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                        @if (($resort->admin_status ?? '') === 'pending')
                                    <div class="action-section">
                                        <h5 class="section-title">Admin Actions</h5>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-success btn-action"
                                        data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                        data-item-id="{{ $resort->id }}"
                                        data-item-name="{{ $resort->resort_name }}"
                                        data-action-type="approve"
                                        data-target-type="resort">
                                                <i class="fas fa-check me-2"></i>Approve Resort
                                </button>
                                            <button type="button" class="btn btn-danger btn-action"
                                        data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                        data-item-id="{{ $resort->id }}"
                                        data-item-name="{{ $resort->resort_name }}"
                                        data-action-type="reject"
                                        data-target-type="resort">
                                                <i class="fas fa-times me-2"></i>Reject Resort
                                </button>
                                        </div>
                            </div>
                        @else
                                    <div class="status-message">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            This resort is currently <strong>{{ ucfirst($resort->admin_status) }}</strong>.
                                        </div>
                                    </div>
                        @endif
                    </div>
                </div>
            </div>
                </div>
            </div>

            {{-- Rooms Section --}}
            <div class="rooms-section">
                <div class="section-header mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="section-icon me-3">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div>
                                <h3 class="section-title mb-0">Rooms & Accommodations</h3>
                                <p class="section-subtitle mb-0">Manage room availability and status</p>
                            </div>
                        </div>
                        <div class="room-count-badge">
                            <span class="badge bg-primary fs-6">{{ $resort->rooms->count() }} rooms</span>
                        </div>
                    </div>
                </div>

            @forelse ($resort->rooms->sortByDesc('created_at') as $room)
                    <div class="room-card mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    {{-- Room Image --}}
                                    <div class="col-lg-3 mb-3">
                                        <div class="room-image-container">
                            @if ($room->image_path)
                                <img src="{{ asset($room->image_path) }}"
                                    alt="{{ $room->room_name }}"
                                                    class="room-image">
                            @else
                                <img src="{{ asset('images/default_room.png') }}"
                                    alt="Default Room Image"
                                                    class="room-image">
                            @endif
                                            <div class="room-image-overlay">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#roomImagesModal" data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                        </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Room Details --}}
                                    <div class="col-lg-6">
                                        <div class="room-details">
                                            <h5 class="room-name">{{ $room->room_name }}</h5>
                                            
                                            {{-- Enhanced Room Description Section --}}
                                            <div class="room-description-section mb-3">
                                                <div class="description-header">
                                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                                    <span class="description-label">Room Description</span>
                                                </div>
                                                <div class="room-description-content">
                                                    @if($room->description && trim($room->description) !== '')
                                                        <div class="room-description">
                                                            @php
                                                                // Split description by periods and create bullet points
                                                                $descriptionItems = array_filter(array_map('trim', explode('.', $room->description)));
                                                            @endphp
                                                            @if(count($descriptionItems) > 1)
                                                                <ul class="description-list">
                                                                    @foreach($descriptionItems as $item)
                                                                        @if(!empty($item))
                                                                            <li>{{ $item }}.</li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p>{{ $room->description }}</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p class="room-description text-muted fst-italic">No description provided for this room.</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="room-info-grid">
                                                <div class="info-item">
                                                    <div class="info-label">
                                                        <i class="fas fa-peso-sign me-2"></i>Price per stay
                                                    </div>
                                                    <div class="info-value">₱{{ number_format($room->price_per_night, 2) }}</div>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <div class="info-label">
                                                        <i class="fas fa-users me-2"></i>Max Guests
                                                    </div>
                                                    <div class="info-value">{{ $room->max_guests }} guests</div>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <div class="info-label">
                                                        <i class="fas fa-calendar-check me-2"></i>Availability
                                                    </div>
                                                    <div class="availability-badge {{ $room->is_available ? 'available' : 'unavailable' }}">
                                                        <i class="fas fa-circle me-1"></i>
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Inline thumbnails of uploaded images --}}
                                            @php $images = $room->images ?? collect(); @endphp
                                            @if($images->count())
                                                <div class="mt-2 d-flex flex-wrap gap-2">
                                                    @foreach($images as $img)
                                                        <img src="{{ asset($img->image_path) }}" alt="{{ $room->room_name }} image" style="width:72px; height:72px; object-fit:cover; border-radius:6px; border:1px solid #e9ecef;" />
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Status Information --}}
                                            <div class="room-status-section mt-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="status-item">
                                                            <div class="status-label">Owner Status</div>
                                @php
                                    $roomOwnerStatusClass = '';
                                    switch ($room->status) {
                                                                    case 'open': $roomOwnerStatusClass = 'status-success'; break;
                                                                    case 'closed': $roomOwnerStatusClass = 'status-danger'; break;
                                                                    case 'rehab': $roomOwnerStatusClass = 'status-warning'; break;
                                                                    default: $roomOwnerStatusClass = 'status-secondary'; break;
                                    }
                                @endphp
                                                            <div class="status-badge {{ $roomOwnerStatusClass }}">
                                                                <i class="fas fa-circle me-1"></i>{{ ucfirst($room->status ?? 'N/A') }}
                                                            </div>
                                @if (($room->status ?? '') === 'rehab' && $room->rehab_reason)
                                                                <div class="status-note">{{ Str::limit($room->rehab_reason, 50) }}</div>
                                @endif
                                                        </div>
                                                    </div>
                                                    {{-- Admin Status removed: Rooms are auto-approved upon creation --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Action Buttons --}}
                                    <div class="col-lg-3">
                                        <div class="room-actions">
                            {{-- Room approval actions removed --}}
                                </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            @empty
                    <div class="empty-state">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="empty-icon mb-3">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <h5 class="empty-title">No Rooms Available</h5>
                                <p class="empty-description">This resort doesn't have any rooms registered yet.</p>
                            </div>
                        </div>
                    </div>
            @endforelse
            </div>
        </div>
    </div>

    {{-- Unified Admin Action Confirmation Modal (for both resort and room actions) --}}
    <div class="modal fade" id="adminActionModal" tabindex="-1" aria-labelledby="adminActionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <form id="adminActionForm" method="POST">
                    @csrf
                    @method('PATCH') {{-- Both approve and reject will use PATCH --}}
                    <div class="modal-header modern-modal-header">
                        <div class="modal-title-section">
                            <div class="modal-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        <h5 class="modal-title" id="adminActionModalLabel">Confirm Action</h5>
                    </div>
                        <button type="button" class="btn-close modern-close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    <div class="modal-body modern-modal-body">
                        <div class="action-message">
                            <p id="modalActionMessage" class="mb-3"></p>
                    </div>
                        <div id="rejectionReasonGroup" class="rejection-reason-section" style="display: none;">
                            <label for="rejection_reason" class="form-label modern-label">
                                <i class="fas fa-edit me-2"></i>Reason for Rejection
                            </label>
                            <textarea class="form-control modern-textarea" id="rejection_reason" name="rejection_reason" rows="3" placeholder="Please provide a detailed reason for rejection..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="btn btn-outline-secondary modern-btn" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" id="confirmActionButton" class="btn modern-btn">
                            <i class="fas fa-check me-2"></i>Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Room Images Modal --}}
    <div class="modal fade" id="roomImagesModal" tabindex="-1" aria-labelledby="roomImagesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="modal-title-section">
                        <div class="modal-icon">
                            <i class="fas fa-images"></i>
                        </div>
                    <h5 class="modal-title" id="roomImagesModalLabel">Room Images</h5>
                </div>
                    <button type="button" class="btn-close modern-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div id="roomImagesEmpty" class="empty-images-state" style="display:none;">
                        <div class="empty-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <p class="empty-text">No additional images uploaded for this room.</p>
                    </div>
                    <div id="roomImagesCarousel" class="carousel slide modern-carousel" data-bs-ride="false" style="display:none;">
                        <div class="carousel-inner" id="roomImagesCarouselInner"></div>
                        <button class="carousel-control-prev modern-carousel-control" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next modern-carousel-control" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-outline-secondary modern-btn" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern Modal Design */
        .modern-modal {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .modern-modal-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            padding: 1.5rem;
            position: relative;
        }

        .modal-title-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .modern-modal-header .modal-title {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .modern-close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 8px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .modern-close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .modern-close-btn i {
            font-size: 1rem;
            color: white;
        }

        .modern-modal-body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .action-message p {
            font-size: 1rem;
            color: #495057;
            margin: 0;
            line-height: 1.6;
        }

        .rejection-reason-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            margin-top: 1rem;
        }

        .modern-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .modern-textarea {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            resize: vertical;
        }

        .modern-textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .modern-modal-footer {
            background: white;
            border: none;
            padding: 1.5rem 2rem;
            gap: 1rem;
        }

        .modern-btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Room Images Modal Specific Styles */
        .empty-images-state {
            text-align: center;
            padding: 3rem 2rem;
        }

        .empty-images-state .empty-icon {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-images-state .empty-text {
            color: #6c757d;
            font-size: 1rem;
            margin: 0;
        }

        .modern-carousel {
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modern-carousel .carousel-item img {
            width: 100%;
            height: auto;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 0;
            border: none;
        }

        .modern-carousel-control {
            width: 50px;
            height: 50px;
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .modern-carousel-control:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: translateY(-50%) scale(1.1);
        }

        .modern-carousel-control .carousel-control-prev-icon,
        .modern-carousel-control .carousel-control-next-icon {
            background-color: transparent;
            border-radius: 0;
            width: 20px;
            height: 20px;
        }

        .modern-carousel-control-prev {
            left: 20px;
        }

        .modern-carousel-control-next {
            right: 20px;
        }

        /* Responsive Modal Design */
        @media (max-width: 768px) {
            .modern-modal-header {
                padding: 1rem;
            }

            .modern-modal-body {
                padding: 1.5rem;
            }

            .modern-modal-footer {
                padding: 1rem 1.5rem;
                flex-direction: column;
            }

            .modern-btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .modal-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .modern-modal-header .modal-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .modern-modal {
                margin: 1rem;
            }

            .modern-modal-header {
                padding: 0.75rem;
            }

            .modern-modal-body {
                padding: 1rem;
            }

            .modern-modal-footer {
                padding: 0.75rem 1rem;
            }

            .rejection-reason-section {
                padding: 1rem;
            }
        }
    </style>

    {{-- Dataset for room images (JSON) --}}
    <script id="roomImagesData" type="application/json">{!! $resort->rooms->mapWithKeys(function($r){
        return [
            $r->id => $r->images->map(function($img){ return asset($img->image_path); })->values()
        ];
    })->toJson() !!}</script>

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

        .collapse-icon { 
            transition: transform 0.3s ease; 
        }
        .collapse-icon.rotated { 
            transform: rotate(180deg); 
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

        .mobile-brand-text {
            flex: 1;
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
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 10px;
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
            transform: translateX(2px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-icon {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .mobile-sidebar-nav .nav-icon-img {
            width: 18px;
            height: 18px;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        .mobile-sidebar-nav .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .mobile-sidebar-nav .nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        }

        .mobile-sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }

        /* Main Content Styles */
        .main-content {
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            margin-left: 280px;
            overflow-y: auto;
        }

        /* Adjust navbar width to match sidebar */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        /* Hide hamburger by default (desktop) */
        .hamburger-btn {
            display: none !important;
        }

        /* Responsive Design for All Screen Sizes */
        
        /* Extra Large Screens (1200px and up) */
        @media (min-width: 1200px) {
            .main-content {
                padding: 2.5rem;
            }
            
            .page-header {
                padding: 2rem;
            }
            
            .resort-info-card .card-body {
                padding: 2rem;
            }
            
            .room-card .card-body {
                padding: 2rem;
            }
        }
        
        /* Large Screens (992px to 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .main-content {
                padding: 2rem;
            }
            
            .resort-image {
                height: 220px;
            }
            
            .room-image-container {
                height: 140px;
            }
        }
        
        /* Medium Screens (768px to 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .main-content {
                padding: 1.5rem;
            }
            
            .page-header {
                padding: 1.25rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .resort-image {
                height: 200px;
            }
            
            .room-image-container {
                height: 130px;
            }
            
            .room-info-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        /* Small Screens (576px to 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .main-content {
                padding: 1rem;
                padding-top: 4rem;
                margin-left: 0;
            }
            .modern-sidebar { display: none !important; }
            .hamburger-btn { display: block !important; }
            .modern-navbar { left: 0; width: 100%; }
            
            .page-header {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.4rem;
            }
            
            .page-subtitle {
                font-size: 0.9rem;
            }
            
            .page-actions .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
            
            .resort-info-card .card-header {
                padding: 1rem;
            }
            
            .resort-info-card .card-body {
                padding: 1rem;
            }
            
            .resort-image {
                height: 180px;
            }
            
            .info-section {
                padding: 1rem;
            }
            
            .action-section {
                padding: 1rem;
            }
            
            .section-header {
                padding: 1rem;
            }
            
            .section-title {
                font-size: 1.3rem;
            }
            
            .room-card .card-body {
                padding: 1rem;
            }
            
            .room-image-container {
                height: 120px;
                margin-bottom: 1rem;
            }
            
            .room-name {
                font-size: 1.1rem;
            }
            
            .room-description {
                font-size: 0.9rem;
            }
            
            .room-description-section {
                padding: 0.75rem;
            }
            
            .description-label {
                font-size: 0.8rem;
            }
            
            .room-description-content {
                padding: 0.5rem;
            }
            
            .room-description-content .room-description {
                font-size: 0.9rem;
            }
            
            .description-list li {
                font-size: 0.9rem;
            }
            
            .room-info-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .room-status-section {
                padding: 0.75rem;
            }
            
            .status-item {
                padding: 0.75rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-action {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        /* Extra Small Screens (up to 575px) */
        @media (max-width: 575px) {
            .main-content {
                padding: 0.75rem;
                padding-top: 4rem;
                padding-right: 0.5rem; /* Add right padding to prevent scrollbar overlap */
                margin-left: 0;
            }
            .modern-sidebar { display: none !important; }
            .hamburger-btn { display: block !important; }
            .modern-navbar { left: 0; width: 100%; }
            
            .page-header {
                padding: 0.75rem;
                margin-bottom: 1rem;
            }
            
            .page-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }
            
            .page-title {
                font-size: 1.25rem;
            }
            
            .page-subtitle {
                font-size: 0.85rem;
            }
            
            .page-actions {
                width: 100%;
            }
            
            .page-actions .btn {
                width: 100%;
                padding: 0.5rem;
                font-size: 0.85rem;
            }
            
            .resort-info-card .card-header {
                padding: 0.75rem;
            }
            
            .resort-info-card .card-body {
                padding: 0.75rem;
            }
            
            .header-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            
            .resort-image {
                height: 160px;
            }
            
            .info-section {
                padding: 0.75rem;
            }
            
            .section-title {
                font-size: 1rem;
            }
            
            .info-item {
                margin-bottom: 0.75rem;
            }
            
            .info-label {
                font-size: 0.8rem;
            }
            
            .info-value {
                font-size: 0.9rem;
            }
            
            .status-item {
                padding: 0.5rem;
            }
            
            .status-label {
                font-size: 0.8rem;
            }
            
            .status-badge {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
            
            .action-section {
                padding: 0.75rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-action {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
            
            .section-header {
                padding: 0.75rem;
            }
            
            .section-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 1.2rem;
            }
            
            .section-subtitle {
                font-size: 0.85rem;
            }
            
            .room-count-badge .badge {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
                margin-right: 0.5rem; /* Add margin to prevent scrollbar overlap */
            }
            
            .section-header {
                padding-right: 1rem; /* Add right padding to prevent overlap */
            }
            
            .room-count-badge {
                margin-right: 0.5rem; /* Ensure badge doesn't touch scrollbar */
            }
            
            .room-card .card-body {
                padding: 0.75rem;
            }
            
            .room-image-container {
                height: 100px;
                margin-bottom: 0.75rem;
            }
            
            .room-name {
                font-size: 1rem;
            }
            
            .room-description {
                font-size: 0.85rem;
            }
            
            .room-description-section {
                padding: 0.5rem;
            }
            
            .description-label {
                font-size: 0.75rem;
            }
            
            .room-description-content {
                padding: 0.5rem;
            }
            
            .room-description-content .room-description {
                font-size: 0.85rem;
            }
            
            .description-list li {
                font-size: 0.85rem;
            }
            
            .room-info-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .room-status-section {
                padding: 0.5rem;
            }
            
            .room-status-section .row {
                margin: 0;
            }
            
            .room-status-section .col-md-6 {
                padding: 0.25rem;
            }
            
            .status-item {
                padding: 0.5rem;
            }
            
            .room-actions {
                margin-top: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-action {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
            
            .status-message {
                padding: 0.75rem;
                font-size: 0.85rem;
            }
            
            .empty-state .card-body {
                padding: 2rem 1rem;
            }
            
            .empty-icon {
                font-size: 3rem;
            }
            
            .empty-title {
                font-size: 1rem;
            }
            
            .empty-description {
                font-size: 0.85rem;
            }
        }
        
        /* Landscape Mobile Orientation */
        @media (max-width: 767px) and (orientation: landscape) {
            .main-content {
                padding-top: 3rem;
            }
            
            .resort-image {
                height: 140px;
            }
            
            .room-image-container {
                height: 80px;
            }
        }
        
        /* Print Styles */
        @media print {
            .main-content {
                background: white !important;
                padding: 0 !important;
            }
            
            .page-actions,
            .action-buttons,
            .btn-action {
                display: none !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
            
            .resort-image,
            .room-image {
                max-height: 200px !important;
            }
        }

        /* Page Header Styles */
        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #007bff;
        }

        .page-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.75rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
        }

        .page-actions .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        /* Resort Info Card Styles */
        .resort-info-card .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .resort-info-card .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .resort-image-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .resort-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .resort-image-container:hover .resort-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 2rem;
        }

        .resort-image-container:hover .image-overlay {
            opacity: 1;
        }

        .resort-details {
            padding: 1rem 0;
        }

        .section-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .info-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1rem;
        }

        .status-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .status-label {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-secondary {
            background: #e2e3e5;
            color: #383d41;
            border: 1px solid #d3d6da;
        }

        .status-note {
            font-size: 0.8rem;
            margin-top: 0.5rem;
            color: #6c757d;
        }

        .action-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-action {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .status-message .alert {
            border-radius: 8px;
            border: none;
            margin: 0;
        }

        /* Rooms Section Styles */
        .rooms-section {
            margin-top: 2rem;
        }

        .section-header {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #28a745;
        }
        
        .section-header .d-flex {
            align-items: center;
            justify-content: space-between;
            padding-right: 0.5rem; /* Add padding to prevent scrollbar overlap */
        }
        
        /* Ensure room count badge has proper spacing */
        .room-count-badge {
            margin-left: auto;
            margin-right: 0.5rem; /* Add margin to prevent scrollbar overlap */
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .section-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .room-count-badge .badge {
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .room-card .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .room-card .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
        }

        .room-image-container {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            height: 150px;
        }

        .room-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .room-image-container:hover .room-image {
            transform: scale(1.05);
        }

        .room-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 1.5rem;
        }

        .room-image-container:hover .room-image-overlay {
            opacity: 1;
        }

        .room-name {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .room-description {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        /* Enhanced Room Description Section */
        .room-description-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            border-left: 4px solid #007bff;
        }

        .description-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .description-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .room-description-content {
            background: white;
            padding: 0.75rem;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .room-description-content .room-description {
            margin: 0;
            color: #495057;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Description List Styles */
        .description-list {
            margin: 0;
            padding-left: 1.5rem;
            list-style: none;
        }

        .description-list li {
            position: relative;
            margin-bottom: 0.5rem;
            color: #495057;
            font-size: 0.95rem;
            line-height: 1.6;
            font-weight: 600;
        }

        .description-list li::before {
            content: "•";
            color: #007bff;
            font-weight: bold;
            position: absolute;
            left: -1.5rem;
            top: 0;
        }

        .description-list li:last-child {
            margin-bottom: 0;
        }

        .room-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .availability-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .availability-badge.available {
            background: #d4edda;
            color: #155724;
        }

        .availability-badge.unavailable {
            background: #f8d7da;
            color: #721c24;
        }

        .room-status-section {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }

        .room-actions {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .status-display {
            text-align: center;
        }

        .status-message {
            background: #e9ecef;
            padding: 1rem;
            border-radius: 8px;
            color: #6c757d;
            font-weight: 500;
        }

        /* Empty State Styles */
        .empty-state .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
        }

        .empty-title {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: #adb5bd;
            font-size: 0.95rem;
        }

        /* Additional Mobile Optimizations */
        
        /* Touch-friendly elements for mobile */
        @media (max-width: 767px) {
            .btn-action {
                min-height: 44px; /* Apple's recommended touch target size */
                min-width: 44px;
            }
            
            .nav-link {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
            
            .status-badge {
                min-height: 32px;
                display: inline-flex;
                align-items: center;
            }
            
            .availability-badge {
                min-height: 28px;
                display: inline-flex;
                align-items: center;
            }
            
            /* Prevent overlapping with scrollbar */
            .main-content {
                padding-right: 0.75rem;
            }
            
            .card {
                margin-right: 0.25rem; /* Add small margin to prevent scrollbar overlap */
            }
            
            .section-header .d-flex {
                padding-right: 0.5rem;
            }
        }
        
        /* Improved spacing for mobile */
        @media (max-width: 575px) {
            .resort-details .row > div {
                margin-bottom: 1rem;
            }
            
            .room-details .row > div {
                margin-bottom: 0.75rem;
            }
            
            .info-section,
            .action-section,
            .room-status-section {
                margin-bottom: 1rem;
            }
            
            .room-card {
                margin-bottom: 1.5rem;
            }
        }
        
        /* Better text wrapping for long content */
        .room-description,
        .status-note,
        .info-value {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }
        
        /* Improved grid responsiveness */
        .room-info-grid {
            display: grid;
            gap: 0.75rem;
        }
        
        @media (min-width: 576px) {
            .room-info-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }
        
        @media (min-width: 768px) {
            .room-info-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
        
        /* Better image responsiveness */
        .resort-image,
        .room-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        
        /* Improved card responsiveness */
        .card {
            margin-bottom: 1rem;
        }
        
        @media (max-width: 575px) {
            .card {
                margin-bottom: 0.75rem;
            }
        }
        
        /* Better button responsiveness */
        .btn-action {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        @media (max-width: 575px) {
            .btn-action {
                white-space: normal;
                text-align: center;
            }
        }
        
        /* Improved modal responsiveness */
        @media (max-width: 575px) {
            .modal-dialog {
                margin: 0.5rem;
            }
            
            .modal-content {
                border-radius: 8px;
            }
        }
        
        /* Better table responsiveness for future use */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        /* Improved focus states for accessibility */
        .btn-action:focus,
        .nav-link:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }
        
        /* Better loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        /* Improved error states */
        .error-state {
            border-left: 4px solid #dc3545;
            background: #f8d7da;
        }
        
        /* Better success states */
        .success-state {
            border-left: 4px solid #28a745;
            background: #d4edda;
        }
        
        /* Ultra-small screens (320px and below) - prevent all overlapping */
        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
                padding-top: 4rem;
                padding-right: 0.25rem; /* Minimal right padding for scrollbar */
            }
            
            .page-header {
                padding: 0.5rem;
            }
            
            .section-header {
                padding: 0.5rem;
                padding-right: 0.75rem; /* Extra right padding for scrollbar */
            }
            
            .room-count-badge {
                margin-right: 0.75rem; /* More margin for very small screens */
            }
            
            .room-count-badge .badge {
                font-size: 0.8rem;
                padding: 0.3rem 0.6rem;
                margin-right: 0.75rem;
            }
            
            .card {
                margin-right: 0.5rem; /* More margin for cards */
            }
            
            .btn-action {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }
            
            .page-title {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 1.1rem;
            }
        }

        /* Simple Badge Styles */
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
            background-color: #d1ecf1 !important;
            color: #0c5460 !important;
            border: 1px solid #bee5eb !important;
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

        /* Simple Card Styles */
        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        /* Simple Button Styles */
        .btn {
            border-radius: 6px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Collapse functionality for both desktop and mobile
            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
            collapseToggles.forEach(function(toggle) {
                var targetId = toggle.getAttribute('data-bs-target');
                var target = document.querySelector(targetId);
                var icon = toggle.querySelector('.collapse-icon');
                
                if (target && icon) {
                    target.addEventListener('show.bs.collapse', function() {
                        icon.classList.add('rotated');
                    });
                    target.addEventListener('hide.bs.collapse', function() {
                        icon.classList.remove('rotated');
                    });
                }
            });

            // Mobile sidebar offcanvas functionality
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

    {{-- Custom JavaScript for image error handling and modal logic --}}
    <script>
        // Global function for image error handling
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null; // Prevent infinite looping if default image also fails
            imgElement.src = defaultImagePath;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var adminActionModal = document.getElementById('adminActionModal');
            adminActionModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var itemId = button.getAttribute('data-item-id'); // Can be resort or room ID
                var itemName = button.getAttribute('data-item-name'); // Can be resort or room name
                var actionType = button.getAttribute('data-action-type'); // 'approve' or 'reject'
                var targetType = button.getAttribute('data-target-type'); // 'resort' or 'room'

                var modalTitle = adminActionModal.querySelector('#adminActionModalLabel');
                var modalActionMessage = adminActionModal.querySelector('#modalActionMessage');
                var rejectionReasonGroup = adminActionModal.querySelector('#rejectionReasonGroup');
                var rejectionReasonTextarea = adminActionModal.querySelector('#rejection_reason');
                var adminActionForm = adminActionModal.querySelector('#adminActionForm');
                var confirmActionButton = adminActionModal.querySelector('#confirmActionButton');

                // Reset modal state
                rejectionReasonGroup.style.display = 'none';
                rejectionReasonTextarea.required = false;
                rejectionReasonTextarea.value = '';
                // Reset button classes to allow new ones to be added cleanly
                confirmActionButton.className = 'btn rounded-pill';

                let routePrefix = '';
                let itemTypeDisplay = '';

                // Dynamically set route prefix based on target type and ensure it matches routes/web.php
                if (targetType === 'resort') {
                    routePrefix = '/admin/resort/'; // Matches Route::patch('/admin/resort/{resort}/...
                    itemTypeDisplay = 'Resort';
                } else if (targetType === 'room') {
                    routePrefix = '/admin/room/'; // Matches Route::patch('/admin/room/{room}/...
                    itemTypeDisplay = 'Room';
                }

                if (actionType === 'approve') {
                    modalTitle.textContent = 'Approve ' + itemTypeDisplay;
                    modalActionMessage.textContent = 'Are you sure you want to approve "' + itemName + '"?';
                    adminActionForm.action = routePrefix + itemId + '/approve';
                    confirmActionButton.textContent = 'Confirm Approve';
                    confirmActionButton.classList.add('btn-success');
                } else if (actionType === 'reject') {
                    modalTitle.textContent = 'Reject ' + itemTypeDisplay;
                    modalActionMessage.textContent = 'Are you sure you want to reject "' + itemName + '"? Please provide a reason.';
                    rejectionReasonGroup.style.display = 'block';
                    rejectionReasonTextarea.required = true;
                    adminActionForm.action = routePrefix + itemId + '/reject';
                    confirmActionButton.textContent = 'Confirm Reject';
                    confirmActionButton.classList.add('btn-danger');
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

            // Populate room images modal
            const roomImagesModal = document.getElementById('roomImagesModal');
            if (roomImagesModal) {
                roomImagesModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const roomId = button.getAttribute('data-room-id');
                    const roomName = button.getAttribute('data-room-name') || 'Room Images';
                    const title = roomImagesModal.querySelector('#roomImagesModalLabel');
                    const carousel = document.getElementById('roomImagesCarousel');
                    const inner = document.getElementById('roomImagesCarouselInner');
                    const empty = document.getElementById('roomImagesEmpty');
                    if (title) title.textContent = roomName + ' - Images';
                    if (inner && carousel && empty) {
                        inner.innerHTML = '';
                        try {
                            const dataEl = document.getElementById('roomImagesData');
                            const dataset = dataEl ? JSON.parse(dataEl.textContent || '{}') : {};
                            const paths = dataset[String(roomId)] || [];
                            if (!paths.length) {
                                empty.style.display = 'block';
                                carousel.style.display = 'none';
                            } else {
                                empty.style.display = 'none';
                                carousel.style.display = 'block';
                                paths.forEach(function(p, idx){
                                    const item = document.createElement('div');
                                    item.className = 'carousel-item' + (idx === 0 ? ' active' : '');
                                    const img = document.createElement('img');
                                    img.src = String(p);
                                    img.alt = roomName + ' image ' + (idx + 1);
                                    img.onerror = function(){ this.src="{{ asset('images/default_room.png') }}"; };
                                    item.appendChild(img);
                                    inner.appendChild(item);
                                });
                            }
                        } catch (e) {
                            empty.textContent = 'Failed to load images.';
                            empty.style.display = 'block';
                            carousel.style.display = 'none';
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>