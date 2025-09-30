<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('boat_owner.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Main Content Area (Dashboard) --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                {{-- Page Header --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1">Boat Dashboard</h2>
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
                                <i class="fas fa-ship"></i>
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
                        <div class="stats-card clickable-card" data-bs-toggle="modal" data-bs-target="#boatRevenueBreakdownModal" style="cursor: pointer;">
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
                <div class="modal fade" id="boatRevenueBreakdownModal" tabindex="-1" aria-labelledby="boatRevenueBreakdownLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="boatRevenueBreakdownLabel">Boat Revenue Breakdown {{ $revenueFilterLabel ? '(' . $revenueFilterLabel . ')' : '' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Modal Filters --}}
                                <form method="GET" action="{{ route('boat.owner.dashboard') }}" class="row g-3 align-items-end mb-3">
                                    <input type="hidden" name="open" value="boat_breakdown" />
                                    <div class="col-12 col-md-3">
                                        <label for="boat_filter_type_modal" class="form-label">Filter Type</label>
                                        <select id="boat_filter_type_modal" name="filter_type" class="form-select" onchange="toggleBoatRevenueInputsModal()">
                                            <option value="" {{ request('filter_type')==='' ? 'selected' : '' }}>All Time</option>
                                            <option value="day" {{ request('filter_type')==='day' ? 'selected' : '' }}>By Day</option>
                                            <option value="month" {{ request('filter_type')==='month' ? 'selected' : '' }}>By Month</option>
                                            <option value="date_range" {{ request('filter_type')==='date_range' ? 'selected' : '' }}>By Date Range</option>
                                            <option value="month_range" {{ request('filter_type')==='month_range' ? 'selected' : '' }}>By Month Range</option>
                                            <option value="year" {{ request('filter_type')==='year' ? 'selected' : '' }}>By Year</option>
                                            <option value="year_range" {{ request('filter_type')==='year_range' ? 'selected' : '' }}>By Year Range</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3" id="boat_dayInput_modal" style="display:none;">
                                        <label for="boat_date_modal" class="form-label">Select Date</label>
                                        <input type="date" id="boat_date_modal" name="date" value="{{ request('date') }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-3" id="boat_monthInput_modal" style="display:none;">
                                        <label for="boat_month_modal" class="form-label">Select Month</label>
                                        <input type="month" id="boat_month_modal" name="month" value="{{ request('month') }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-6" id="boat_dateRangeInput_modal" style="display:none;">
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
                                    <div class="col-12 col-md-6" id="boat_monthRangeInput_modal" style="display:none;">
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
                                    <div class="col-12 col-md-3" id="boat_yearInput_modal" style="display:none;">
                                        <label for="boat_year_modal" class="form-label">Select Year</label>
                                        <input type="number" min="1900" max="2100" step="1" id="boat_year_modal" name="year" value="{{ request('year') }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-6" id="boat_yearRangeInput_modal" style="display:none;">
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
                                        <a href="{{ route('boat.owner.dashboard', ['open' => 'boat_breakdown']) }}" class="btn btn-secondary flex-shrink-0">Reset</a>
                                    </div>
                                </form>

                                @if(isset($revenueBreakdown) && count($revenueBreakdown) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Room/Cottage</th>
                                                    <th class="text-center">Bookings</th>
                                                    <th class="text-end">Boat Revenue (₱)</th>
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

                {{-- Revenue Filter (removed - filtering handled via modal) --}}

                {{-- Charts Section --}}
                <div class="row">
                    {{-- Boat Usage Bar Graph --}}
                    <div class="col-lg-6 mb-4">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h5 class="chart-title">Boat Usage Statistics</h5>
                                <p class="chart-subtitle">Monthly booking data</p>
                            </div>
                            <div class="chart-body">
                                <canvas id="boatUsageChart" height="300"></canvas>
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
                                <canvas id="boatTrendChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN (include this at the end of your body or in your main layout) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom CSS for simple design --}}
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

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
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

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
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
            
            .mobile-toggle {
                padding: 0.75rem;
            }
            
            .mobile-toggle-btn {
                padding: 0.5rem 0.75rem;
                font-size: 1rem;
            }
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
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


        /* Styles for the collapse icon rotation */
        .collapse-icon img {
            transition: transform 0.3s ease-in-out;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        /* Styles for active parent link - matched with boat.blade.php if applicable or kept for consistency */
        .nav-link.active-parent {
             background-color: rgb(6, 58, 170) !important; /* This ensures consistency with the active link color from boat.blade.php */
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

    {{-- Custom JavaScript to handle arrow rotation and chart --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle collapse toggles for notifications
            const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
            collapseElements.forEach(element => {
                element.addEventListener('click', function() {
                    const targetId = this.getAttribute('href');
                    const target = document.querySelector(targetId);
                    if (target) {
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';
                        this.setAttribute('aria-expanded', !isExpanded);
                        
                        // Rotate arrow icon
                        const icon = this.querySelector('.collapse-icon img');
                        if (icon) {
                            if (isExpanded) {
                                icon.style.transform = 'rotate(0deg)';
                            } else {
                                icon.style.transform = 'rotate(180deg)';
                            }
                        }
                    }
                });
            });

        // NEW: Chart.js initialization with dynamic data for boat usage
        const ctx = document.getElementById('boatUsageChart').getContext('2d');
        
        // Gamitin ang data na galing sa Laravel backend
        @php
            $defaultBoatLabels = ['Boat 1', 'Boat 2', 'Boat 3', 'Boat 4', 'Boat 5'];
            $defaultUsageData = [12, 19, 8, 15, 7];
            $defaultRevenueData = [24000, 38000, 16000, 30000, 14000];
        @endphp
        const boatLabels = {!! json_encode($boatLabels ?? $defaultBoatLabels) !!};
        const boatUsageData = {!! json_encode($boatUsageData ?? $defaultUsageData) !!};
        const boatRevenueData = {!! json_encode($boatRevenueData ?? $defaultRevenueData) !!};

        const boatUsageChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: boatLabels,
                datasets: [{
                    label: 'Number of Bookings',
                    data: boatUsageData,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Revenue (₱)',
                    data: boatRevenueData,
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Boats'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Bookings'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (₱)'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return context.dataset.label + ': ' + context.raw + ' bookings';
                                } else {
                                    return context.dataset.label + ': ₱' + context.raw.toLocaleString();
                                }
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

        // Line Chart for Monthly Trends
        const ctx2 = document.getElementById('boatTrendChart').getContext('2d');
        const boatTrendChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: boatLabels,
                datasets: [{
                    label: 'Monthly Bookings',
                    data: boatUsageData,
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
                            text: 'Boats'
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

        // Inline revenue filters removed (use modal filters instead)

        // Modal filter toggling for boat
        function toggleBoatRevenueInputsModal() {
            var typeSelect = document.getElementById('boat_filter_type_modal');
            var dayInput = document.getElementById('boat_dayInput_modal');
            var monthInput = document.getElementById('boat_monthInput_modal');
            var dateRangeInput = document.getElementById('boat_dateRangeInput_modal');
            var monthRangeInput = document.getElementById('boat_monthRangeInput_modal');
            var yearInput = document.getElementById('boat_yearInput_modal');
            var yearRangeInput = document.getElementById('boat_yearRangeInput_modal');
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
        toggleBoatRevenueInputsModal();
        window.toggleBoatRevenueInputsModal = toggleBoatRevenueInputsModal;

        // Auto-open modal if coming from filter submit
        if ('{{ request('open') }}' === 'boat_breakdown') {
            var modalEl = document.getElementById('boatRevenueBreakdownModal');
            if (modalEl) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }
    });
</script>
            </div>
        </div>
    </div>
</x-app-layout>