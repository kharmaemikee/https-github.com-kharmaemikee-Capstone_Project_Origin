<x-app-layout>
    {{-- Apply min-vh-100 to the main flex container with gradient background --}}
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
            <div class="page-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="page-title-section">
                        <h1 class="page-title">
                            <i class="fas fa-hotel me-2"></i>
                            Resort Information
                        </h1>
                        <p class="page-subtitle">Manage and monitor all resort registrations</p>
                    </div>
                    <div class="page-stats">
                        <div class="stat-card">
                            <div class="stat-number">{{ $resorts->count() }}</div>
                            <div class="stat-label">Total Resorts</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Resorts Table --}}
            <div class="table-container">
            <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="table-header">
                        <tr>
                                <th scope="col" class="text-center">Image</th>
                            <th scope="col">Resort Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Contact</th>
                                <th scope="col" class="text-center">Owner Status</th>
                                <th scope="col" class="text-center">Admin Status</th>
                                <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($resorts as $resort)
                                <tr class="table-row">
                                    <td class="image-cell">
                                        <div class="resort-image-wrapper">
                                    @if ($resort->image_path)
                                        <img src="{{ asset($resort->image_path) }}"
                                            alt="{{ $resort->resort_name }}"
                                                    class="resort-table-image"
                                            onerror="handleImageError(this, '{{ asset('images/default_resort.png') }}')">
                                    @else
                                        <img src="{{ asset('images/default_resort.png') }}"
                                            alt="Default Resort Image"
                                                    class="resort-table-image">
                                    @endif
                                        </div>
                                </td>
                                    <td class="resort-name-cell">
                                        <div class="resort-name">{{ $resort->resort_name }}</div>
                                    </td>
                                    <td class="location-cell">
                                        <div class="location-info">
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            {{ $resort->location }}
                                        </div>
                                    </td>
                                    <td class="contact-cell">
                                        <div class="contact-info">
                                            <i class="fas fa-phone text-success me-1"></i>
                                            {{ $resort->contact_number }}
                                        </div>
                                    </td>
                                    <td class="status-cell text-center">
                                    @php
                                        $ownerStatusClass = '';
                                        switch ($resort->status) {
                                                case 'open': $ownerStatusClass = 'badge-success'; break;
                                                case 'closed': $ownerStatusClass = 'badge-dark'; break;
                                                case 'rehab': $ownerStatusClass = 'badge-warning'; break;
                                                default: $ownerStatusClass = 'badge-secondary'; break;
                                        }
                                    @endphp
                                        <span class="badge {{ $ownerStatusClass }} status-badge">
                                            {{ ucfirst($resort->status ?? 'N/A') }}
                                        </span>
                                </td>
                                    <td class="admin-status-cell text-center">
                                    @php
                                        $adminStatusClass = '';
                                        switch ($resort->admin_status) {
                                                case 'pending': $adminStatusClass = 'badge-info'; break;
                                                case 'approved': $adminStatusClass = 'badge-success'; break;
                                                case 'rejected': $adminStatusClass = 'badge-danger'; break;
                                                default: $adminStatusClass = 'badge-secondary'; break;
                                        }
                                    @endphp
                                        <span class="badge {{ $adminStatusClass }} status-badge">
                                            {{ ucfirst($resort->admin_status ?? 'N/A') }}
                                        </span>
                                    @if (($resort->admin_status ?? '') === 'rejected' && $resort->rejection_reason)
                                            <div class="rejection-reason-small">
                                                <small class="text-muted">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    {{ Str::limit($resort->rejection_reason, 30) }}
                                                </small>
                                            </div>
                                    @endif
                                </td>
                                    <td class="actions-cell text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.resort.show', $resort->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>
                                                View
                                            </a>

                                        @if (($resort->admin_status ?? '') === 'pending')
                                                <button type="button" class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                                    data-item-id="{{ $resort->id }}"
                                                    data-item-name="{{ $resort->resort_name }}"
                                                    data-action-type="approve"
                                                    data-target-type="resort">
                                                    <i class="fas fa-check me-1"></i>
                                                Approve
                                            </button>

                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                                    data-item-id="{{ $resort->id }}"
                                                    data-item-name="{{ $resort->resort_name }}"
                                                    data-action-type="reject"
                                                    data-target-type="resort">
                                                    <i class="fas fa-times me-1"></i>
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                    <td colspan="7" class="text-center empty-state-cell">
                                        <div class="empty-state">
                                            <i class="fas fa-hotel empty-icon"></i>
                                            <h5 class="empty-title">No Resorts Found</h5>
                                            <p class="empty-description">There are no resorts registered in the system yet.</p>
                                        </div>
                                    </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Unified Admin Action Confirmation Modal (for both resort and room actions) --}}
    <div class="modal fade" id="adminActionModal" tabindex="-1" aria-labelledby="adminActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="adminActionForm" method="POST">
                    @csrf
                    @method('PATCH') {{-- Both approve and reject will use PATCH --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminActionModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modalActionMessage"></p>
                        <div id="rejectionReasonGroup" class="mb-3" style="display: none;">
                            <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="confirmActionButton" class="btn rounded-pill">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        /* Page Header Styles */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border-left: 4px solid #007bff;
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

        .page-stats {
            display: flex;
            gap: 1rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            min-width: 120px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Modern Alert Styles */
        .modern-alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modern-alert.alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .modern-alert.alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid #dc3545;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 1rem;
            max-width: 100%;
            overflow-x: auto;
        }

        /* Modern Table */
        .modern-table {
            margin: 0;
            border: none;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 2px solid #dee2e6;
        }

        .table-header th {
            border: none;
            padding: 1.5rem 1rem;
            font-weight: 700;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            vertical-align: middle;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .table-row:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row td {
            border: none;
            padding: 1.5rem 1rem;
            vertical-align: middle;
        }

        /* Image Cell */
        .image-cell {
            width: 60px;
        }

        .resort-image-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .resort-image-wrapper:hover {
            transform: scale(1.1);
        }

        .resort-table-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Resort Name Cell */
        .resort-name-cell {
            min-width: 150px;
            max-width: 200px;
        }

        .resort-name {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resort-name:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 1.05rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Location Cell */
        .location-cell {
            min-width: 120px;
            max-width: 150px;
        }

        .location-info {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-weight: 500;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .location-info:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 0.95rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Contact Cell */
        .contact-cell {
            min-width: 100px;
            max-width: 120px;
        }

        .contact-info {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-weight: 500;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-info:hover {
            transform: scale(1.05);
            color: #28a745;
            font-size: 0.95rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Status Cells */
        .status-cell,
        .admin-status-cell {
            min-width: 100px;
            max-width: 120px;
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }

        .status-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .rejection-reason-small {
            margin-top: 0.5rem;
        }

        /* Actions Cell */
        .actions-cell {
            min-width: 150px;
            max-width: 180px;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-buttons .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .action-buttons .btn:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        /* Empty State */
        .empty-state-cell {
            padding: 4rem 2rem !important;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: #adb5bd;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .table-container {
                margin: 1rem 0;
                overflow-x: auto;
            }
            
            .table-header th,
            .table-row td {
                padding: 1rem 0.75rem;
            }
            
            .resort-name-cell {
                min-width: 120px;
                max-width: 150px;
            }
            
            .location-cell {
                min-width: 100px;
                max-width: 120px;
            }
            
            .contact-cell {
                min-width: 80px;
                max-width: 100px;
            }
            
            .status-cell,
            .admin-status-cell {
                min-width: 80px;
                max-width: 100px;
            }
            
            .actions-cell {
                min-width: 120px;
                max-width: 150px;
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

            .hamburger-btn {
                display: block !important;
            }

            .modern-navbar {
                left: 0;
                width: 100%;
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
                gap: 0.5rem;
            }
            
            .stat-card {
                min-width: 100px;
                padding: 1rem;
            }
            
            .table-container {
                margin: 1rem 0;
                border-radius: 12px;
            }
            
            .table-header th,
            .table-row td {
                padding: 1rem 0.5rem;
                font-size: 0.85rem;
            }
            
            .resort-image-wrapper {
                width: 40px;
                height: 40px;
            }
            
            .resort-name {
                font-size: 0.9rem;
            }
            
            .location-info,
            .contact-info {
                font-size: 0.8rem;
            }
            
            .status-badge {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .action-buttons .btn {
                font-size: 0.7rem;
                padding: 0.3rem 0.5rem;
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
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .table-container {
                margin: 0.75rem 0;
                border-radius: 8px;
            }
            
            .table-header th {
                padding: 0.75rem 0.25rem;
                font-size: 0.75rem;
            }
            
            .table-row td {
                padding: 0.75rem 0.25rem;
                font-size: 0.8rem;
            }
            
            .resort-image-wrapper {
                width: 40px;
                height: 40px;
            }
            
            .resort-name {
                font-size: 0.9rem;
            }
            
            .location-info,
            .contact-info {
                font-size: 0.8rem;
            }
            
            .location-info i,
            .contact-info i {
                font-size: 0.7rem;
            }
            
            .status-badge {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
            }
            
            .action-buttons .btn {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
            
            .empty-state {
                padding: 1.5rem 1rem;
            }
            
            .empty-icon {
                font-size: 2.5rem;
            }
            
            .empty-title {
                font-size: 1rem;
            }
            
            .empty-description {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .table-container {
                margin: 0.5rem 0;
            }
            
            .table-header th,
            .table-row td {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }
            
            .resort-image-wrapper {
                width: 35px;
                height: 35px;
            }
            
            .resort-name {
                font-size: 0.8rem;
            }
            
            .location-info,
            .contact-info {
                font-size: 0.75rem;
            }
            
            .status-badge {
                padding: 0.25rem 0.5rem;
                font-size: 0.65rem;
            }
            
            .action-buttons .btn {
                font-size: 0.65rem;
                padding: 0.2rem 0.4rem;
            }
        }
        /* Enhanced Status Badge Colors for Better Visibility */
        .badge-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            color: white !important;
            border: 2px solid #1e7e34 !important;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3) !important;
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
            color: #212529 !important;
            border: 2px solid #e0a800 !important;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3) !important;
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            color: white !important;
            border: 2px solid #bd2130 !important;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;
        }

        .badge-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
            color: white !important;
            border: 2px solid #117a8b !important;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3) !important;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
            color: white !important;
            border: 2px solid #545b62 !important;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3) !important;
        }

        .badge-dark {
            background: linear-gradient(135deg, #343a40 0%, #212529 100%) !important;
            color: white !important;
            border: 2px solid #1d2124 !important;
            box-shadow: 0 2px 8px rgba(52, 58, 64, 0.3) !important;
        }

        /* Legacy badge styles for compatibility */
        .badge-light-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
            color: #155724 !important;
            border: 2px solid #b8dacc !important;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2) !important;
        }

        .badge-light-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
            color: #85640a !important;
            border: 2px solid #ffd43b !important;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2) !important;
        }

        .badge-light-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
            color: #721c24 !important;
            border: 2px solid #f1b0b7 !important;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2) !important;
        }

        .badge-light-info {
            background: linear-gradient(135deg, #e0f7fa 0%, #b8daff 100%) !important;
            color: #0c5460 !important;
            border: 2px solid #9fcdff !important;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2) !important;
        }

        .badge-light-secondary {
            background: linear-gradient(135deg, #e2e3e5 0%, #d3d6da 100%) !important;
            color: #383d41 !important;
            border: 2px solid #c6c8ca !important;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.2) !important;
        }

        .badge-light-black {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            color: #212529 !important;
            border: 2px solid #dee2e6 !important;
            box-shadow: 0 2px 8px rgba(52, 58, 64, 0.2) !important;
        }

        /* Modal Footer Buttons */
        #adminActionModal .modal-footer .btn-secondary {
            border-radius: 25px !important; /* Apply rounded pill to Cancel button */
            padding: 8px 20px;
        }

        #adminActionModal #confirmActionButton {
            border-radius: 25px !important; /* Apply rounded pill to Confirm button */
            padding: 8px 20px;
        }

        /* Ensure confirm button gets its specific color from BS classes if not overridden */
        #adminActionModal #confirmActionButton.btn-success {
             background-color: #198754 !important; /* Bootstrap success green */
             border-color: #198754 !important;
        }

        #adminActionModal #confirmActionButton.btn-danger {
             background-color: #dc3545 !important; /* Bootstrap danger red */
             border-color: #dc3545 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });
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
            // --- End JavaScript for Offcanvas Hiding ---


            // --- JavaScript for Admin Action Modal Logic ---
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
                confirmActionButton.className = 'btn rounded-pill'; // Reset classes before adding new ones

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
                    confirmActionButton.classList.add('btn-success'); // Keep Bootstrap color
                } else if (actionType === 'reject') {
                    modalTitle.textContent = 'Reject ' + itemTypeDisplay;
                    modalActionMessage.textContent = 'Are you sure you want to reject "' + itemName + '"? Please provide a reason.';
                    rejectionReasonGroup.style.display = 'block';
                    rejectionReasonTextarea.required = true;
                    adminActionForm.action = routePrefix + itemId + '/reject';
                    confirmActionButton.textContent = 'Confirm Reject';
                    confirmActionButton.classList.add('btn-danger'); // Keep Bootstrap color
                }
            });
            // --- End JavaScript for Admin Action Modal Logic ---
        });
    </script>
</x-app-layout>