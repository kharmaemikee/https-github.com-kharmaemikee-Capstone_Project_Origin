@php
    $unreadCount = 0;
    try {
        if (Auth::check()) {
            $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
        }
    } catch (\Throwable $e) { $unreadCount = 0; }
@endphp

{{-- Desktop Sidebar --}}
<div class="modern-sidebar d-none d-md-block">
    {{-- Sidebar Header --}}
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" class="brand-icon-img">
            </div>
            <div class="brand-text">
                <h4 class="brand-title">Tourist Menu</h4>
                <p class="brand-subtitle">Explore & Discover</p>
            </div>
        </div>
    </div>
    
    {{-- Sidebar Navigation --}}
    <div class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('tourist.tourist') }}" class="nav-link {{ request()->routeIs('tourist.tourist') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/house.png') }}" alt="Home Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('tourist.visit') }}" class="nav-link {{ request()->routeIs('tourist.visit') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Your Visit</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('tourist.notifications') }}" class="nav-link {{ request()->routeIs('tourist.notifications') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Notifications</span>
                    @if($unreadCount > 0)
                        <span class="nav-badge notification-badge" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
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
        {{-- Icon added here for Tourist in mobile sidebar using <img> --}}
        <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
            <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
            Tourist Menu
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item mt-2">
                <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('tourist.tourist') ? 'active' : '' }}">
                    <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    Home
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('tourist.visit') ? 'active' : '' }}">
                    <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    Your Visit
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('tourist.notifications') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('tourist.notifications') ? 'active' : '' }}">
                    <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    Notifications
                    @if($unreadCount > 0)
                        <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
