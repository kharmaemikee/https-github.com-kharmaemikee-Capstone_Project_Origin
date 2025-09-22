@php
    $unreadCount = 0;
    try {
        if (Auth::check()) {
            $unreadCount = \App\Models\BoatOwnerNotification::where('user_id', Auth::id())->where('is_read', false)->count();
        }
    } catch (\Throwable $e) { $unreadCount = 0; }
@endphp

{{-- Desktop Sidebar --}}
<div class="modern-sidebar d-none d-md-block">
    {{-- Sidebar Header --}}
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" class="brand-icon-img">
            </div>
            <div class="brand-text">
                <h4 class="brand-title">Welcome {{ auth()->user()->first_name }}</h4>
                <p class="brand-subtitle">Boat Owner Portal</p>
            </div>
        </div>
    </div>
    
    {{-- Sidebar Navigation --}}
    <div class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('boat.owner.dashboard') }}" class="nav-link {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                @if(auth()->user()->canAccessMainFeatures())
                    <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                        </div>
                        <span class="nav-text">Boat Management</span>
                    </a>
                @else
                    <span class="nav-link disabled-link" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="right" 
                          title="Upload your permits first to unlock this feature">
                        <div class="nav-icon">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img disabled">
                        </div>
                        <span class="nav-text">Boat Management</span>
                        <span class="nav-badge">Locked</span>
                    </span>
                @endif
            </li>
            
            <li class="nav-item">
                <a href="{{ route('boat.owner.verified') }}" class="nav-link {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Account Management</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('boat.owner.notification') }}" class="nav-link {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
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
                <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" class="mobile-brand-icon-img">
            </div>
            <div class="mobile-brand-text">
                <h5 class="mobile-brand-title" id="mobileSidebarLabel">Welcome {{ auth()->user()->first_name }}</h5>
                <p class="mobile-brand-subtitle">Boat Owner Portal</p>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mobile-sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('boat.owner.dashboard') }}" class="nav-link {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                @if(auth()->user()->canAccessMainFeatures())
                    <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                        </div>
                        <span class="nav-text">Boat Management</span>
                    </a>
                @else
                    <span class="nav-link disabled-link" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="right" 
                          title="Upload your permits first to unlock this feature">
                        <div class="nav-icon">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img disabled">
                        </div>
                        <span class="nav-text">Boat Management</span>
                        <span class="nav-badge">Locked</span>
                    </span>
                @endif
            </li>
            <li class="nav-item">
                <a href="{{ route('boat.owner.verified') }}" class="nav-link {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                    </div>
                    <span class="nav-text">Account Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('boat.owner.notification') }}" class="nav-link {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
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
