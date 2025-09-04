<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100">
        {{-- You would typically include your boat owner sidebar here --}}
        {{-- For example, if you have a partial: @include('boat_owner.partials.sidebar') --}}
        {{-- Or paste the full sidebar content here as seen in editboat.blade.php --}}

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #A6A6A6;">
            <h4 class="fw-bold text-white text-center">{{ Auth::user()->username }}</h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mt-2">
                    <a href="{{ route('boat') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat') ? 'active' : '' }}">Boat Management</a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">Account Management</a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.rehab') }}" class="nav-link text-white bg-secondary rounded p-2 text-center active">Maintenance</a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">Notifications List</a>
                </li>
            </ul>
        </div>

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                &#9776;
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #A6A6A6; color: white;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold text-white" id="mobileSidebarLabel">{{ Auth::user()->username }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat') ? 'active' : '' }}">Boat Management</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">Dashboard</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">Account Management</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.rehab') }}" class="nav-link text-white bg-secondary rounded p-2 text-center active">Maintenance</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white bg-secondary rounded p-2 text-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">Notifications List</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex-grow-1 p-4">
            <h2 class="mb-4">Boat Owner Maintenance Section</h2>
            <div class="card p-4">
                <p>This page serves as a dedicated section for the boat owner to view or manage details related to their boat being under maintenance.</p>
                <p>You can add specific forms, updates, or informational messages here for boats marked as 'Maintenance'.</p>
                <p>For example, list boats currently in maintenance, or provide an option to submit updates on maintenance progress.</p>
            </div>
        </div>
    </div>
</x-app-layout>
