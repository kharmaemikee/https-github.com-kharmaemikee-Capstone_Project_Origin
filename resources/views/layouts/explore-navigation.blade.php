<nav class="navbar navbar-expand-lg navbar-light fixed-top modern-navbar">
    <div class="container-fluid d-flex align-items-center" style="padding: 0px 15px; height: 60px;">
        {{-- Welcome Text --}}
        <div class="d-flex align-items-center">
            {{-- Welcome Text --}}
            <a class="nav-link d-inline-block {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="welcome-content">
                    <h5 class="m-0 welcome-text">
                        @auth
                            @if(Auth::user()->hasVerifiedPhone())
                                @if(Auth::user()->role === 'admin')
                                    <span class="welcome-title">Welcome Admin</span>
                                @elseif(Auth::user()->role === 'resort_owner')
                                    <span class="welcome-title resort-owner-welcome-text">Welcome {{ Auth::user()->username }}</span>
                                @elseif(Auth::user()->role === 'boat_owner')
                                    <span class="welcome-title">Welcome {{ Auth::user()->username }}</span>
                                @elseif(Auth::user()->role === 'tourist')
                                    <span class="welcome-title">Welcome {{ Auth::user()->username }} to Subic Beach</span>
                                @else
                                    <span class="welcome-title">Welcome to our resorts</span>
                                @endif
                            @else
                                <span class="welcome-title">Welcome to our resorts</span>
                            @endif
                        @else
                            <span class="welcome-title">Welcome to our resorts</span>
                        @endauth
                    </h5>
                    <div class="welcome-subtitle">
                        @auth
                            @if(Auth::user()->hasVerifiedPhone())
                                @if(Auth::user()->role === 'admin')
                                    <small class="text-muted">Administrator Dashboard</small>
                                @elseif(Auth::user()->role === 'resort_owner')
                                    <small class="text-muted">Resort Owner Portal</small>
                                @elseif(Auth::user()->role === 'boat_owner')
                                    <small class="text-muted">Boat Owner Portal</small>
                                @elseif(Auth::user()->role === 'tourist')
                                    <small class="text-muted">Tourist Portal</small>
                                @endif
                            @else
                                <small class="text-muted">Explore our beautiful resorts</small>
                            @endif
                        @else
                            <small class="text-muted">Explore our beautiful resorts</small>
                        @endauth
                    </div>
                </div>
            </a>
        </div>

        {{-- User Menu for Mobile --}}
        <div class="d-md-none ms-auto mobile-nav-container"> 
            <div class="dropdown d-inline-block">
                @auth
                    @if(Auth::user()->hasVerifiedPhone())
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin: Show only name without image --}}
                            <button class="btn modern-user-btn d-flex align-items-center" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar admin-avatar">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">Administrator</small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </button>
                        @elseif(Auth::user()->owner_image_path)
                            {{-- Show image for owners (approved only) or tourist (no approval needed) --}}
                            <button class="btn modern-user-btn d-flex align-items-center" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    <img src="{{ asset(Auth::user()->owner_image_path) }}" 
                                         alt="Owner Image" 
                                         class="user-image" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="user-image-fallback">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">
                                        @if(Auth::user()->role === 'resort_owner') Resort Owner
                                        @elseif(Auth::user()->role === 'boat_owner') Boat Owner
                                        @elseif(Auth::user()->role === 'tourist') Tourist
                                        @endif
                                    </small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </button>
                        @else
                            {{-- Show default icon for other users or unapproved images --}}
                            <button class="btn modern-user-btn d-flex align-items-center" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    <div class="user-image-fallback">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">
                                        @if(Auth::user()->role === 'resort_owner') Resort Owner
                                        @elseif(Auth::user()->role === 'boat_owner') Boat Owner
                                        @elseif(Auth::user()->role === 'tourist') Tourist
                                        @endif
                                    </small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </button>
                        @endif
                        
                        {{-- Verified user dropdown menu for mobile --}}
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="mobileMenuButton">
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.resort') }}">
                                    <i class="fas fa-building me-2"></i>Resort Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.boat') }}">
                                    <i class="fas fa-ship me-2"></i>Boat Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.users') }}">
                                    <i class="fas fa-users me-2"></i>User Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.documentation') }}">
                                    <i class="fas fa-file-alt me-2"></i>Documentation
                                </a></li>
                            @elseif(Auth::user()->role === 'resort_owner')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('resort_owner.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('resort_owner.rooms.index') }}">
                                    <i class="fas fa-bed me-2"></i>Room Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('resort_owner.documentation') }}">
                                    <i class="fas fa-file-alt me-2"></i>Documentation
                                </a></li>
                            @elseif(Auth::user()->role === 'boat_owner')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('boat_owner.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('boat_owner.boat') }}">
                                    <i class="fas fa-ship me-2"></i>Boat Management
                                </a></li>
                            @elseif(Auth::user()->role === 'tourist')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('tourist.tourist') }}">
                                    <i class="fas fa-home me-2"></i>Home
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('tourist.visit') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Visit
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('tourist.reminders') }}">
                                    <i class="fas fa-bell me-2"></i>Reminders
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item modern-dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        {{-- Show guest mode for unverified users --}}
                        <button class="btn modern-user-btn d-flex align-items-center" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <div class="user-image-fallback">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="user-info">
                                <span class="user-name">Guest</span>
                                <small class="user-role">Visitor</small>
                            </div>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </button>
                        
                        {{-- Unverified user dropdown menu for mobile --}}
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="mobileMenuButton">
                            <li><a class="dropdown-item modern-dropdown-item" href="{{ route('verification.notice') }}">
                                <i class="fas fa-mobile-alt me-2"></i>Verify Phone
                            </a></li>
                        </ul>
                    @endif
                @else
                    {{-- Guest: Show guest info with login/register dropdown --}}
                    <button class="btn modern-user-btn d-flex align-items-center" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <div class="user-image-fallback">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="user-info">
                            <span class="user-name">Guest</span>
                            <small class="user-role">Visitor</small>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                    
                    {{-- Guest dropdown menu --}}
                    <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="mobileMenuButton">
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a></li>
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a></li>
                    </ul>
                @endauth
            </div>
        </div>

        {{-- User Menu for Desktop --}}
        <div class="d-none d-md-flex ms-auto desktop-nav-container">
            <div class="dropdown d-inline-block">
                @auth
                    @if(Auth::user()->hasVerifiedPhone())
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin: Show only name without image --}}
                            <button class="btn modern-user-btn d-flex align-items-center" type="button" id="desktopMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar admin-avatar">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">Administrator</small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </button>
                        @elseif(Auth::user()->owner_image_path)
                            {{-- Show image for owners (approved only) or tourist (no approval needed) --}}
                            <button class="btn modern-user-btn d-flex align-items-center" type="button" id="desktopMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    <img src="{{ asset(Auth::user()->owner_image_path) }}" 
                                         alt="Owner Image" 
                                         class="user-image" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="user-image-fallback">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">
                                        @if(Auth::user()->role === 'resort_owner') Resort Owner
                                        @elseif(Auth::user()->role === 'boat_owner') Boat Owner
                                        @elseif(Auth::user()->role === 'tourist') Tourist
                                        @endif
                                    </small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </button>
                        @else
                            {{-- Show default icon for other users or unapproved images --}}
                            <button class="btn modern-user-btn d-flex align-items-center" type="button" id="desktopMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    <div class="user-image-fallback">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">
                                        @if(Auth::user()->role === 'resort_owner') Resort Owner
                                        @elseif(Auth::user()->role === 'boat_owner') Boat Owner
                                        @elseif(Auth::user()->role === 'tourist') Tourist
                                        @endif
                                    </small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </button>
                        @endif
                        
                        {{-- Verified user dropdown menu for desktop --}}
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="desktopMenuButton">
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.resort') }}">
                                    <i class="fas fa-building me-2"></i>Resort Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.boat') }}">
                                    <i class="fas fa-ship me-2"></i>Boat Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.users') }}">
                                    <i class="fas fa-users me-2"></i>User Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('admin.documentation') }}">
                                    <i class="fas fa-file-alt me-2"></i>Documentation
                                </a></li>
                            @elseif(Auth::user()->role === 'resort_owner')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('resort_owner.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('resort_owner.rooms.index') }}">
                                    <i class="fas fa-bed me-2"></i>Room Management
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('resort_owner.documentation') }}">
                                    <i class="fas fa-file-alt me-2"></i>Documentation
                                </a></li>
                            @elseif(Auth::user()->role === 'boat_owner')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('boat_owner.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('boat_owner.boat') }}">
                                    <i class="fas fa-ship me-2"></i>Boat Management
                                </a></li>
                            @elseif(Auth::user()->role === 'tourist')
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('tourist.tourist') }}">
                                    <i class="fas fa-home me-2"></i>Home
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('tourist.visit') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Visit
                                </a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('tourist.reminders') }}">
                                    <i class="fas fa-bell me-2"></i>Reminders
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item modern-dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        {{-- Show guest mode for unverified users --}}
                        <button class="btn modern-user-btn d-flex align-items-center" type="button" id="desktopMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <div class="user-image-fallback">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="user-info">
                                <span class="user-name">Guest</span>
                                <small class="user-role">Visitor</small>
                            </div>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </button>
                        
                        {{-- Unverified user dropdown menu --}}
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="desktopMenuButton">
                            <li><a class="dropdown-item modern-dropdown-item" href="{{ route('verification.notice') }}">
                                <i class="fas fa-mobile-alt me-2"></i>Verify Contact Number
                            </a></li>
                        </ul>
                    @endif
                @else
                    {{-- Guest: Show guest info with login/register dropdown --}}
                    <button class="btn modern-user-btn d-flex align-items-center" type="button" id="desktopMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <div class="user-image-fallback">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="user-info">
                            <span class="user-name">Guest</span>
                            <small class="user-role">Visitor</small>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                    
                    {{-- Guest dropdown menu --}}
                    <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="desktopMenuButton">
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a></li>
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a></li>
                    </ul>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .modern-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-bottom: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        z-index: 1000;
    }

    .welcome-content {
        color: white;
    }

    .welcome-text {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .welcome-title {
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .welcome-subtitle {
        margin-top: 2px;
    }

    .welcome-subtitle small {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
    }

    .modern-user-btn {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        padding: 8px 12px;
        border-radius: 25px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .modern-user-btn:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.3);
        color: white;
        transform: translateY(-1px);
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.2);
    }

    .admin-avatar {
        background: rgba(255,255,255,0.3);
    }

    .user-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-image-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: white;
        font-size: 16px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-right: 8px;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        margin: 0;
        white-space: nowrap;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-role {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.8);
        margin: 0;
    }

    .dropdown-arrow {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.8);
        transition: transform 0.3s ease;
    }

    .modern-dropdown {
        background: rgba(255,255,255,0.95);
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
        margin-top: 8px;
        min-width: 200px;
    }

    .modern-dropdown-item {
        padding: 10px 16px;
        color: #333;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border-radius: 8px;
        margin: 2px 8px;
    }

    .modern-dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateX(4px);
    }

    .dropdown-divider {
        margin: 8px 0;
        border-color: rgba(0,0,0,0.1);
    }

    .resort-owner-welcome-text {
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .welcome-title {
            font-size: 1rem;
        }

        .welcome-subtitle small {
            font-size: 0.8rem;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
        }
        
        .user-name {
            font-size: 0.85rem;
            max-width: 100px;
        }
        
        .user-role {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .welcome-title {
            font-size: 0.9rem;
        }

        .welcome-subtitle small {
            font-size: 0.75rem;
        }
    }
</style>
