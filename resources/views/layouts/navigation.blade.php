<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
    <div class="container-fluid d-flex align-items-center" style="padding: 0px 15px; height: 50px;">
        {{-- Back arrow --}}
        {{-- Welcome text --}}
        <div class="d-flex align-items-center">
            <a class="nav-link d-inline-block {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <h5 class="m-0" style="padding-left: 5px !important; font-size: 1.1rem; padding-bottom: 37px; ">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            Welcome Admin
                        @elseif(Auth::user()->role === 'resort_owner')
                        Welcome {{ Auth::user()->username }}
                        @elseif(Auth::user()->role === 'boat_owner')
                        Welcome {{ Auth::user()->username }}
                        @elseif(Auth::user()->role === 'tourist')
                        Welcome {{ Auth::user()->username }} to Subic Beach
                        @else
                            Welcome to our resorts
                        @endif
                    @else
                        Welcome to our resorts
                    @endauth
                </h4>
            </a>
        </div>

        {{-- User Menu for Mobile --}}
        <div class="d-md-none ms-auto" > 
            <div class="dropdown" style="padding-bottom: 40px">
                @auth
                    @if((in_array(Auth::user()->role, ['resort_owner', 'boat_owner']) && Auth::user()->owner_image_path && Auth::user()->owner_pic_approved)
                        || (Auth::user()->role === 'tourist' && Auth::user()->owner_image_path))
                        {{-- Show image for owners (approved only) or tourist (no approval needed) --}}
                        <button class="btn btn-light border-0" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;  bottom: 0px;">
                            <img src="{{ asset(Auth::user()->owner_image_path) }}" 
                                 alt="Owner Image" 
                                 class="rounded-circle owner-image" 
                                 style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #007bff;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="rounded-circle owner-image-fallback" style="width: 32px; height: 32px; display: none;">
                                <i class="fas fa-user"></i>
                            </div>
                        </button>
                    @else
                        {{-- Show default icon for other users or unapproved images --}}
                        <button class="btn btn-light border-0" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i> <span class="visually-hidden">User Menu</span>
                        </button>
                    @endif
                @else
                    <button class="btn btn-light border-0" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i> <span class="visually-hidden">User Menu</span>
                    </button>
                @endauth
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileMenuButton">
                    <li></li>
                        <h6 class="dropdown-header">
                            @auth
                                {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}
                            @else
                                Guest
                            @endauth
                        </h6>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @auth
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Log Out</button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        {{-- User Menu for Desktop --}}
        <div class="dropdown d-none d-md-block ms-auto">
            @auth
                @if((in_array(Auth::user()->role, ['resort_owner', 'boat_owner']) && Auth::user()->owner_image_path && Auth::user()->owner_pic_approved)
                    || (Auth::user()->role === 'tourist' && Auth::user()->owner_image_path))
                    {{-- Show image with name for owners (approved only) or tourist (no approval needed) --}}
                    <a href="#" class="text-decoration-none d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding-bottom: 0px; ">
                        <span class="text-primary me-2" style="font-size: 0.9rem;">
                            {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}
                        </span>
                        <img src="{{ asset(Auth::user()->owner_image_path) }}" 
                             alt="Owner Image" 
                             class="rounded-circle owner-image" 
                             style="width: 28px; height: 28px; object-fit: cover; border: 1px solid #007bff;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="rounded-circle owner-image-fallback" style="width: 28px; height: 28px; display: none;">
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
                @else
                    {{-- Show default text for other users or unapproved images --}}
                    <a href="#" class="text-primary text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 20px 40px;">
                        {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}
                    </a>
                @endif
            @else
                <a href="#" class="text-primary text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 20px 40px;">
                    Guest
                </a>
            @endauth
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                @auth
                    @if(in_array(Auth::user()->role, ['resort_owner', 'boat_owner', 'tourist']))
                        <li>
                            <h6 class="dropdown-header text-primary">
                                Hi {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}!
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Log Out</button>
                        </form>
                    </li>
                @else
                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    body {
        /* Add padding-top to the body to prevent content from being hidden behind the fixed navbar */
        padding-top: 50px; /* Mobile devices (phones, small tablets) - up to 767px */
    }

    /* Tablet devices (portrait/landscape) - 768px to 991.98px */
    @media (min-width: 768px) and (max-width: 991.98px) {
        body { padding-top: 50px; }
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 40px !important;
            margin-top: -10px !important;
        }
        #userDropdown { height: 50px; display: flex; align-items: center; margin-top: -30px !important; }
    }

    /* Medium desktops and larger tablets - 992px to 1199.98px */
    @media (min-width: 992px) and (max-width: 1199.98px) {
        body { padding-top: 50px; }
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-top: -10px !important;
        }
        #userDropdown { height: 50px; display: flex; align-items: center; }
    }

    /* Large desktops - 1200px to 1399.98px */
    @media (min-width: 1200px) and (max-width: 1399.98px) {
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-top: -10px !important;
        }
    }

   

    /* Extra large desktops - 1400px and above */
    @media (min-width: 1400px) {
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-bottom: -10px !important;
        }
    }

    .fa-ellipsis-v {
        font-size: 20px;
        color: #6c757d;
    }

    .fa-arrow-left {
        font-size: 24px;
        color: #007bff;
    }

    @media (max-width: 575.98px) {
        /* Extra-small phones - up to 575.98px */
        .navbar h5, .navbar .nav-link h5 {
            font-size: 4vw !important;
            padding-top: 0px !important;
            padding-bottom: 80px !important;
            margin-top: 0px !important;
        }
    }

    @media (min-width: 576px) and (max-width: 767.98px) {
        /* Small phones and small tablets - 576px to 767.98px */
        .navbar h5, .navbar .nav-link h5 {
            font-size: 3.7vw !important;
            padding-top: 0px !important;
            padding-bottom: 90px !important;
            margin-top: 0px !important;
        }
    }

    @media (min-width: 768px) { /* Bootstrap's 'md' breakpoint is 768px */
        /* Desktop devices (laptops, desktops, large tablets) - 768px and above */
        body {
            padding-top: 50px; /* Desktop and large tablet devices */
        }
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-top: 20px !important;
        }
    }

    /* Owner image styles */
    .owner-image {
        transition: transform 0.2s ease-in-out;
    }

    .owner-image:hover {
        transform: scale(1.05);
    }

    /* Fallback for broken images */
    .owner-image-fallback {
        background-color: #f8f9fa;
        border: 2px solid #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #007bff;
        font-weight: bold;
    }

    /* Force navbar to be 50px height with consistent padding - applies to ALL screen sizes */
    .navbar {
        min-height: 50px !important;
        height: 50px !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }

    .navbar .container-fluid {
        min-height: 50px !important;
        height: 50px !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }

    /* Universal rule for navigation h5 padding - applies to ALL screen sizes */
    .navbar .nav-link h5 {
        padding-bottom: 35px !important;
    }

    
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />