<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- You might want to include your sidebar here --}}
        {{-- Example: @include('admin.partials.sidebar') --}}
        {{-- For now, just a placeholder, you can copy the sidebar content here if not using partials --}}
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
        {{-- End of desktop sidebar --}}

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start modern-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <div class="mobile-sidebar-brand">
                    <div class="mobile-brand-icon">
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title">Admin Menu</h5>
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

        <div class="main-content flex-grow-1">
            {{-- Page Header --}}
            <div class="page-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="page-title-section">
                        <h1 class="page-title">
                            <i class="fas fa-globe-americas me-2"></i>
                            Foreign Users & Guests
                        </h1>
                        <p class="page-subtitle">List of all foreign registered users and guest visitors</p>
                    </div>
                    <div class="page-stats">
                        <div class="stat-card">
                            <div class="stat-number">{{ $registeredForeigners->count() }}</div>
                            <div class="stat-label">Registered Foreign Users</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $guestForeigners->count() }}</div>
                            <div class="stat-label">Foreign Guest Visitors</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Registered Users Section --}}
            <div class="table-container mb-4">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-users me-2"></i>
                        Registered Foreign Users
                    </h3>
                    <span class="badge bg-primary">{{ $registeredForeigners->count() }} users</span>
                </div>
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="table-header">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Email</th>
                                <th scope="col">Registered Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registeredForeigners as $user)
                                <tr class="table-row">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="name-cell">
                                        <div class="user-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    </td>
                                    <td class="nationality-cell">
                                        <div class="nationality-info">
                                            <i class="fas fa-flag text-info me-1"></i>
                                            {{ $user->nationality }}
                                        </div>
                                    </td>
                                    <td class="email-cell">
                                        <div class="email-info">{{ $user->email }}</div>
                                    </td>
                                    <td class="date-cell">
                                        <div class="date-info">
                                            <i class="fas fa-calendar text-primary me-1"></i>
                                            {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center empty-state-cell">
                                        <div class="empty-state">
                                            <i class="fas fa-users empty-icon"></i>
                                            <h5 class="empty-title">No Registered Foreign Users</h5>
                                            <p class="empty-description">There are no foreign registered users in the system yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Guest Visitors Section --}}
            <div class="table-container">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-user-friends me-2"></i>
                        Foreign Guest Visitors
                    </h3>
                    <span class="badge bg-success">{{ $guestForeigners->count() }} guests</span>
                </div>
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="table-header">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Booking Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guestForeigners as $guest)
                                <tr class="table-row">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="name-cell">
                                        <div class="user-name">{{ $guest->guest_name }}</div>
                                    </td>
                                    <td class="nationality-cell">
                                        <div class="nationality-info">
                                            <i class="fas fa-flag text-info me-1"></i>
                                            {{ $guest->guest_nationality }}
                                        </div>
                                    </td>
                                    <td class="date-cell">
                                        <div class="date-info">
                                            <i class="fas fa-calendar text-primary me-1"></i>
                                            {{ $guest->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center empty-state-cell">
                                        <div class="empty-state">
                                            <i class="fas fa-user-friends empty-icon"></i>
                                            <h5 class="empty-title">No Foreign Guest Visitors</h5>
                                            <p class="empty-description">There are no foreign guest visitors in the system yet.</p>
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

        .collapse-icon { 
            transition: transform 0.3s ease; 
        }
        .collapse-icon.rotated { 
            transform: rotate(180deg); 
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
            margin-left: 280px;
            overflow-y: auto;
        }

        /* Page Header Styles */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border-left: 4px solid #17a2b8;
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
            color: #17a2b8;
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
            background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            min-width: 120px;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
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

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 1.5rem 1rem 1.5rem;
            border-bottom: 2px solid #f1f3f4;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: #007bff;
        }

        .badge {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 1rem;
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

        /* Name Cell */
        .name-cell {
            min-width: 120px;
            max-width: 150px;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-name:hover {
            transform: scale(1.05);
            color: #17a2b8;
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

        /* Nationality Cell */
        .nationality-cell {
            min-width: 120px;
            max-width: 150px;
        }

        .nationality-info {
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

        .nationality-info:hover {
            transform: scale(1.05);
            color: #17a2b8;
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

        /* Date Cell */
        .date-cell {
            min-width: 120px;
            max-width: 150px;
        }

        .date-info {
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

        .date-info:hover {
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
            .page-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .stat-card {
                min-width: 100px;
                padding: 1rem;
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
                flex-direction: row;
                gap: 0.75rem;
            }
            
            .stat-card {
                min-width: 80px;
                padding: 0.75rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .table-header th {
                padding: 1rem 0.75rem;
                font-size: 0.8rem;
            }
            
            .table-row td {
                padding: 1rem 0.75rem;
            }
            
            .name-cell, .nationality-cell, .date-cell, .email-cell {
                min-width: 100px;
                max-width: 120px;
            }

            .email-cell {
                min-width: 200px;
                max-width: 250px;
            }

            .email-info {
                font-size: 0.85rem;
                color: #6c757d;
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
            
            .page-subtitle {
                font-size: 0.9rem;
            }
            
            .page-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .stat-card {
                min-width: 100px;
                padding: 0.75rem;
            }
            
            .table-container {
                margin-top: 0.5rem;
            }
            
            .table-header th {
                padding: 0.75rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .table-row td {
                padding: 0.75rem 0.5rem;
            }
            
            .name-cell, .nationality-cell, .date-cell, .email-cell {
                min-width: 80px;
                max-width: 100px;
            }

            .email-cell {
                min-width: 150px;
                max-width: 200px;
            }
            
            .user-name, .nationality-info, .date-info {
                font-size: 0.8rem;
            }
        }

        /* Mobile Sidebar Styles */
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
        });
    </script>
</x-app-layout>