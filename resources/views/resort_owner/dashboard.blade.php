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
            <div class="container-fluid">
                {{-- Page Header --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1">Dashboard</h2>
                                <p class="text-muted mb-0">Welcome back, {{ auth()->user()->first_name }}!</p>
                        </div>
                            <div class="text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ now()->format('F d, Y') }}
                                    </div>
                                </div>
                                    </div>
                                </div>

                {{-- Statistics Cards --}}
                <div class="row mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon bg-primary">
                            <i class="fas fa-hotel"></i>
                                    </div>
                            <div class="stats-content">
                                <h3 class="stats-number">{{ $totalBookings ?? 0 }}</h3>
                                <p class="stats-label">Total Bookings</p>
                                </div>
                                    </div>
                                </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stats-content">
                                <h3 class="stats-number">{{ $activeBookings ?? 0 }}</h3>
                                <p class="stats-label">Active Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon bg-info">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stats-content">
                                <h3 class="stats-number">{{ $totalGuests ?? 0 }}</h3>
                                <p class="stats-label">Total Guests</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                        <div class="stats-card clickable-card" data-bs-toggle="modal" data-bs-target="#revenueBreakdownModal" style="cursor: pointer;">
                            <div class="stats-icon bg-warning">
                                <i class="fas fa-peso-sign"></i>
                            </div>
                            <div class="stats-content">
                                <h3 class="stats-number mb-1">₱{{ number_format($totalRevenue ?? 0) }}</h3>
                                <span class="stats-label">Total Revenue {{ $revenueFilterLabel ? '(' . $revenueFilterLabel . ')' : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Revenue Breakdown Modal --}}
                <div class="modal fade" id="revenueBreakdownModal" tabindex="-1" aria-labelledby="revenueBreakdownLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="revenueBreakdownLabel">Revenue Breakdown by Room {{ $revenueFilterLabel ? '(' . $revenueFilterLabel . ')' : '' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Modal Filters --}}
                                <form method="GET" action="{{ route('resort.owner.dashboard') }}" class="row g-3 align-items-end mb-3">
                                    <input type="hidden" name="open" value="breakdown" />
                                    <div class="col-12 col-md-3">
                                        <label for="filter_type_modal" class="form-label">Filter Type</label>
                                        <select id="filter_type_modal" name="filter_type" class="form-select" onchange="toggleRevenueInputsModal()">
                                            <option value="" {{ request('filter_type')==='' ? 'selected' : '' }}>All Time</option>
                                            <option value="day" {{ request('filter_type')==='day' ? 'selected' : '' }}>By Day</option>
                                            <option value="month" {{ request('filter_type')==='month' ? 'selected' : '' }}>By Month</option>
                                            <option value="date_range" {{ request('filter_type')==='date_range' ? 'selected' : '' }}>By Date Range</option>
                                            <option value="month_range" {{ request('filter_type')==='month_range' ? 'selected' : '' }}>By Month Range</option>
                                            <option value="year" {{ request('filter_type')==='year' ? 'selected' : '' }}>By Year</option>
                                            <option value="year_range" {{ request('filter_type')==='year_range' ? 'selected' : '' }}>By Year Range</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3" id="dayInput_modal" style="display:none;">
                                        <label for="date_modal" class="form-label">Select Date</label>
                                        <input type="date" id="date_modal" name="date" value="{{ request('date') }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-3" id="monthInput_modal" style="display:none;">
                                        <label for="month_modal" class="form-label">Select Month</label>
                                        <input type="month" id="month_modal" name="month" value="{{ request('month') }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-6" id="dateRangeInput_modal" style="display:none;">
                                        <label class="form-label">Select Date Range</label>
                                        <div class="row g-2">
                                            <div class="col-12 col-md-6">
                                                <input type="date" name="date_start" value="{{ request('date_start') }}" class="form-control" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input type="date" name="date_end" value="{{ request('date_end') }}" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6" id="monthRangeInput_modal" style="display:none;">
                                        <label class="form-label">Select Month Range</label>
                                        <div class="row g-2">
                                            <div class="col-12 col-md-6">
                                                <input type="month" name="month_start" value="{{ request('month_start') }}" class="form-control" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input type="month" name="month_end" value="{{ request('month_end') }}" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3" id="yearInput_modal" style="display:none;">
                                        <label for="year_modal" class="form-label">Select Year</label>
                                        <input type="number" min="1900" max="2100" step="1" id="year_modal" name="year" value="{{ request('year') }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-6" id="yearRangeInput_modal" style="display:none;">
                                        <label class="form-label">Select Year Range</label>
                                        <div class="row g-2">
                                            <div class="col-12 col-md-6">
                                                <input type="number" min="1900" max="2100" step="1" name="year_start" value="{{ request('year_start') }}" class="form-control" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input type="number" min="1900" max="2100" step="1" name="year_end" value="{{ request('year_end') }}" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-auto d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-shrink-0">Apply</button>
                                        <a href="{{ route('resort.owner.dashboard', ['open' => 'breakdown']) }}" class="btn btn-secondary flex-shrink-0">Reset</a>
                                    </div>
                                </form>
                                @if(isset($revenueBreakdown) && count($revenueBreakdown) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Room/Cottage</th>
                                                    <th class="text-center">Bookings</th>
                                                    <th class="text-end">Revenue (₱)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($revenueBreakdown as $row)
                                                    <tr>
                                                        <td>{{ $row['room_name'] }}</td>
                                                        <td class="text-center">{{ $row['bookings_count'] }}</td>
                                                        <td class="text-end">{{ number_format($row['revenue']) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th class="text-center">{{ $revenueBreakdown->sum('bookings_count') }}</th>
                                                    <th class="text-end">{{ number_format($revenueBreakdown->sum('revenue')) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-file-invoice-dollar empty-icon"></i>
                                        <h6>No Revenue</h6>
                                        <p>No approved bookings found for the selected period.</p>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Revenue Filter (removed - filtering handled in modal) --}}

                {{-- Charts Section --}}
                <div class="row">
                {{-- Resort Usage Bar Graph --}}
                    <div class="col-lg-6 mb-4">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h5 class="chart-title">Resort Usage Statistics</h5>
                                <p class="chart-subtitle">Monthly booking data</p>
                        </div>
                            <div class="chart-body">
                            @if(count($data) > 0)
                                    <canvas id="resortUsageChart" height="300"></canvas>
                            @else
                                    <div class="empty-state">
                                        <i class="fas fa-chart-bar empty-icon"></i>
                                        <h6>No Data Available</h6>
                                        <p>Start by adding rooms to your resort to see usage statistics.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                    {{-- Monthly Booking Trends --}}
                    <div class="col-lg-6 mb-4">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h5 class="chart-title">Monthly Booking Trends</h5>
                                <p class="chart-subtitle">Booking trends over time</p>
                        </div>
                            <div class="chart-body">
                            @if(count($data) > 0)
                                    <canvas id="resortTrendChart" height="300"></canvas>
                            @else
                                    <div class="empty-state">
                                        <i class="fas fa-chart-line empty-icon"></i>
                                        <h6>No Data Available</h6>
                                        <p>Start by adding rooms to your resort to see booking trends.</p>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN (include this at the end of your body or in your main layout) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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


        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 55vw !important;
            z-index: 99999 !important;
        }

        /* Ensure offcanvas backdrop doesn't interfere */
        .offcanvas-backdrop {
            z-index: 99998 !important;
        }

        /* Override any app layout navigation z-index on mobile */
        @media (max-width: 767.98px) {
            nav.navbar {
                z-index: 1000 !important;
            }
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

        /* Override any app layout navigation z-index on mobile */
        @media (max-width: 767.98px) {
            nav.navbar {
                z-index: 1000 !important;
            }
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
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Simple Dashboard Styles */
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .stats-content {
            flex: 1;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
        }
        @media (max-width: 1200px) {
            .stats-number { font-size: 1.6rem; }
        }
        @media (max-width: 992px) {
            .stats-number { font-size: 1.5rem; }
        }

        .stats-label {
            color: #6c757d;
            margin: 0;
            font-size: 0.9rem;
        }

        .chart-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .chart-header {
            padding: 1.5rem 1.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            color: #2c3e50;
        }

        .chart-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0 0 1rem 0;
        }

        .chart-body {
            padding: 1.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h6 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Responsive Design */
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
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        /* Style for the rotated icon */
        .collapse-icon img {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }
    </style>

    {{-- Custom JavaScript to handle arrow rotation and chart --}}
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

            // Check if chart data exists before initializing
            @if(count($data) > 0)
                // Bar Chart
                const ctx = document.getElementById('resortUsageChart').getContext('2d');
                const labels = {!! json_encode($labels) !!};
                const data = {!! json_encode($data) !!};

                const resortUsageChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of Bookings',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Bookings'
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw + ' bookings';
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });

                // Line Chart
                const ctx2 = document.getElementById('resortTrendChart').getContext('2d');
                const resortTrendChart = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Bookings',
                            data: data,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Bookings'
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw + ' bookings';
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            @endif

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

            // Revenue filter inputs removed from page (filtering handled via modal)

            // Modal filter toggling
            function toggleRevenueInputsModal() {
                var typeSelect = document.getElementById('filter_type_modal');
                var dayInput = document.getElementById('dayInput_modal');
                var monthInput = document.getElementById('monthInput_modal');
                var dateRangeInput = document.getElementById('dateRangeInput_modal');
                var monthRangeInput = document.getElementById('monthRangeInput_modal');
                var yearInput = document.getElementById('yearInput_modal');
                var yearRangeInput = document.getElementById('yearRangeInput_modal');
                if (!typeSelect) { return; }
                var val = typeSelect.value;
                function hideAll() {
                    if (dayInput) dayInput.style.display = 'none';
                    if (monthInput) monthInput.style.display = 'none';
                    if (dateRangeInput) dateRangeInput.style.display = 'none';
                    if (monthRangeInput) monthRangeInput.style.display = 'none';
                    if (yearInput) yearInput.style.display = 'none';
                    if (yearRangeInput) yearRangeInput.style.display = 'none';
                }
                hideAll();
                if (val === 'day' && dayInput) dayInput.style.display = '';
                else if (val === 'month' && monthInput) monthInput.style.display = '';
                else if (val === 'date_range' && dateRangeInput) dateRangeInput.style.display = '';
                else if (val === 'month_range' && monthRangeInput) monthRangeInput.style.display = '';
                else if (val === 'year' && yearInput) yearInput.style.display = '';
                else if (val === 'year_range' && yearRangeInput) yearRangeInput.style.display = '';
            }
            toggleRevenueInputsModal();
            window.toggleRevenueInputsModal = toggleRevenueInputsModal;

            // Auto-open modal if coming from filter submit
            @if(request('open') === 'breakdown')
                var modalEl = document.getElementById('revenueBreakdownModal');
                if (modalEl) {
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            @endif
        });
    </script>
</x-app-layout>