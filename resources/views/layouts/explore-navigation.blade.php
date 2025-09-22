<nav class="navbar navbar-expand-lg navbar-light fixed-top modern-navbar">
    <div class="container-fluid d-flex align-items-center" style="padding: 0px 15px; height: 60px;">
        {{-- Welcome Text --}}
        <div class="d-flex align-items-center">
            {{-- Welcome Text --}}
            <a class="nav-link d-inline-block {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="welcome-content">
                    <h5 class="m-0 welcome-text">
                        <i class="fas fa-home me-2 text-primary d-none d-md-inline"></i>
                        @auth
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
                        @endauth
                    </h5>
                    <div class="welcome-subtitle">
                        @auth
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
                        @endauth
                    </div>
                </div>
            </a>
        </div>

        {{-- User Menu for Mobile --}}
        <div class="d-md-none ms-auto mobile-nav-container"> 
            <div class="dropdown d-inline-block">
                @auth
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
                @else
                    {{-- Guest: Show login/register buttons --}}
                    <button class="btn modern-user-btn d-flex align-items-center" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <div class="user-image-fallback">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="user-info">
                            <span class="user-name">Guest</span>
                            <small class="user-role">Login or Register</small>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                @endauth
                
                <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="mobileMenuButton">
                    @auth
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
                                <button type="submit" class="dropdown-item modern-dropdown-item logout-btn">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a></li>
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a></li>
                    @endauth
                </ul>
            </div>
        </div>

        {{-- User Menu for Desktop --}}
        <div class="d-none d-md-flex ms-auto desktop-nav-container">
            <div class="dropdown d-inline-block">
                @auth
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
                @else
                    {{-- Guest: Show login/register buttons --}}
                    <button class="btn modern-user-btn d-flex align-items-center" type="button" id="desktopMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <div class="user-image-fallback">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="user-info">
                            <span class="user-name">Guest</span>
                            <small class="user-role">Login or Register</small>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                @endauth
                
                <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="desktopMenuButton">
                    @auth
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
                                <button type="submit" class="dropdown-item modern-dropdown-item logout-btn">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a></li>
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Modern Navbar Styles */
    .modern-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .modern-navbar:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    /* Welcome Content Styles */
    .welcome-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .welcome-text {
        color: white;
        font-weight: 600;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .welcome-title {
        font-size: 1.1rem;
        font-weight: 700;
    }

    .welcome-subtitle {
        margin-top: 0.25rem;
    }

    .welcome-subtitle small {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.8rem;
        font-weight: 400;
    }

    /* User Button Styles */
    .modern-user-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-user-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .modern-user-btn:focus {
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.25);
        color: white;
    }

    /* User Avatar Styles */
    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .admin-avatar {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    }

    .user-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-image-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: white;
    }

    /* User Info Styles */
    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        min-width: 0;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    .user-role {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 400;
    }

    .dropdown-arrow {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.8);
        transition: transform 0.3s ease;
    }

    .modern-user-btn[aria-expanded="true"] .dropdown-arrow {
        transform: rotate(180deg);
    }

    /* Dropdown Menu Styles */
    .modern-dropdown {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
        margin-top: 0.5rem;
        min-width: 200px;
    }

    .modern-dropdown-item {
        color: #333;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
    }

    .modern-dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateX(4px);
    }

    .modern-dropdown-item i {
        width: 16px;
        text-align: center;
    }

    .logout-btn {
        color: #dc3545;
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
        border-color: rgba(0, 0, 0, 0.1);
    }

    /* Responsive Styles */
    @media (max-width: 767px) {
        .welcome-title {
            font-size: 1rem;
        }
        
        .welcome-subtitle small {
            font-size: 0.75rem;
        }
        
        .modern-user-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
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
            font-size: 0.7rem;
        }
        
        .modern-user-btn {
            padding: 0.35rem 0.7rem;
            font-size: 0.8rem;
        }
        
        .user-avatar {
            width: 28px;
            height: 28px;
        }
        
        .user-name {
            font-size: 0.8rem;
            max-width: 80px;
        }
        
        .user-role {
            font-size: 0.65rem;
        }
    }

    @media (max-width: 425px) {
        .welcome-title {
            font-size: 0.85rem;
        }
        
        .welcome-subtitle small {
            font-size: 0.65rem;
        }
        
        .modern-user-btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }
        
        .user-avatar {
            width: 26px;
            height: 26px;
        }
        
        .user-name {
            font-size: 0.75rem;
            max-width: 70px;
        }
        
        .user-role {
            font-size: 0.6rem;
        }
    }
</style>
