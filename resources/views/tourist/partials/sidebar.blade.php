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


{{-- Mobile Offcanvas Sidebar --}}
<div class="offcanvas offcanvas-start modern-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <div class="mobile-sidebar-brand">
            <div class="mobile-brand-icon">
                <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" class="mobile-brand-icon-img">
            </div>
            <div class="mobile-brand-text">
                <h5 class="mobile-brand-title" id="mobileSidebarLabel">Tourist Menu</h5>
                <p class="mobile-brand-subtitle">Explore & Discover</p>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mobile-sidebar-nav">
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
                        <span class="nav-badge notification-badge" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
