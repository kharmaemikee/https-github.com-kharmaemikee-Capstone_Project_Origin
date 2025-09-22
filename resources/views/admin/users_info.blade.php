<x-app-layout>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @php
        // Backend functionalities for admin permit approval and resubmission
        // Get CSRF token for AJAX requests
        $csrfToken = csrf_token();
        
        // Get current user for authorization
        $currentUser = Auth::user();
        
        // Check if user is admin
        $isAdmin = $currentUser && $currentUser->role === 'admin';
    @endphp

    <!-- Modern Background with Glassmorphism Effect -->
    <div class="modern-background">
        <div class="bg-gradient-1"></div>
        <div class="bg-gradient-2"></div>
        
        {{-- Debug Section - Remove this after testing --}}
        <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border: 1px solid #ccc; position: relative; z-index: 1000;">
            <h4>Debug - User Resubmitted Status (First 3 users):</h4>
            @foreach($users->take(3) as $debugUser)
                <p>User {{ $debugUser->id }} ({{ $debugUser->username }}): 
                    BIR: {{ $debugUser->bir_resubmitted ? 'true' : 'false' }} (raw: {{ $debugUser->bir_resubmitted }}), 
                    DTI: {{ $debugUser->dti_resubmitted ? 'true' : 'false' }} (raw: {{ $debugUser->dti_resubmitted }}),
                    Business: {{ $debugUser->business_permit_resubmitted ? 'true' : 'false' }} (raw: {{ $debugUser->business_permit_resubmitted }})
                </p>
            @endforeach
        </div>
        <div class="bg-gradient-3"></div>
    </div>
    
    <div class="d-flex flex-column flex-md-row min-vh-100">

    {{-- Modern Desktop Sidebar --}}
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
            <div class="page-header">
                <div class="page-title-section">
                    <h1 class="page-title">{{ $userType ?? 'Users' }}</h1>
                    <p class="page-subtitle">Manage and monitor user accounts and their verification status</p>
                </div>
                    <div class="page-stats">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $users->count() }}</div>
                                <div class="stat-label">Total Users</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $users->where('is_approved', true)->count() }}</div>
                                <div class="stat-label">Approved</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $users->where('is_approved', false)->count() }}</div>
                                <div class="stat-label">Pending</div>
                            </div>
                        </div>
                    </div>
            </div>

            {{-- Users Table Card --}}
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">User Management</h3>
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th class="user-info-col">
                                    <i class="fas fa-user"></i>
                                    Tourist Information
                                </th>
                                @if(($userType ?? 'All Users') === 'Tourist Users')
                                    <th class="contact-col">
                                        <i class="fas fa-phone"></i>
                                        Contact
                                    </th>
                                    <th class="address-col">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Address
                                    </th>
                                @endif
                                
                                <th class="role-col">
                                    <i class="fas fa-user-tag"></i>
                                    Role
                                </th>
                                
                                @if(($userType ?? 'All Users') !== 'Tourist Users')
                                    <th class="documents-col">
                                        <i class="fas fa-file-alt"></i>
                                        Documents
                                    </th>
                                @endif
                                
                                <th class="status-col">
                                    <i class="fas fa-check-circle"></i>
                                    Status
                                </th>
                                
                                <th class="actions-col">
                                    <i class="fas fa-cogs"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr id="userRow{{ $user->id }}" data-role="{{ $user->role }}" class="user-row">
                                <td class="user-info-cell">
                                    <div class="user-avatar">
                                        @if($user->owner_image_path)
                                            <img src="{{ asset($user->owner_image_path) }}" alt="User Avatar" class="avatar-img">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="user-details">
                                        <h6 class="user-name">
                                            @if(($userType ?? 'All Users') === 'Tourist Users')
                                                {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                                            @else
                                                {{ $user->username }}
                                            @endif
                                        </h6>
                                    </div>
                                </td>
                                
                                @if(($userType ?? 'All Users') === 'Tourist Users')
                                    <td class="contact-cell">
                                        <div class="contact-info">
                                            <i class="fas fa-phone"></i>
                                            <span>{{ $user->phone ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="address-cell">
                                        <div class="address-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                            @if($user->address)
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->address }}">
                                                    {{ Str::limit($user->address, 30, '...') }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                
                                <td class="role-cell">
                                    <span class="role-badge role-{{ str_replace('_', '-', $user->role) }}">
                                        <i class="fas fa-{{ $user->role === 'resort_owner' ? 'building' : ($user->role === 'boat_owner' ? 'ship' : 'user') }}"></i>
                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                @if(($userType ?? 'All Users') !== 'Tourist Users')
                                    <td class="documents-cell">
                                        <div class="documents-grid-2x2">
                                            {{-- BIR Permit --}}
                                            <div class="document-item permitCell" data-type="bir_permit">
                                                <div class="document-label">BIR</div>
                                                <div class="document-status">
                                                    @if ($user->bir_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->bir_permit_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->bir_permit_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="bir_permit"
                                                                data-resubmitted="{{ $user->bir_resubmitted ? 'true' : 'false' }}"
                                                                data-debug-bir-resubmitted="{{ $user->bir_resubmitted }}">
                                                            @if($user->bir_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            {{-- DTI Permit --}}
                                            <div class="document-item permitCell" data-type="dti_permit">
                                                <div class="document-label">DTI</div>
                                                <div class="document-status">
                                                    @if ($user->dti_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->dti_permit_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->dti_permit_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="dti_permit"
                                                                data-resubmitted="{{ $user->dti_resubmitted ? 'true' : 'false' }}">
                                                            @if($user->dti_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- Business Permit --}}
                                            <div class="document-item permitCell" data-type="business_permit">
                                                <div class="document-label">Business</div>
                                                <div class="document-status">
                                                    @if ($user->business_permit_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->business_permit_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->business_permit_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="business_permit"
                                                                data-resubmitted="{{ $user->business_permit_resubmitted ? 'true' : 'false' }}">
                                                            @if($user->business_permit_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if(($userType ?? 'All Users') !== 'Resort Users' && ($userType ?? 'All Users') !== 'Tourist Users')
                                            {{-- LGU Resolution --}}
                                            <div class="document-item permitCell" data-type="lgu_resolution">
                                                <div class="document-label">LGU</div>
                                                <div class="document-status">
                                                    @if ($user->lgu_resolution_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->lgu_resolution_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->lgu_resolution_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="lgu_resolution"
                                                                data-resubmitted="{{ $user->lgu_resolution_resubmitted ? 'true' : 'false' }}">
                                                            @if($user->lgu_resolution_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            {{-- Marina CPC --}}
                                            <div class="document-item permitCell" data-type="marina_cpc">
                                                <div class="document-label">Marina</div>
                                                <div class="document-status">
                                                    @if ($user->marina_cpc_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->marina_cpc_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->marina_cpc_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="marina_cpc"
                                                                data-resubmitted="{{ $user->marina_cpc_resubmitted ? 'true' : 'false' }}">
                                                            @if($user->marina_cpc_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            {{-- Boat Association --}}
                                            <div class="document-item permitCell" data-type="boat_association">
                                                <div class="document-label">Boat Assoc</div>
                                                <div class="document-status">
                                                    @if ($user->boat_association_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->boat_association_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->boat_association_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="boat_association"
                                                                data-resubmitted="{{ $user->boat_association_resubmitted ? 'true' : 'false' }}">
                                                            @if($user->boat_association_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if(($userType ?? 'All Users') !== 'Boat Users' && ($userType ?? 'All Users') !== 'Tourist Users')
                                            {{-- Tourism Registration --}}
                                            <div class="document-item permitCell" data-type="tourism_registration">
                                                <div class="document-label">Tourism</div>
                                                <div class="document-status">
                                                    @if ($user->tourism_registration_approved)
                                                        <span class="status-badge approved">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    @elseif($user->tourism_registration_path)
                                                        <button class="btn btn-sm btn-outline-primary viewPermitBtn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewPermitModal"
                                                                data-image-url="{{ asset($user->tourism_registration_path) }}"
                                                                data-user-id="{{ $user->id }}"
                                                                data-document-type="tourism_registration"
                                                                data-resubmitted="{{ $user->tourism_registration_resubmitted ? 'true' : 'false' }}">
                                                            @if($user->tourism_registration_resubmitted)
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                            @else
                                                                <i class="fas fa-eye"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <span class="status-badge not-uploaded">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                <td class="status-cell">
                                    <div class="approval-status">
                                        @if ($user->is_approved)
                                            <span class="status-badge approved">
                                                <i class="fas fa-check-circle"></i>
                                                <span>Approved</span>
                                            </span>
                                        @else
                                            <span class="status-badge pending">
                                                <i class="fas fa-clock"></i>
                                                <span>Pending</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-outline-info btn-sm action-btn view-btn" 
                                            data-bs-toggle="modal" data-bs-target="#viewUserDetailsModal"
                                            data-birthday="{{ $user->birthday }}"
                                            data-gender="{{ $user->gender }}"
                                            data-address="{{ $user->address }}"
                                            data-phone="{{ $user->phone }}"
                                            data-nationality="{{ $user->nationality }}"
                                            data-first-name="{{ $user->first_name }}"
                                            data-middle-name="{{ $user->middle_name }}"
                                            data-last-name="{{ $user->last_name }}"
                                            data-username="{{ $user->username }}"
                                            data-owner-image="{{ $user->owner_image_path ? asset($user->owner_image_path) : '' }}"
                                            title="View details" aria-label="View details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm action-btn delete-btn" 
                                            data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" 
                                            data-user-id="{{ $user->id }}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- View User Details Modal -->
    <div class="modal fade" id="viewUserDetailsModal" tabindex="-1" aria-labelledby="viewUserDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content user-details-modal">
                <div class="modal-header user-details-header">
                    <div class="header-content">
                        <div class="user-avatar-section">
                            <div class="user-avatar-large">
                                <img id="detailOwnerImage" src="" alt="Profile" class="avatar-large-img">
                                <div class="avatar-placeholder-large" id="avatarPlaceholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="user-title-section">
                            <h4 class="modal-title" id="viewUserDetailsModalLabel">
                                <i class="fas fa-user-circle me-2"></i>
                                User Details
                            </h4>
                            <p class="user-subtitle">Complete user information</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body user-details-body">
                    <div class="user-info-grid">
                        <div class="info-section">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <label class="info-label">Full Name</label>
                                    <span class="info-value" id="detailFullName">N/A</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-at"></i>
                                </div>
                                <div class="info-content">
                                    <label class="info-label">Username</label>
                                    <span class="info-value" id="detailUsername">N/A</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-birthday-cake"></i>
                                </div>
                                <div class="info-content">
                                    <label class="info-label">Birthday</label>
                                    <span class="info-value" id="detailBirthday">N/A</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <div class="info-content">
                                    <label class="info-label">Age</label>
                                    <span class="info-value" id="detailAge">N/A</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-venus-mars"></i>
                                </div>
                                <div class="info-content">
                                    <label class="info-label">Gender</label>
                                    <span class="info-value" id="detailGender">N/A</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <div class="info-content">
                                    <label class="info-label">Nationality</label>
                                    <span class="info-value" id="detailNationality">N/A</span>
                                </div>
                            </div>
                            
                            @if(($userType ?? 'All Users') !== 'Tourist Users')
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">Address</label>
                                        <span class="info-value" id="detailAddress">N/A</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">Contact Number</label>
                                        <span class="info-value" id="detailPhone">N/A</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer user-details-footer">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-dismiss="modal">
                        <i class="fas fa-check me-2"></i>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewPermitModal" tabindex="-1" aria-labelledby="viewPermitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content permit-modal-content">
                <!-- Modern Header -->
                <div class="modal-header permit-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="permit-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="permit-header-text">
                            <h4 class="modal-title" id="viewPermitModalLabel">Document Review</h4>
                            <p class="permit-subtitle">Review and approve permit documents</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body permit-modal-body">
                    <div class="row g-4">
                        <!-- Document Preview Section -->
                        <div class="col-lg-8">
                            <div class="preview-section">
                                <div class="preview-header">
                                    <h5 class="preview-title">
                                        <i class="fas fa-eye me-2"></i>Document Preview
                                    </h5>
                                    <div class="preview-controls">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="viewPdfButton" style="display: none;">
                                            <i class="fas fa-external-link-alt me-1"></i>Open in New Tab
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="preview-container">
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="preview-content" style="display: none;">
                                        <div class="image-wrapper">
                                            <img id="permitImage" src="" alt="Permit Document" class="preview-image">
                                        </div>
                                    </div>
                                    
                                    <!-- PDF Preview -->
                                    <div id="pdfPreview" class="preview-content" style="display: none;">
                                        <div class="pdf-wrapper">
                                            <iframe id="pdfViewer" src="" class="pdf-iframe"></iframe>
                                            <div class="pdf-overlay">
                                                <span class="pdf-label">PDF Document</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Unsupported File Type -->
                                    <div id="unsupportedPreview" class="preview-content" style="display: none;">
                                        <div class="unsupported-wrapper">
                                            <div class="unsupported-icon">
                                                <i class="fas fa-file-download"></i>
                                            </div>
                                            <h5>Preview Not Available</h5>
                                            <p>This file type cannot be previewed in the browser.</p>
                                            <button type="button" class="btn btn-primary" id="downloadFileButton">
                                                <i class="fas fa-download me-2"></i>Download File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Document Information Section -->
                        <div class="col-lg-4">
                            <div class="info-section">
                                <div class="info-header">
                                    <h5 class="info-title">
                                        <i class="fas fa-info-circle me-2"></i>Document Details
                                    </h5>
                                </div>
                                
                                <div class="info-content">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-tag me-2"></i>Document Type
                                        </div>
                                        <div class="info-value" id="documentType">-</div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-file me-2"></i>File Name
                                        </div>
                                        <div class="info-value" id="fileName">-</div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-weight me-2"></i>File Size
                                        </div>
                                        <div class="info-value" id="fileSize">-</div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-check-circle me-2"></i>Status
                                        </div>
                                        <div class="info-value">
                                            <span class="status-badge pending" id="documentStatus">Pending Review</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="action-section">
                                    <h6 class="action-title">
                                        <i class="fas fa-cogs me-2"></i>Actions
                                    </h6>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-success w-100 mb-2" id="approvePermitButton">
                                            <i class="fas fa-check me-2"></i>Approve Document
                                        </button>
                                        <button type="button" class="btn btn-warning w-100" id="requestResubmitButton">
                                            <i class="fas fa-redo me-2"></i>Request Resubmit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resubmit Reason Section -->
                    <div id="resubmitReasonSection" class="resubmit-section" style="display: none;">
                        <div class="resubmit-header">
                            <h6 class="resubmit-title">
                                <i class="fas fa-comment-alt me-2"></i>Resubmission Reason
                            </h6>
                        </div>
                        <div class="resubmit-content">
                            <label for="resubmitReason" class="form-label">Please provide a reason for requesting resubmission:</label>
                            <textarea id="resubmitReason" class="form-control resubmit-textarea" rows="4" 
                                placeholder="Enter the reason why this document needs to be resubmitted..."></textarea>
                            <div id="resubmitReasonError" class="error-message" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="modal-footer permit-modal-footer">
                    <div class="footer-actions">
                        <button type="button" id="confirmResubmitButton" class="btn btn-danger" style="display: none;">
                            <i class="fas fa-paper-plane me-2"></i>Confirm Resubmit
                        </button>
                        <button type="button" id="cancelResubmitButton" class="btn btn-secondary" style="display: none;">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
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
        .badge-success {
            background-color: #28a745 !important;
            color: #fff !important;
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

        /* NEW STYLE: for disabled link */
        .disabled-link {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
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
    </style>
   <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sync arrow rotation with collapse show/hide
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });
            let currentUserId = null;
            let currentDocumentType = null;
            let currentViewButtonEl = null;
            const csrfToken = (document.querySelector('meta[name="csrf-token"]')?.content) || '{{ csrf_token() }}';
            const approvePermitBase = "{{ url('/admin/users') }}";
            
            // View Permit buttons
            document.querySelectorAll('.viewPermitBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const imageUrl = this.getAttribute('data-image-url');
                    currentUserId = this.getAttribute('data-user-id');
                    currentDocumentType = this.getAttribute('document_type') || this.getAttribute('data-document-type');
                    currentViewButtonEl = this;
                    
                    // Determine file type and show appropriate preview
                    const fileExtension = imageUrl.split('.').pop().toLowerCase();
                    const isPdf = fileExtension === 'pdf';
                    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension);
                    
                    // Hide all previews first
                    document.getElementById('imagePreview').style.display = 'none';
                    document.getElementById('pdfPreview').style.display = 'none';
                    document.getElementById('unsupportedPreview').style.display = 'none';
                    
                    if (isImage) {
                        // Show image preview
                        document.getElementById('imagePreview').style.display = 'block';
                        document.getElementById('permitImage').src = imageUrl;
                        document.getElementById('viewPdfButton').style.display = 'none';
                    } else if (isPdf) {
                        // Show PDF preview
                        document.getElementById('pdfPreview').style.display = 'block';
                        document.getElementById('pdfViewer').src = imageUrl;
                        document.getElementById('viewPdfButton').style.display = 'block';
                        document.getElementById('viewPdfButton').onclick = function() {
                            window.open(imageUrl, '_blank');
                        };
                    } else {
                        // Show unsupported file type
                        document.getElementById('unsupportedPreview').style.display = 'block';
                        document.getElementById('downloadFileButton').onclick = function() {
                            window.open(imageUrl, '_blank');
                        };
                    }
                    
                    // Update document information
                    document.getElementById('documentType').textContent = currentDocumentType.replace(/_/g, ' ').toUpperCase();
                    document.getElementById('fileName').textContent = imageUrl.split('/').pop();
                    document.getElementById('fileSize').textContent = 'Unknown';
                    document.getElementById('documentStatus').textContent = 'Pending Review';
                    
                    const parentCell = this.closest('td');
                    const userRow = this.closest('tr');
                    const userRole = userRow?.dataset?.role || '';
                    
                    // Show approve button only if THIS SPECIFIC permit is not yet approved
                    // Find the specific permit cell div within the documents cell
                    const currentPermitCell = parentCell.querySelector(`div.permitCell[data-type="${currentDocumentType}"]`);
                    const isThisPermitApproved = currentPermitCell && currentPermitCell.querySelector('.status-badge.approved');
                    const isTourist = userRole === 'tourist';
                    const isOwnerImage = currentDocumentType === 'owner_image';
                    document.getElementById('approvePermitButton').style.display =
                        (isThisPermitApproved || isTourist || isOwnerImage) ? 'none' : 'inline-block';
                    // Enable/disable Approve based on resubmit pending for this specific permit cell
                    const approveBtn = document.getElementById('approvePermitButton');
                    const resubmitBtn = document.getElementById('requestResubmitButton');
                    
                    if (approveBtn) {
                        // Check if this specific permit has been resubmitted (not yet uploaded new version)
                        // Look for the data-resubmitted attribute in the view button
                        const viewButton = currentPermitCell && currentPermitCell.querySelector('.viewPermitBtn');
                        const isResubmitPending = viewButton && viewButton.getAttribute('data-resubmitted') === 'true';
                        
                        // Debug logging
                        console.log('Debug - Modal Open Logic:');
                        console.log('  currentDocumentType:', currentDocumentType);
                        console.log('  parentCell:', parentCell);
                        console.log('  currentPermitCell:', currentPermitCell);
                        console.log('  viewButton:', viewButton);
                        console.log('  data-resubmitted:', viewButton ? viewButton.getAttribute('data-resubmitted') : 'N/A');
                        console.log('  data-debug-bir-resubmitted:', viewButton ? viewButton.getAttribute('data-debug-bir-resubmitted') : 'N/A');
                        console.log('  isResubmitPending:', isResubmitPending);
                        
                        // Special debug for DTI
                        if (currentDocumentType === 'dti_permit') {
                            console.log('DTI DEBUG - Modal Opening:');
                            console.log('  DTI currentDocumentType:', currentDocumentType);
                            console.log('  DTI viewButton found:', !!viewButton);
                            console.log('  DTI data-resubmitted:', viewButton ? viewButton.getAttribute('data-resubmitted') : 'N/A');
                            console.log('  DTI isResubmitPending:', isResubmitPending);
                            console.log('  DTI approveBtn will be disabled:', !!isResubmitPending);
                        }
                        
                        approveBtn.disabled = !!isResubmitPending || isTourist || isOwnerImage || isThisPermitApproved;
                        approveBtn.title = isResubmitPending ? 'Disabled: awaiting new upload after resubmission request for this permit' : 
                                          isThisPermitApproved ? 'This permit is already approved' :
                                          isTourist ? 'Tourists do not require approval' : isOwnerImage ? 'Owner image is auto-approved' : '';
                    }
                    
                    // Hide resubmit button for tourists, owner_image (auto-approved), and already approved permits
                    if (resubmitBtn) {
                        resubmitBtn.style.display = (isTourist || isOwnerImage || isThisPermitApproved) ? 'none' : 'inline-block';
                    }
                    
                    // Reset resubmit reason input and buttons when viewing a permit
                    document.getElementById('resubmitReasonSection').style.display = 'none';
                    document.getElementById('resubmitReason').value = '';
                    document.getElementById('resubmitReasonError').style.display = 'none';
                    document.getElementById('requestResubmitButton').style.display = (isTourist || isOwnerImage || isThisPermitApproved) ? 'none' : 'inline-block';
                    document.getElementById('confirmResubmitButton').style.display = 'none';
                    document.getElementById('cancelResubmitButton').style.display = 'none';
                });
            });
            
            // Approve permit in modal
            document.getElementById('approvePermitButton').addEventListener('click', function () {
                if (!currentUserId || !currentDocumentType) return;
                const btn = this;
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Approving...';

                fetch(`${approvePermitBase}/${currentUserId}/approve-permit`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ document_type: currentDocumentType })
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(`Request failed (${response.status}): ${text}`);
                    }
                    const ct = response.headers.get('content-type') || '';
                    if (!ct.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but received: ${text.substring(0, 200)}...`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById('userRow' + currentUserId);
                        const permitCell = row.querySelector(`div.permitCell[data-type="${currentDocumentType}"]`);
                        
                        // Replace the clicked View button with a check icon/badge
                        if (currentViewButtonEl) {
                            const checkSpan = document.createElement('span');
                            checkSpan.className = 'badge badge-light-success';
                            checkSpan.textContent = '✔';
                            currentViewButtonEl.replaceWith(checkSpan);
                        } else {
                            // Fallback: update entire cell if button ref is missing
                            permitCell.innerHTML = '<span class="badge badge-light-success">✔</span>';
                        }
                        
                        // Update the specific permit cell to show approved status
                        if (permitCell) {
                            const statusDiv = permitCell.querySelector('.document-status');
                            if (statusDiv) {
                                statusDiv.innerHTML = '<span class="status-badge approved"><i class="fas fa-check"></i></span>';
                            }
                        }
                        
                        // Check if all permits are approved after this action
                        const allPermitCells = row.querySelectorAll('.permitCell');
                        let fullyApproved = true;
                        allPermitCells.forEach(cell => {
                            if (cell.querySelector('button.viewPermitBtn')) {
                                fullyApproved = false;
                            }
                        });
        
                        if (fullyApproved) {
                            // Update the overall approved status only when ALL permits are approved
                            const userApprovedElement = row.querySelector(`#userApproved${currentUserId}`);
                            if (userApprovedElement) {
                                userApprovedElement.innerHTML = '<span class="badge badge-light-success rounded-pill">Yes</span>';
                            }
                            
                            // Update the status cell in the table
                            const statusCell = row.querySelector('.status-cell .approval-status');
                            if (statusCell) {
                                statusCell.innerHTML = '<span class="status-badge approved"><i class="fas fa-check-circle"></i><span>Approved</span></span>';
                            }
                        }
                        
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('viewPermitModal'));
                        modal.hide();
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    } else {
                        console.error("Failed to approve. Please try again.");
                        let err = document.getElementById('approveError');
                        if (!err) {
                            err = document.createElement('div');
                            err.id = 'approveError';
                            err.className = 'text-danger small mt-2';
                            document.querySelector('#viewPermitModal .modal-footer').prepend(err);
                        }
                        err.textContent = data.message || 'Approval failed. Please try again.';
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    }
                })
                .catch(err => {
                    console.error(err);
                    let e = document.getElementById('approveError');
                    if (!e) {
                        e = document.createElement('div');
                        e.id = 'approveError';
                        e.className = 'text-danger small mt-2';
                        document.querySelector('#viewPermitModal .modal-footer').prepend(e);
                    }
                    
                    // Try to parse error message from response
                    let errorMessage = 'Approval failed. Please refresh and try again.';
                    if (err.message && err.message.includes('Cannot approve permit')) {
                        errorMessage = err.message.split(': ')[1] || err.message;
                    }
                    
                    e.textContent = errorMessage;
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
            });

            // Show resubmit reason input when Resubmit button is clicked
            document.getElementById('requestResubmitButton').addEventListener('click', function () {
                if (!currentUserId || !currentDocumentType) return;
                
                // Show reason input section
                document.getElementById('resubmitReasonSection').style.display = 'block';
                document.getElementById('resubmitReason').value = '';
                document.getElementById('resubmitReasonError').style.display = 'none';
                
                // Hide/show buttons
                document.getElementById('requestResubmitButton').style.display = 'none';
                document.getElementById('confirmResubmitButton').style.display = 'inline-block';
                document.getElementById('cancelResubmitButton').style.display = 'inline-block';
            });

            // Cancel resubmit - hide reason input and show original buttons
            document.getElementById('cancelResubmitButton').addEventListener('click', function () {
                document.getElementById('resubmitReasonSection').style.display = 'none';
                document.getElementById('resubmitReasonError').style.display = 'none';
                
                // Show/hide buttons
                document.getElementById('requestResubmitButton').style.display = 'inline-block';
                document.getElementById('confirmResubmitButton').style.display = 'none';
                document.getElementById('cancelResubmitButton').style.display = 'none';
            });

            // Confirm resubmit with reason
            document.getElementById('confirmResubmitButton').addEventListener('click', function () {
                if (!currentUserId || !currentDocumentType) return;
                
                const reason = document.getElementById('resubmitReason').value.trim();
                if (!reason) {
                    document.getElementById('resubmitReasonError').textContent = 'Please provide a reason for resubmission.';
                    document.getElementById('resubmitReasonError').style.display = 'block';
                    return;
                }
                
                const btn = this;
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Requesting...';

                fetch(`${approvePermitBase}/${currentUserId}/request-resubmit-permit`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ 
                        document_type: currentDocumentType,
                        reason: reason
                    })
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(`Request failed (${response.status}): ${text}`);
                    }
                    const ct = response.headers.get('content-type') || '';
                    if (!ct.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but received: ${text.substring(0, 200)}...`);
                    }
                    return response.json();
                })
                .then(data => {
                    let info = document.getElementById('resubmitInfo');
                    if (!info) {
                        info = document.createElement('div');
                        info.id = 'resubmitInfo';
                        info.className = 'text-success small mt-2';
                        document.querySelector('#viewPermitModal .modal-footer').prepend(info);
                    }
                    info.textContent = 'Resubmission request sent to owner with reason.';
                    
                    // Hide reason input and reset buttons
                    document.getElementById('resubmitReasonSection').style.display = 'none';
                    document.getElementById('requestResubmitButton').style.display = 'inline-block';
                    document.getElementById('confirmResubmitButton').style.display = 'none';
                    document.getElementById('cancelResubmitButton').style.display = 'none';
                    
                    // Mark only this permit cell as resubmit-pending and disable Approve for this doc only
                    const row = document.getElementById('userRow' + currentUserId);
                    const permitCell = row ? row.querySelector(`div.permitCell[data-type="${currentDocumentType}"]`) : null;
                    if (permitCell) {
                        permitCell.dataset.resubmitPending = 'true';
                        
                        // Update the view button to show warning icon and set data-resubmitted to true
                        const viewButton = permitCell.querySelector('.viewPermitBtn');
                        if (viewButton) {
                            viewButton.setAttribute('data-resubmitted', 'true');
                            const icon = viewButton.querySelector('i');
                            if (icon) {
                                icon.className = 'fas fa-exclamation-triangle text-warning';
                            }
                            
                            // Debug logging
                            console.log('Debug - Resubmission Request:');
                            console.log('  permitCell:', permitCell);
                            console.log('  viewButton:', viewButton);
                            console.log('  data-resubmitted set to:', viewButton.getAttribute('data-resubmitted'));
                            console.log('  icon updated to:', icon ? icon.className : 'N/A');
                            
                            // Special debug for DTI
                            if (currentDocumentType === 'dti_permit') {
                                console.log('DTI DEBUG - Resubmission Request:');
                                console.log('  DTI permitCell found:', !!permitCell);
                                console.log('  DTI viewButton found:', !!viewButton);
                                console.log('  DTI data-resubmitted set to:', viewButton ? viewButton.getAttribute('data-resubmitted') : 'N/A');
                                console.log('  DTI icon updated to:', icon ? icon.className : 'N/A');
                            }
                        }
                        
                        // Update the status badge in the admin table to show "Resubmit"
                        const statusBadge = permitCell.querySelector('.badge');
                        if (statusBadge) {
                            statusBadge.className = 'badge badge-light-warning';
                            statusBadge.textContent = 'Resubmit';
                        }
                    }
                    const approveBtn = document.getElementById('approvePermitButton');
                    if (approveBtn) {
                        approveBtn.disabled = true;
                        approveBtn.title = 'Disabled: awaiting new upload after resubmission request for this permit';
                    }
                    
                    // Send real-time update to user's verified page (if they have it open)
                    // This will update the status on their end immediately
                    if (window.parent !== window) {
                        // If this is in an iframe, send message to parent
                        window.parent.postMessage({
                            type: 'permit_resubmitted',
                            userId: currentUserId,
                            documentType: currentDocumentType,
                            reason: reason
                        }, '*');
                    }
                    
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                })
                .catch(err => {
                    console.error('Resubmission Error:', err);
                    console.error('Error details:', {
                        message: err.message,
                        currentDocumentType: currentDocumentType,
                        currentUserId: currentUserId,
                        reason: reason
                    });
                    
                    let e = document.getElementById('approveError');
                    if (!e) {
                        e = document.createElement('div');
                        e.id = 'approveError';
                        e.className = 'text-danger small mt-2';
                        document.querySelector('#viewPermitModal .modal-footer').prepend(e);
                    }
                    e.textContent = `Failed to send resubmission request for ${currentDocumentType}. Error: ${err.message}`;
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
            });
            
            // (Resubmit removed)

            // Wire up View User Details modal
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const birthday = this.getAttribute('data-birthday') || 'N/A';
                    const gender = this.getAttribute('data-gender') || 'N/A';
                    const address = this.getAttribute('data-address') || 'N/A';
                    const phone = this.getAttribute('data-phone') || 'N/A';
                    const nationality = this.getAttribute('data-nationality') || 'N/A';
                    const ownerImage = this.getAttribute('data-owner-image') || '';
                    const firstName = this.getAttribute('data-first-name') || '';
                    const middleName = this.getAttribute('data-middle-name') || '';
                    const lastName = this.getAttribute('data-last-name') || '';
                    const username = this.getAttribute('data-username') || '';

                    // Calculate age from birthday
                    let age = 'N/A';
                    let formattedBirthday = 'N/A';
                    
                    if (birthday && birthday !== 'N/A' && birthday !== 'null') {
                        try {
                            const birthDate = new Date(birthday);
                            if (!isNaN(birthDate.getTime())) {
                                const today = new Date();
                                let calculatedAge = today.getFullYear() - birthDate.getFullYear();
                                const monthDiff = today.getMonth() - birthDate.getMonth();
                                
                                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                                    calculatedAge--;
                                }
                                
                                age = calculatedAge;
                                formattedBirthday = birthDate.toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                });
                            }
                        } catch (e) {
                            console.log('Error calculating age:', e);
                        }
                    }

                    const b = document.getElementById('detailBirthday');
                    const ageElement = document.getElementById('detailAge');
                    const g = document.getElementById('detailGender');
                    const a = document.getElementById('detailAddress');
                    const p = document.getElementById('detailPhone');
                    const n = document.getElementById('detailNationality');
                    const img = document.getElementById('detailOwnerImage');
                    
                    if (b) b.textContent = formattedBirthday;
                    if (ageElement) ageElement.textContent = age;
                    if (g) g.textContent = gender;
                    if (a) a.textContent = address;
                    if (p) p.textContent = phone;
                    if (n) n.textContent = nationality;
                    
                    // Get the user type from the current page context
                    const userType = '{{ $userType ?? "All Users" }}';
                    
                    const nameSpan = document.getElementById('detailFullName');
                    const usernameSpan = document.getElementById('detailUsername');
                    
                    if (nameSpan && usernameSpan) {
                        if (userType === 'Tourist Users') {
                            // For tourist users: show username in modal, full name in table
                            const parts = [firstName, middleName, lastName].filter(Boolean);
                            nameSpan.textContent = parts.join(' ');
                            usernameSpan.textContent = username;
                        } else {
                            // For resort/boat users: show full name in modal, username in table
                            const parts = [firstName, middleName, lastName].filter(Boolean);
                            nameSpan.textContent = parts.join(' ');
                            usernameSpan.textContent = username;
                        }
                    }
                    if (img) {
                        const placeholder = document.getElementById('avatarPlaceholder');
                        if (ownerImage) {
                            img.src = ownerImage;
                            img.style.display = 'block';
                            if (placeholder) placeholder.style.display = 'none';
                        } else {
                            img.src = '';
                            img.style.display = 'none';
                            if (placeholder) placeholder.style.display = 'flex';
                        }
                    }
                });
            });
            
            // Handle delete modal
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const form = document.getElementById('deleteUserForm');
                if(form) form.action = `/admin/users/${userId}`;
            });
            
            // Enable Bootstrap tooltips (for view button hover text)
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
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
        
        // Function to check for document updates and refresh UI
        function checkForDocumentUpdates() {
            // This function can be called periodically or when needed
            // to refresh the UI when users upload new documents
            const resubmittedButtons = document.querySelectorAll('.viewPermitBtn[data-resubmitted="true"]');
            resubmittedButtons.forEach(button => {
                const userId = button.getAttribute('data-user-id');
                const documentType = button.getAttribute('data-document-type');
                
                // Check if the document has been updated by making an AJAX request
                fetch(`/admin/check-document-status/${userId}/${documentType}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.resubmitted === false) {
                            // Document has been updated, reset the UI
                            button.setAttribute('data-resubmitted', 'false');
                            const icon = button.querySelector('i');
                            if (icon) {
                                icon.className = 'fas fa-eye';
                            }
                            
                            // Re-enable approve button if this is the current document being viewed
                            const currentDocumentType = document.querySelector('#viewPermitModal').dataset.currentDocumentType;
                            if (currentDocumentType === documentType) {
                                const approveBtn = document.getElementById('approvePermitButton');
                                if (approveBtn) {
                                    approveBtn.disabled = false;
                                    approveBtn.title = '';
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.log('Error checking document status:', error);
                    });
            });
        }
        
        // Check for document updates every 30 seconds
        setInterval(checkForDocumentUpdates, 30000);
        
        // --- End JavaScript ---
    </script>
    
    {{-- Modern CSS Styling --}}
    <style>
        /* Modern Background with Glassmorphism */
        .modern-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-gradient-1, .bg-gradient-2, .bg-gradient-3 {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.6;
        }
        
        .bg-gradient-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            top: -300px;
            left: -300px;
            animation: float 20s ease-in-out infinite;
        }
        
        .bg-gradient-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(45deg, #f093fb, #f5576c);
            top: 50%;
            right: -250px;
            animation: float 25s ease-in-out infinite reverse;
        }
        
        .bg-gradient-3 {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            bottom: -200px;
            left: 50%;
            animation: float 30s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Admin Container */
        .admin-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        
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
            border: none;
            background: none;
            width: 100%;
            text-align: left;
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
            margin-left: auto;
            transition: transform 0.3s ease;
        }
        
        .collapse-icon.rotated {
            transform: rotate(180deg);
        }
        
        .collapse .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            margin-left: 0.5rem;
        }

        .collapse .nav-link:hover {
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.05);
        }

        .collapse .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }
        

        /* Mobile Sidebar - aligned with admin dashboard */
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
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title-section {
            margin-bottom: 1.5rem;
        }
        
        .page-title {
            color: #2d3748;
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .page-subtitle {
            color: #718096;
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
        }
        
        .page-stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: white;
            color: #2c3e50;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            min-width: 140px;
            max-width: 160px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border-color: #007bff;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .stat-icon i {
            color: white;
            font-size: 1.25rem;
        }
        
        .stat-content {
            flex: 1;
            text-align: left;
        }
        
        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #2c3e50;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        /* Table Card */
        .table-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-title {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
        
        .table-actions {
            display: flex;
            gap: 1rem;
        }
        
        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .modern-table thead th {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            color: #4a5568;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }
        
        .modern-table thead th i {
            margin-right: 0.5rem;
            color: #667eea;
        }
        
        .modern-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }
        
        .modern-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }
        
        .modern-table tbody td {
            padding: 1.5rem;
            vertical-align: middle;
        }
        
        /* User Info Cell */
        .user-info-cell {
            min-width: 250px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }
        
        .user-details {
            flex: 1;
        }
        
        .user-name {
            color: #2d3748;
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
        }
        
        
        /* Contact and Address Cells */
        .contact-cell, .address-cell {
            min-width: 150px;
        }
        
        .contact-info, .address-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .contact-info i, .address-info i {
            color: #667eea;
            width: 16px;
        }
        
        /* Role Cell */
        .role-cell {
            min-width: 120px;
        }
        
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .role-resort-owner {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }
        
        .role-boat-owner {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }
        
        .role-tourist {
            background: rgba(168, 85, 247, 0.1);
            color: #9333ea;
        }
        
        /* Documents Cell */
        .documents-cell {
            min-width: 300px;
        }
        
        /* 2x2 Documents Grid */
        .documents-grid-2x2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 0.75rem;
        }
        
        .document-item {
            text-align: center;
            padding: 0.75rem 0.5rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }
        
        .document-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .document-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }
        
        .document-status {
            display: flex;
            justify-content: center;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 0.875rem;
        }
        
        .status-badge.approved {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }
        
        .status-badge.resubmit {
            background: rgba(245, 158, 11, 0.2);
            color: #d97706;
            border: 2px solid #f59e0b;
            font-weight: 600;
            animation: pulse-warning 2s infinite;
            min-width: 80px;
            padding: 4px 8px;
            border-radius: 12px;
        }
        
        @keyframes pulse-warning {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        
        .status-badge.not-uploaded {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }
        
        /* Status Cell */
        .status-cell {
            min-width: 120px;
        }
        
        .approval-status {
            display: flex;
            justify-content: center;
        }
        
        .status-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }
        
        /* Actions Cell */
        .actions-cell {
            min-width: 120px;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .view-btn:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }
        
        .delete-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }
        
        /* Modern Permit Modal Styling */
        .permit-modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .permit-modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1.5rem 2rem;
            position: relative;
        }

        .permit-modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .permit-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .permit-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .permit-header-text h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .permit-subtitle {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .permit-modal-body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .preview-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .preview-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f4;
        }

        .preview-title {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .preview-controls {
            margin-left: auto;
        }

        .preview-container {
            min-height: 500px;
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            position: relative;
        }

        .preview-content {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-wrapper {
            padding: 1rem;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-image {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .preview-image:hover {
            transform: scale(1.02);
        }

        .pdf-wrapper {
            position: relative;
            width: 100%;
            height: 500px;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pdf-iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .pdf-overlay {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
        }

        .unsupported-wrapper {
            text-align: center;
            padding: 3rem 2rem;
        }

        .unsupported-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .unsupported-wrapper h5 {
            color: #495057;
            margin-bottom: 1rem;
        }

        .unsupported-wrapper p {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .info-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            height: fit-content;
        }

        .info-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f4;
        }

        .info-title {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .info-content {
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.25rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 0.95rem;
            color: #2c3e50;
            font-weight: 500;
            word-break: break-word;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            flex-direction: row;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            display: inline-flex !important;
            flex-direction: row !important;
            white-space: nowrap !important;
        }

        .status-badge.approved {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: inline-flex !important;
            flex-direction: row !important;
            white-space: nowrap !important;
        }

        .status-badge span {
            display: inline !important;
            white-space: nowrap !important;
        }

        .status-badge i {
            margin-right: 0.25rem;
        }

        .action-section {
            border-top: 2px solid #f1f3f4;
            padding-top: 1.5rem;
        }

        .action-title {
            margin: 0 0 1rem 0;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1rem;
        }

        .action-buttons .btn {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .action-buttons .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .action-buttons .btn:hover::before {
            left: 100%;
        }

        .action-buttons .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .action-buttons .btn:active {
            transform: translateY(-1px);
        }

        .action-buttons .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .action-buttons .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1ea085);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        .action-buttons .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        .action-buttons .btn-warning:hover {
            background: linear-gradient(135deg, #e0a800, #e55a00);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
        }

        .resubmit-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .resubmit-header {
            margin-bottom: 1rem;
        }

        .resubmit-title {
            margin: 0;
            color: #856404;
            font-weight: 600;
        }

        .resubmit-textarea {
            border: 2px solid #ffeaa7;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
        }

        .resubmit-textarea:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .permit-modal-footer {
            background: #f8f9fa;
            border: none;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e9ecef;
        }

        .footer-actions {
            display: flex;
            gap: 0.75rem;
        }

        .permit-modal-footer .btn {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .permit-modal-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        
        /* Extra Large Screens (1400px and up) */
        @media (min-width: 1400px) {
            .admin-container {
                max-width: 1600px;
                margin: 0 auto;
            }
            
            .main-content {
                padding: 3rem;
            }
            
            .modern-sidebar {
                width: 320px;
                min-width: 320px;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .table-container {
                margin: 1rem 0;
                overflow-x: auto;
            }
            
            .table-header th,
            .table-row td {
                padding: 1rem 0.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .page-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .stat-card {
                min-width: 100px;
                max-width: 200px;
                margin: 0 auto;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .preview-container {
                min-height: 400px;
            }
            
            .permit-modal-body {
                padding: 1.5rem;
            }
            
            .documents-grid-2x2 {
                grid-template-columns: 1fr;
                gap: 0.5rem;
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
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .page-subtitle {
                font-size: 0.9rem;
            }
            
            .page-stats {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .stat-card {
                min-width: 80px;
                max-width: 150px;
                padding: 1rem;
            }
            
            .stat-icon {
                width: 35px;
                height: 35px;
            }
            
            .stat-icon i {
                font-size: 0.9rem;
            }
            
            .stat-number {
                font-size: 1.25rem;
            }
            
            .stat-label {
                font-size: 0.7rem;
            }
            
            .table-responsive {
                font-size: 0.8rem;
            }
            
            .table thead th {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }
            
            .table tbody td {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }
            
            .action-buttons .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.7rem;
            }
            
            .preview-container {
                min-height: 300px;
            }
            
            .permit-modal-body {
                padding: 1rem;
            }
            
            .permit-modal-header {
                padding: 1rem;
            }
            
            .permit-modal-title {
                font-size: 1.25rem;
            }
            
            .permit-info h6 {
                font-size: 0.9rem;
            }
            
            .permit-info p {
                font-size: 0.8rem;
            }
            
            .action-buttons {
                gap: 0.5rem;
            }
            
            .action-buttons .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .documents-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 400px) {
            .table-container {
                margin: 0.5rem 0;
                overflow-x: auto;
            }
            
            .modern-table {
                min-width: 600px;
            }
            
            .table-header th,
            .table-row td {
                padding: 0.4rem 0.2rem;
                font-size: 0.65rem;
            }
            
            .page-title {
                font-size: 1.1rem;
            }
            
            .page-subtitle {
                font-size: 0.8rem;
            }
            
            .stat-card {
                min-width: 60px;
                max-width: 120px;
                padding: 0.75rem;
            }
            
            .stat-icon {
                width: 30px;
                height: 30px;
            }
            
            .stat-icon i {
                font-size: 0.8rem;
            }
            
            .stat-number {
                font-size: 1rem;
            }
            
            .stat-label {
                font-size: 0.65rem;
            }
            
            .permit-modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .permit-modal-body {
                padding: 0.75rem;
            }
            
            .permit-modal-header {
                padding: 0.75rem;
            }
            
            .permit-modal-title {
                font-size: 1.1rem;
            }
            
            .permit-info h6 {
                font-size: 0.8rem;
            }
            
            .permit-info p {
                font-size: 0.7rem;
            }
            
            .action-buttons {
                gap: 0.25rem;
            }
            
            .action-buttons .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.7rem;
            }
            
            .documents-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .documents-grid-2x2 {
                gap: 0.5rem;
            }
            
            .document-card {
                padding: 0.5rem;
            }
            
            .document-card h6 {
                font-size: 0.8rem;
            }
            
            .document-card p {
                font-size: 0.7rem;
            }
            
            .btn-sm {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }
            
            .permit-modal-body {
                padding: 1.5rem;
            }
        }
        
        /* Extra Small Screens (576px to 767px) */
        @media (max-width: 767px) and (min-width: 576px) {
            .admin-container {
                flex-direction: row;
            }
            
            .modern-sidebar {
                width: 280px;
                min-width: 280px;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .modern-sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                padding: 1rem;
                margin-left: 0;
                width: 100%;
                border-radius: 0;
                min-height: auto;
            }
            
            
            .page-title {
                font-size: 2rem;
            }
            
            .page-stats {
                flex-direction: row;
                gap: 1rem;
                justify-content: flex-start;
            }
            
            .stat-card {
                min-width: 120px;
                max-width: 140px;
                padding: 1rem;
                gap: 0.75rem;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
            }
            
            .stat-icon i {
                font-size: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .stat-label {
                font-size: 0.8rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .preview-container {
                min-height: 350px;
            }
            
            .pdf-wrapper {
                height: 350px;
            }
            
            .permit-modal-header {
                padding: 1rem;
            }
            
            .permit-modal-body {
                padding: 1rem;
            }
            
            .permit-icon {
                width: 40px;
                height: 40px;
                margin-right: 0.75rem;
            }
            
            .permit-header-text h4 {
                font-size: 1.25rem;
            }
            
            .permit-subtitle {
                font-size: 0.8rem;
            }
            
            .info-section {
                margin-top: 1rem;
            }
            
            .permit-modal-footer {
                padding: 1rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .footer-actions {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* Very Small Screens (below 576px) */
        @media (max-width: 575px) {
            .admin-container {
                flex-direction: row;
            }
            
            .modern-sidebar {
                width: 280px;
                min-width: 280px;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .modern-sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                padding: 0.75rem;
                margin-left: 0;
                width: 100%;
                border-radius: 0;
                min-height: auto;
            }
            
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
            
            .page-title {
                font-size: 1.75rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .page-stats {
                flex-direction: row;
                gap: 0.75rem;
                justify-content: flex-start;
            }
            
            .stat-card {
                padding: 0.75rem;
                min-width: 100px;
                max-width: 120px;
                gap: 0.5rem;
            }
            
            .stat-icon {
                width: 35px;
                height: 35px;
            }
            
            .stat-icon i {
                font-size: 0.9rem;
            }
            
            .stat-number {
                font-size: 1.25rem;
            }
            
            .stat-label {
                font-size: 0.7rem;
            }
            
            .table-responsive {
                font-size: 0.8rem;
            }
            
            .table thead th {
                padding: 0.75rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .table tbody td {
                padding: 0.75rem 0.5rem;
            }
            
            .preview-container {
                min-height: 300px;
            }
            
            .pdf-wrapper {
                height: 300px;
            }
            
            .permit-modal-header {
                padding: 0.75rem;
            }
            
            .permit-modal-body {
                padding: 0.75rem;
            }
            
            .permit-icon {
                width: 35px;
                height: 35px;
                margin-right: 0.5rem;
            }
            
            .permit-header-text h4 {
                font-size: 1.1rem;
            }
            
            .permit-subtitle {
                font-size: 0.75rem;
            }
            
            .info-section {
                margin-top: 0.75rem;
                padding: 1rem;
            }
            
            .info-item {
                padding: 0.5rem;
                margin-bottom: 1rem;
            }
            
            .action-buttons .btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
            
            .permit-modal-footer {
                padding: 0.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .footer-actions {
                width: 100%;
                justify-content: center;
            }
            
            .permit-modal-footer .btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
        }
        
        /* Ultra Small Screens (below 400px) */
        @media (max-width: 399px) {
            .modern-sidebar {
                width: 100%;
                min-width: 100%;
            }
            
            .main-content {
                padding: 0.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .stat-card {
                padding: 0.75rem;
                min-width: 80px;
            }
            
            .stat-number {
                font-size: 1.25rem;
            }
            
            .table thead th {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }
            
            .table tbody td {
                padding: 0.5rem 0.25rem;
            }
            
            .preview-container {
                min-height: 250px;
            }
            
            .pdf-wrapper {
                height: 250px;
            }
            
            .permit-modal-header {
                padding: 0.5rem;
            }
            
            .permit-modal-body {
                padding: 0.5rem;
            }
            
            .info-section {
                padding: 0.75rem;
            }
            
            .action-buttons .btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }
        }
            
            .page-stats {
                flex-direction: row;
                gap: 0.5rem;
                justify-content: flex-start;
            }
            
            .stat-card {
                min-width: 80px;
                max-width: 100px;
                padding: 0.5rem;
                gap: 0.25rem;
            }
            
            .stat-icon {
                width: 30px;
                height: 30px;
            }
            
            .stat-icon i {
                font-size: 0.8rem;
            }
            
            .stat-number {
                font-size: 1rem;
            }
            
            .stat-label {
                font-size: 0.65rem;
            }
            
            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .modern-table {
                font-size: 0.875rem;
            }
            
            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.75rem;
            }
            
            .documents-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 16px 16px 0 0;
        }
        
        .btn-close-white {
            filter: brightness(0) invert(1);
        }

        /* User Details Modal Styling */
        .user-details-modal {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .user-details-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .user-details-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .user-avatar-section {
            flex-shrink: 0;
        }

        .user-avatar-large {
            position: relative;
            width: 80px;
            height: 80px;
        }

        .avatar-large-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .avatar-placeholder-large {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .avatar-placeholder-large i {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .user-title-section {
            flex: 1;
        }

        .user-title-section .modal-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .user-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        .user-details-body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .user-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .info-icon i {
            color: white;
            font-size: 1.1rem;
        }

        .info-content {
            flex: 1;
            min-width: 0;
        }

        .info-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            display: block;
            font-size: 1rem;
            font-weight: 500;
            color: #2c3e50;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .user-details-footer {
            background: white;
            border: none;
            padding: 1.5rem 2rem;
            border-radius: 0 0 20px 20px;
        }

        .user-details-footer .btn {
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .user-details-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }

        /* Responsive Design for Modal */
        @media (max-width: 768px) {
            .user-details-header {
                padding: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .user-avatar-large {
                width: 70px;
                height: 70px;
            }

            .user-title-section .modal-title {
                font-size: 1.5rem;
            }

            .user-details-body {
                padding: 1.5rem;
            }

            .user-info-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .info-item {
                padding: 1rem;
            }

            .info-icon {
                width: 40px;
                height: 40px;
            }

            .info-icon i {
                font-size: 1rem;
            }

            .user-details-footer {
                padding: 1rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .user-details-header {
                padding: 1rem;
            }

            .user-avatar-large {
                width: 60px;
                height: 60px;
            }

            .user-title-section .modal-title {
                font-size: 1.25rem;
            }

            .user-details-body {
                padding: 1rem;
            }

            .info-item {
                padding: 0.875rem;
                gap: 0.75rem;
            }

            .info-icon {
                width: 35px;
                height: 35px;
            }

            .info-icon i {
                font-size: 0.9rem;
            }

            .info-label {
                font-size: 0.8rem;
            }

            .info-value {
                font-size: 0.9rem;
            }
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
    </style>
</x-app-layout>