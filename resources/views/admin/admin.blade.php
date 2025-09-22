<x-app-layout>
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
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Admin Dashboard
                        </h1>
                        <p class="page-subtitle">Welcome back! Here's what's happening with your tourism management system.</p>
                    </div>
                    <div class="page-stats">
                        <div class="stat-card">
                            <div class="stat-number">{{ ($totalForeigners ?? 0) + ($totalFilipinos ?? 0) }}</div>
                            <div class="stat-label">Total Users</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ ($dayTourCount ?? 0) + ($overnightCount ?? 0) }}</div>
                            <div class="stat-label">Total Bookings</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid py-4">
                <div class="row g-4 justify-content-start"> {{-- Use justify-content-start to align left like the image --}}

                    {{-- Foreigners Card --}}
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('admin.foreign') }}" class="text-decoration-none">
                            <div class="stats-card foreign-card">
                                <div class="stats-card-header">
                                    <div class="stats-icon foreign-icon">
                                        <img src="{{ asset('images/flag1.png') }}" alt="Foreign Flag" class="stats-icon-img">
                                        </div>
                                    <div class="stats-info">
                                        <h6 class="stats-title">Other Nationalities</h6>
                                        <p class="stats-subtitle">International visitors</p>
                                    </div>
                                </div>
                                <div class="stats-card-body">
                                    <div class="stats-number" id="foreignersCount">{{ $totalForeigners ?? 0 }}</div>
                                    <div class="stats-subtitle mb-2">
                                        <small class="text-muted">Registered Users</small>
                                    </div>
                                    <div class="stats-number" style="font-size: 1.5rem; color: #17a2b8;">{{ $foreignGuests ?? 0 }}</div>
                                    <div class="stats-trend">
                                        <i class="fas fa-users me-1"></i>
                                        <span>Guest Visitors</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Filipino Card --}}
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('admin.total-filipino') }}" class="text-decoration-none">
                            <div class="stats-card filipino-card">
                                <div class="stats-card-header">
                                    <div class="stats-icon filipino-icon">
                                        <img src="{{ asset('images/flag.png') }}" alt="Philippine Flag" class="stats-icon-img">
                                        </div>
                                    <div class="stats-info">
                                        <h6 class="stats-title">Local Filipino</h6>
                                        <p class="stats-subtitle">Domestic visitors</p>
                                    </div>
                                </div>
                                <div class="stats-card-body">
                                    <div class="stats-number" id="filipinoCount">{{ $totalFilipinos ?? 0 }}</div>
                                    <div class="stats-subtitle mb-2">
                                        <small class="text-muted">Registered Users</small>
                                    </div>
                                    <div class="stats-number" style="font-size: 1.5rem; color: #28a745;">{{ $filipinoGuests ?? 0 }}</div>
                                    <div class="stats-trend">
                                        <i class="fas fa-users me-1"></i>
                                        <span>Guest Visitors</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- You can add more boxes here if needed, following the same structure --}}

                </div>


                {{-- Tour Type Statistics Chart --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="chart-container">
                            <div class="chart-header">
                                <div class="chart-title-section">
                                    <h3 class="chart-title">
                                        <i class="fas fa-chart-bar me-2"></i>
                                        Tour Type Statistics
                                    </h3>
                                    <p class="chart-subtitle">Distribution of day tours vs overnight stays</p>
                                </div>
                                <!-- <div class="chart-actions">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>
                                        Export
                                    </button>
                                </div> -->
                            </div>
                            <div class="chart-content">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-wrapper">
                                        <canvas id="tourTypeChart" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="chart-legend">
                                            <div class="legend-item">
                                                <div class="legend-color day-tour-color"></div>
                                                <div class="legend-info">
                                                    <h6 class="legend-title">Day Tours</h6>
                                                    <span class="legend-count">{{ $dayTourCount ?? 0 }} bookings</span>
                                                    <div class="legend-percentage">
                                                        {{ $dayTourCount > 0 || $overnightCount > 0 ? round(($dayTourCount / (($dayTourCount ?? 0) + ($overnightCount ?? 0))) * 100) : 0 }}%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color overnight-color"></div>
                                                <div class="legend-info">
                                                    <h6 class="legend-title">Overnight Stays</h6>
                                                    <span class="legend-count">{{ $overnightCount ?? 0 }} bookings</span>
                                                    <div class="legend-percentage">
                                                        {{ $overnightCount > 0 || $dayTourCount > 0 ? round(($overnightCount / (($dayTourCount ?? 0) + ($overnightCount ?? 0))) * 100) : 0 }}%
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Boat Revenue (per Boat Owner) Chart --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="chart-container">
                            <div class="chart-header">
                                <div class="chart-title-section">
                                    <h3 class="chart-title">
                                        <i class="fas fa-coins me-2"></i>
                                        Boat Revenue (Total Income per Boat Owner)
                                    </h3>
                                    <p class="chart-subtitle">Aggregated revenue by boat owners</p>
                                </div>
                            </div>
                            <div class="chart-content">
                                @php
                                    $boatRevenueLabels = $boatRevenueLabels ?? [];
                                    $boatRevenueTotals = $boatRevenueTotals ?? [];
                                    $boatRevenueTotalSum = is_array($boatRevenueTotals) ? array_sum($boatRevenueTotals) : 0;
                                @endphp
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-wrapper">
                                            <canvas id="boatRevenueChart" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="chart-legend">
                                            @foreach($boatRevenueLabels as $i => $label)
                                                @php
                                                    $amt = (float)($boatRevenueTotals[$i] ?? 0);
                                                    $pct = $boatRevenueTotalSum > 0 ? round(($amt / $boatRevenueTotalSum) * 100) : 0;
                                                @endphp
                                                <div class="legend-item">
                                                    <div class="legend-color" style="background: linear-gradient(135deg, #20c997 0%, #17a589 100%);"></div>
                                                    <div class="legend-info">
                                                        <h6 class="legend-title">{{ $label }}</h6>
                                                        <span class="legend-count">₱{{ number_format($amt, 2) }}</span>
                                                        <div class="legend-percentage">{{ $pct }}%</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="legend-item" style="background: #fff; border: 1px solid #eee;">
                                                <div class="legend-color" style="background: #999;"></div>
                                                <div class="legend-info">
                                                    <h6 class="legend-title">Total</h6>
                                                    <span class="legend-count">₱{{ number_format($boatRevenueTotalSum, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

        /* Navbar offset and hamburger visibility (match boat owner) */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        .hamburger-btn {
            display: none !important;
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
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
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

        /* Statistics Cards */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .foreign-card {
            border-left: 4px solid #17a2b8;
        }

        .filipino-card {
            border-left: 4px solid #28a745;
        }

        .stats-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .foreign-icon {
            background: linear-gradient(135deg, #e0f2f7 0%, #b8e6f0 100%);
        }

        .filipino-icon {
            background: linear-gradient(135deg, #e6ffe6 0%, #c8f7c5 100%);
        }

        .stats-icon-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .stats-info {
            flex: 1;
        }

        .stats-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 0.25rem 0;
        }

        .stats-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            margin: 0;
        }

        .stats-card-body {
            text-align: left;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stats-trend {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stats-trend i {
            color: #007bff;
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chart-header {
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid #f1f3f4;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
        }

        .chart-title i {
            color: #007bff;
        }

        .chart-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .chart-actions .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .chart-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .chart-content {
            padding: 2rem;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
        }

        .chart-legend {
            padding: 1rem 0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .legend-item:hover {
            background: #e9ecef;
            transform: translateX(4px);
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .day-tour-color {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .overnight-color {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .legend-info {
            flex: 1;
        }

        .legend-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 0.25rem 0;
        }

        .legend-count {
            font-size: 0.85rem;
            color: #6c757d;
            display: block;
            margin-bottom: 0.25rem;
        }

        .legend-percentage {
            font-size: 0.9rem;
            font-weight: 600;
            color: #007bff;
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
            
            .chart-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .chart-content {
                padding: 1rem;
            }
            
            .chart-wrapper {
                height: 250px;
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
                gap: 0.5rem;
            }
            
            .stat-card {
                min-width: 100px;
                padding: 0.75rem;
            }
            
            .stats-card {
                padding: 1rem;
            }
            
            .stats-card-header {
                margin-bottom: 1rem;
            }
            
            .stats-icon {
                width: 50px;
                height: 50px;
            }
            
            .stats-icon-img {
                width: 28px;
                height: 28px;
            }
            
            .stats-number {
                font-size: 2rem;
            }
            
            .chart-header {
                padding: 1rem;
            }
            
            .chart-title {
                font-size: 1.2rem;
            }
            
            .chart-content {
                padding: 0.75rem;
            }
            
            .chart-wrapper {
                height: 200px;
            }
            
            .legend-item {
                padding: 0.75rem;
                margin-bottom: 1rem;
            }
        }
    </style>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom JavaScript to handle offcanvas hiding and chart --}}
    <script>
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
            // --- End JavaScript for Offcanvas ---

            // Rotate Users dropdown arrow on show/hide
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });

            // --- JavaScript for Tour Type Chart ---
            const ctx = document.getElementById('tourTypeChart').getContext('2d');
            const tourTypeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Day Tours', 'Overnight Stays'],
                    datasets: [{
                        label: 'Number of Bookings',
                        data: [{{ $dayTourCount ?? 0 }}, {{ $overnightCount ?? 0 }}],
                        backgroundColor: [
                            '#3498db', // Blue for day tours
                            '#e74c3c'  // Red for overnight stays
                        ],
                        borderColor: [
                            '#2980b9', // Darker blue border
                            '#c0392b'  // Darker red border
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend since we have custom legend
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' bookings';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#666',
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: '#666',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
            // --- End JavaScript for Chart ---

            // --- JavaScript for Boat Revenue Chart ---
            const boatRevEl = document.getElementById('boatRevenueChart');
            if (boatRevEl) {
                const boatRevenueCtx = boatRevEl.getContext('2d');
                const boatOwnerLabels = {!! json_encode($boatRevenueLabels ?? []) !!};
                const boatOwnerTotals = {!! json_encode($boatRevenueTotals ?? []) !!};
                new Chart(boatRevenueCtx, {
                    type: 'bar',
                    data: {
                        labels: boatOwnerLabels,
                        datasets: [{
                            label: 'Total Income (₱)',
                            data: boatOwnerTotals,
                            backgroundColor: '#20c997',
                            borderColor: '#17a589',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const val = context.parsed.y || 0;
                                        return '₱' + val.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#666',
                                    callback: function(value) {
                                        return '₱' + Number(value).toLocaleString();
                                    }
                                },
                                grid: { color: 'rgba(0,0,0,0.1)', drawBorder: false }
                            },
                            x: { ticks: { color: '#666' }, grid: { display: false } }
                        },
                        animation: { duration: 1500, easing: 'easeInOutQuart' }
                    }
                });
            }
            // --- End JavaScript for Boat Revenue Chart ---
        });
    </script>
</x-app-layout>