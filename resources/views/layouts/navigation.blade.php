@php($navbarFull = request()->routeIs('profile.*'))
<nav class="navbar navbar-expand-lg navbar-light fixed-top modern-navbar {{ $navbarFull ? 'modern-navbar--full' : '' }}">
    <div class="container-fluid d-flex align-items-center" style="padding: 0px 15px; height: 60px;">
        {{-- Back arrow --}}
        {{-- Welcome text --}}
        <div class="d-flex align-items-center">
            {{-- Mobile Hamburger Button --}}
            <div class="d-lg-none me-3">
                <button class="btn hamburger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            {{-- Welcome Text --}}
            <a class="nav-link d-inline-block {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="welcome-content">
                    <h5 class="m-0 welcome-text">
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
        <div class="d-lg-none ms-auto mobile-nav-container"> 
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
                    @endif
                @else
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
                @endauth
                <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="mobileMenuButton">
                    <li>
                        <div class="dropdown-header">
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <div class="user-header-info">
                                        <i class="fas fa-user-shield text-primary me-2"></i>
                                        <div>
                                            <h6 class="mb-0">Admin: {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</h6>
                                            <small class="text-muted">Administrator</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="user-header-info">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        <div>
                                            <h6 class="mb-0">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</h6>
                                            <small class="text-muted">
                                                @if(Auth::user()->role === 'resort_owner') Resort Owner
                                                @elseif(Auth::user()->role === 'boat_owner') Boat Owner
                                                @elseif(Auth::user()->role === 'tourist') Tourist
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="user-header-info">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <div>
                                        <h6 class="mb-0">Guest</h6>
                                        <small class="text-muted">Visitor</small>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @auth
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit me-2"></i>Profile
                        </a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item modern-dropdown-item logout-btn" type="submit">
                                    <i class="fas fa-sign-out-alt me-2"></i>Log Out
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
        <div class="d-none d-lg-block ms-auto desktop-nav-container">
            <div class="dropdown d-inline-block">
                @auth
                    @if(Auth::user()->hasVerifiedPhone())
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin: Show only name without image --}}
                            <a href="#" class="modern-user-link d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar admin-avatar">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                                    <small class="user-role">Administrator</small>
                                </div>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </a>
                        @elseif(Auth::user()->owner_image_path)
                        {{-- Show image only for owners (approved only) or tourist (no approval needed) --}}
                        <a href="#" class="modern-user-link d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                        </a>
                    @else
                        {{-- Show default icon for other users or unapproved images --}}
                        <a href="#" class="modern-user-link d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                        </a>
                        @endif
                    @else
                        {{-- Show guest mode for unverified users --}}
                        <a href="#" class="modern-user-link d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                        </a>
                    @endif
            @else
                    <a href="#" class="modern-user-link d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                    </a>
            @endauth
            <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="userDropdown">
                @auth
                    @if(Auth::user()->hasVerifiedPhone())
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin dropdown: Include profile option --}}
                            <li>
                                <div class="dropdown-header">
                                    <div class="user-header-info">
                                        <i class="fas fa-user-shield text-primary me-2"></i>
                                        <div>
                                            <h6 class="mb-0">Hi {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}!</h6>
                                            <small class="text-muted">Administrator</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item modern-dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>Profile
                            </a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item modern-dropdown-item logout-btn" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Log Out
                                    </button>
                                </form>
                            </li>
                        @else
                        {{-- Other users dropdown: Include profile option --}}
                        @if(in_array(Auth::user()->role, ['resort_owner', 'boat_owner', 'tourist']))
                            <li>
                                <div class="dropdown-header">
                                    <div class="user-header-info">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        <div>
                                            <h6 class="mb-0">Hi {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}!</h6>
                                            <small class="text-muted">
                                                @if(Auth::user()->role === 'resort_owner') Resort Owner
                                                @elseif(Auth::user()->role === 'boat_owner') Boat Owner
                                                @elseif(Auth::user()->role === 'tourist') Tourist
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit me-2"></i>Profile
                        </a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item modern-dropdown-item logout-btn" type="submit">
                                    <i class="fas fa-sign-out-alt me-2"></i>Log Out
                                </button>
                            </form>
                        </li>
                        @endif
                    @else
                        {{-- Show guest menu for unverified users --}}
                        <li>
                            <div class="dropdown-header">
                                <div class="user-header-info">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <div>
                                        <h6 class="mb-0">Guest</h6>
                                        <small class="text-muted">Visitor</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a></li>
                        <li><a class="dropdown-item modern-dropdown-item" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a></li>
                    @endif
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
</nav>

<style>
    /* Modern Navbar Styles */
    .modern-navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 60px !important;
        min-height: 60px !important;
        /* Align navbar flush with fixed sidebar on desktop */
        left: 280px;
        right: 0;
        width: calc(100% - 280px);
    }

    /* Modifier: full-width navbar for pages without sidebar (e.g., profile) */
    .modern-navbar--full {
        left: 0 !important;
        width: 100% !important;
    }

    /* Hamburger Button Styles */
    .hamburger-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Hide hamburger on desktop by default */
    @media (min-width: 768px) {
        .hamburger-btn { display: none !important; }
    }

    .hamburger-btn:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .hamburger-btn:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
        color: white;
    }

    .hamburger-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
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
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        color: #2c3e50 !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.2 !important;
    }

    .welcome-title {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-subtitle {
        margin-top: -2px;
    }

    .welcome-subtitle small {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* User Button Styles */
    .modern-user-btn, .modern-user-link {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 8px 12px;
        transition: all 0.3s ease;
        text-decoration: none !important;
        color: inherit !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .modern-user-btn:hover, .modern-user-link:hover {
        background: rgba(255, 255, 255, 0.95);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        color: inherit !important;
        text-decoration: none !important;
    }

    /* User Avatar Styles */
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        position: relative;
        overflow: hidden;
    }

    .user-avatar.admin-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .user-avatar .user-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .user-avatar .user-image-fallback {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    /* User Info Styles */
    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
        line-height: 1.2;
    }

    .user-role {
        color: #6c757d;
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: -2px;
    }

    .dropdown-arrow {
        color: #6c757d;
        font-size: 0.8rem;
        transition: transform 0.3s ease;
        margin-left: 8px;
    }

    .modern-user-btn:hover .dropdown-arrow,
    .modern-user-link:hover .dropdown-arrow {
        transform: rotate(180deg);
    }

    /* Modern Dropdown Styles */
    .modern-dropdown {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 8px 0;
        margin-top: 8px;
        min-width: 200px;
    }

    .modern-dropdown .dropdown-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
        margin: 0 8px 8px 8px;
        padding: 12px;
        border: none;
    }

    .user-header-info {
        display: flex;
        align-items: center;
    }

    .user-header-info i {
        font-size: 1.2rem;
    }

    .modern-dropdown-item {
        padding: 10px 16px;
        transition: all 0.3s ease;
        border-radius: 6px;
        margin: 2px 8px;
        font-weight: 500;
        color: #495057;
    }

    .modern-dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white !important;
        transform: translateX(4px);
    }

    .modern-dropdown-item i {
        width: 16px;
        text-align: center;
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%) !important;
        color: white !important;
    }

    /* Resort Owner Welcome Text Responsive */
    .resort-owner-welcome-text {
        font-size: 1rem !important;
        line-height: 1.2 !important;
    }

    body {
        /* Add padding-top to the body to prevent content from being hidden behind the fixed navbar */
        padding-top: 60px; /* Updated for new navbar height */
    }

    /* Responsive Design */
    
    /* Mobile devices (≤767px) */
    @media (max-width: 767px) {
        .modern-navbar {
            height: 60px !important;
            /* Reset offset on mobile so navbar spans full width */
            left: 0;
            width: 100%;
        }
        
        .welcome-content {
            align-items: flex-start;
        }
        
        .welcome-text {
            font-size: 1rem !important;
        }
        
        .welcome-subtitle small {
            font-size: 0.7rem;
        }
        
        .hamburger-btn {
            width: 36px;
            height: 36px;
            padding: 6px 10px;
            font-size: 1rem;
        }
        
        .modern-user-btn, .modern-user-link {
            padding: 6px 10px;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            margin-right: 8px;
        }
        
        .user-name {
            font-size: 0.85rem;
        }
        
        .user-role {
            font-size: 0.7rem;
        }
        
        .modern-dropdown {
            min-width: 180px;
        }
        
        .modern-dropdown-item {
            padding: 8px 12px;
            font-size: 0.9rem;
        }
    }

    /* Small mobile devices (≤576px) - Bootstrap sm breakpoint */
    @media (max-width: 576px) {
        .welcome-text .welcome-title {
            display: none;
        }
        
        .welcome-text {
            font-size: 0.9rem !important;
        }
        
        .welcome-text i {
            font-size: 1.3rem;
            margin-right: 0 !important;
        }
        
        .welcome-subtitle {
            display: none;
        }
        
        .hamburger-btn {
            width: 32px;
            height: 32px;
            padding: 4px 8px;
            font-size: 0.9rem;
        }
        
        .modern-user-btn, .modern-user-link {
            padding: 5px 8px;
        }
        
        .user-avatar {
            width: 30px;
            height: 30px;
            margin-right: 6px;
        }
        
        .user-name {
            font-size: 0.8rem;
        }
        
        .user-role {
            font-size: 0.65rem;
        }
        
        .modern-dropdown {
            min-width: 170px;
        }
    }

    /* Very small devices (≤425px) */
    @media (max-width: 425px) {
        .welcome-content {
            flex-direction: row;
            align-items: center;
        }
        
        .welcome-text {
            font-size: 0.9rem !important;
        }
        
        .welcome-subtitle {
            display: none;
        }
        
        .hamburger-btn {
            width: 30px;
            height: 30px;
            padding: 3px 6px;
            font-size: 0.8rem;
        }
        
        .modern-user-btn, .modern-user-link {
            padding: 4px 8px;
        }
        
        .user-avatar {
            width: 28px;
            height: 28px;
            margin-right: 6px;
        }
        
        .user-name {
            font-size: 0.8rem;
        }
        
        .user-role {
            font-size: 0.65rem;
        }
    }

    /* Extra small devices (≤375px) */
    @media (max-width: 375px) {
        .welcome-text .welcome-title {
            display: none;
        }
        
        .welcome-text {
            font-size: 0.8rem !important;
        }
        
        .welcome-text i {
            font-size: 1.2rem;
            margin-right: 0 !important;
        }
        
        .modern-user-btn, .modern-user-link {
            padding: 3px 6px;
        }
        
        .user-avatar {
            width: 26px;
            height: 26px;
            margin-right: 4px;
        }
        
        .user-name {
            font-size: 0.75rem;
        }
        
        .user-role {
            font-size: 0.6rem;
        }
    }

    /* Ultra small devices (≤320px) */
    @media (max-width: 320px) {
        .welcome-text .welcome-title {
            display: none;
        }
        
        .welcome-text {
            font-size: 0.7rem !important;
        }
        
        .welcome-text i {
            font-size: 1.1rem;
            margin-right: 0 !important;
        }
        
        .modern-user-btn, .modern-user-link {
            padding: 2px 4px;
        }
        
        .user-avatar {
            width: 24px;
            height: 24px;
            margin-right: 3px;
        }
        
        .user-name {
            font-size: 0.7rem;
        }
        
        .user-role {
            font-size: 0.55rem;
        }
        
        .modern-dropdown {
            min-width: 160px;
        }

      
    }

    /* Tablet devices (768px-991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .welcome-text {
            font-size: 1.1rem !important;
        }
        
        .user-avatar {
            width: 34px;
            height: 34px;
        }
    }

    /* Desktop devices (≥992px) */
    @media (min-width: 992px) {
        .welcome-text {
            font-size: 1.2rem !important;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
        }
    }

    /* Additional Modern Styles */
    
    /* Smooth transitions for all interactive elements */
    * {
        transition: all 0.3s ease;
    }
    
    /* Enhanced focus states for accessibility */
    .modern-user-btn:focus,
    .modern-user-link:focus,
    .modern-dropdown-item:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    
    /* Loading animation for dropdowns */
    .modern-dropdown.show {
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Enhanced hover effects */
    .modern-navbar:hover .welcome-title {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Notification styles (if needed) */
    .notification-dropdown {
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }
    
    .notification-dropdown .dropdown-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
        margin: 0 8px 8px 8px;
        padding: 12px;
    }
    
    .notification-dropdown .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }
    
    .notification-dropdown .badge {
        font-size: 0.7rem;
        border-radius: 10px;
    }
    
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load notifications when dropdown is opened
    const mobileNotificationButton = document.getElementById('mobileNotificationButton');
    const desktopNotificationButton = document.getElementById('desktopNotificationButton');
    
    function loadNotifications(contentId) {
        const notificationContent = document.getElementById(contentId);
        if (!notificationContent) return;
        
        // Show loading state
        notificationContent.innerHTML = `
            <div class="text-center p-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0 text-muted">Loading notifications...</p>
            </div>
        `;
        
        // Fetch notifications via AJAX
        fetch('/tourist/notifications/ajax', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Notifications data:', data); // Debug log
            console.log('Data success:', data.success);
            console.log('Notifications array:', data.notifications);
            console.log('Notifications length:', data.notifications ? data.notifications.length : 'notifications is null/undefined');
            
            if (data.success && data.notifications && data.notifications.length > 0) {
                let html = '';
                data.notifications.forEach(notification => {
                    const timeAgo = new Date(notification.created_at).toLocaleDateString();
                    
                    html += `
                        <div class="p-3 border-bottom">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <h6 class="mb-1 fw-bold">${notification.message}</h6>
                                <small class="text-nowrap text-muted">${timeAgo}</small>
                            </div>
                            ${notification.booking ? `
                                <p class="mb-1 text-sm">Booking for: ${notification.booking.room_name || 'N/A Room'} at ${notification.booking.name_of_resort}</p>
                                <p class="mb-2">Status: <span class="badge ${getStatusClass(notification.booking.status)}">${getStatusText(notification.booking.status)}</span></p>
                            ` : ''}
                            <div class="d-flex justify-content-end align-items-center mt-2">
                                ${!notification.is_read ? `
                                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="markAsRead(${notification.id}, '${contentId}')">Mark as Read</button>
                                ` : ''}
                                <button class="btn btn-danger btn-sm" onclick="deleteNotification(${notification.id}, '${contentId}')">
                                    Delete <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                notificationContent.innerHTML = html;
            } else {
                notificationContent.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-bell-slash text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">You have no new notifications.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            notificationContent.innerHTML = `
                <div class="text-center p-3">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <p class="mt-2 mb-0 text-muted">Error loading notifications.</p>
                    <small class="text-muted">Please try again later.</small>
                </div>
            `;
        });
    }
    
    function getStatusClass(status) {
        switch(status) {
            case 'approved': return 'bg-success';
            case 'rejected': return 'bg-danger';
            case 'cancelled': return 'bg-danger';
            case 'completed': return 'bg-primary';
            default: return 'bg-warning';
        }
    }
    
    function getStatusText(status) {
        switch(status) {
            case 'approved': return 'Approved!';
            case 'rejected': return 'Rejected';
            case 'cancelled': return 'Cancelled';
            case 'completed': return 'Completed';
            default: return status.charAt(0).toUpperCase() + status.slice(1);
        }
    }
    
    // Global functions for notification actions
    window.markAsRead = function(notificationId, contentId) {
        fetch(`/tourist/notifications/${notificationId}/mark-as-read`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications(contentId); // Reload notifications
                // Update notification count
                location.reload(); // Simple way to update the count badge
            }
        })
        .catch(error => console.error('Error marking as read:', error));
    };
    
    window.deleteNotification = function(notificationId, contentId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`/tourist/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(contentId); // Reload notifications
                    // Update notification count
                    location.reload(); // Simple way to update the count badge
                }
            })
            .catch(error => console.error('Error deleting notification:', error));
        }
    };
    
    // Add event listeners for dropdown show events
    if (mobileNotificationButton) {
        mobileNotificationButton.addEventListener('click', function() {
            loadNotifications('mobileNotificationContent');
        });
    }
    if (desktopNotificationButton) {
        desktopNotificationButton.addEventListener('click', function() {
            loadNotifications('desktopNotificationContent');
        });
     }
 });
 </script>