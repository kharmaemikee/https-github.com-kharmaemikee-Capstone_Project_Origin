@php
    $unreadCount = 0;
    try {
        if (Auth::check()) {
            $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
        }
    } catch (\Throwable $e) { $unreadCount = 0; }
@endphp

{{-- Desktop Sidebar --}}
<div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
    <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
        <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
        Tourist
    </h4>
    
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start {{ request()->routeIs('tourist.tourist') ? 'active' : '' }}">
                <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                Home
            </a>
        </li>
        <li class="nav-item mt-2">
            <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start {{ request()->routeIs('tourist.visit') ? 'active' : '' }}">
                <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                Your Visit
            </a>
        </li>
        <li class="nav-item mt-2">
            <a href="{{ route('tourist.notifications') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start {{ request()->routeIs('tourist.notifications') ? 'active' : '' }}">
                <i class="fas fa-bell me-2" style="width: 20px; height: 20px;"></i>
                Notifications
                @if($unreadCount > 0)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>
        {{-- Add other tourist sidebar links here if any --}}
    </ul>
</div>

{{-- Mobile Offcanvas Toggle Button --}}
<div class="d-md-none bg-light border-bottom p-2">
    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
        &#9776;
    </button>
</div>

{{-- Mobile Offcanvas Sidebar --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
            <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
            Tourist
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start {{ request()->routeIs('tourist.tourist') ? 'active' : '' }}">
                    <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                    Home
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start {{ request()->routeIs('tourist.visit') ? 'active' : '' }}">
                <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">    
                Your Visit
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('tourist.notifications') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start {{ request()->routeIs('tourist.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell me-2"></i>
                    Notifications
                    @if($unreadCount > 0)
                        <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
            {{-- Add other tourist sidebar links here if any --}}
        </ul>
    </div>
</div>
