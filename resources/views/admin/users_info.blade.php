<x-app-layout>
    <!-- Fixed background layer -->
    <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd); background-attachment: fixed; background-size: 100vw 100vh; background-position: 0 0; z-index: -1; margin: 0; padding: 0;"></div>
    
    <div class="d-flex flex-column flex-md-row" style="min-height: 100vh; width: 100%; position: relative; z-index: 1; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

    {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Admin Menu
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.resort') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                        <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Boat Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <button class="nav-link text-white rounded p-2 d-flex align-items-center w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                        <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Users
                        <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                    </button>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapse">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.resorts') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.boats') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.tourists') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
                        <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Documentation
                    </a>
                </li>
            </ul>
        </div>
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                &#9776;
            </button>
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Admin Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.resort') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <button class="nav-link text-white rounded p-2 d-flex align-items-center w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapseMobile" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapseMobile">
                            <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Users
                            <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                        </button>
                        <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapseMobile">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.resorts') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.boats') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.tourists') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
                            <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Documentation
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex-grow-1 p-4">
            <h2 class="mb-4">{{ $userType ?? 'Users' }}</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            @if(($userType ?? 'All Users') === 'Tourist Users')
                                <th>Contact Number</th>
                            <th>Address</th>
                            @endif
                            
                            <th>Role</th>
                            @if(($userType ?? 'All Users') === 'Tourist Users')
                                
                            @else
                            <th>BIR</th>
                            <th>DTI</th>
                            <th>Biz Permit</th>
                                @if(($userType ?? 'All Users') === 'Resort Users')
                                    
                                @elseif(($userType ?? 'All Users') === 'Boat Users')
                                    <th>LGU Resolution</th>
                                    <th>Marina CPC</th>
                                    <th>Boat Assoc.</th>
                                @else
                            <th>LGU Resolution</th>
                            <th>Marina CPC</th>
                                    <th>Boat Assoc.</th>
                                @endif
                                @if(($userType ?? 'All Users') === 'Boat Users')
                                    
                                @else
                            <th>Tourism Registration</th>
                                @endif
                            @endif
                            <th>Approved</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr id="userRow{{ $user->id }}" data-role="{{ $user->role }}">
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->middle_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            @if(($userType ?? 'All Users') === 'Tourist Users')
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if($user->address)
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->address }}">
                                            {{ Str::limit($user->address, 20, '...') }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                            @endif
                            
                            <td>{{ $user->role }}</td>
                            @if(($userType ?? 'All Users') !== 'Tourist Users')
                             <td class="permitCell" data-type="bir_permit">
                                 @if ($user->bir_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->bir_permit_path)
                                     @if($user->bir_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->bir_permit_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="bir_permit">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                             
                             <td class="permitCell" data-type="dti_permit">
                                 @if ($user->dti_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->dti_permit_path)
                                     @if($user->dti_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->dti_permit_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="dti_permit">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                             
                             <td class="permitCell" data-type="business_permit">
                                 @if ($user->business_permit_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->business_permit_path)
                                     @if($user->business_permit_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->business_permit_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="business_permit">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                                 @endif
                             
                             @if(($userType ?? 'All Users') !== 'Resort Users' && ($userType ?? 'All Users') !== 'Tourist Users')
                             {{-- LGU Resolution --}}
                             <td class="permitCell" data-type="lgu_resolution">
                                 @if ($user->lgu_resolution_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->lgu_resolution_path)
                                     @if($user->lgu_resolution_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->lgu_resolution_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="lgu_resolution">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                             @endif
                             
                             @if(($userType ?? 'All Users') !== 'Resort Users' && ($userType ?? 'All Users') !== 'Tourist Users')
                             {{-- Marina CPC --}}
                             <td class="permitCell" data-type="marina_cpc">
                                 @if ($user->marina_cpc_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->marina_cpc_path)
                                     @if($user->marina_cpc_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->marina_cpc_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="marina_cpc">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                             @endif
                             
                             @if(($userType ?? 'All Users') !== 'Resort Users' && ($userType ?? 'All Users') !== 'Tourist Users')
                             {{-- Boat Association --}}
                             <td class="permitCell" data-type="boat_association">
                                 @if ($user->boat_association_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->boat_association_path)
                                     @if($user->boat_association_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->boat_association_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="boat_association">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                             @endif
                             
                             @if(($userType ?? 'All Users') !== 'Boat Users' && ($userType ?? 'All Users') !== 'Tourist Users')
                             {{-- Tourism Registration --}}
                             <td class="permitCell" data-type="tourism_registration">
                                 @if ($user->tourism_registration_approved)
                                     <span class="badge badge-light-success">✔</span>
                                 @elseif($user->tourism_registration_path)
                                     @if($user->tourism_registration_resubmitted)
                                         <span class="badge badge-light-warning">Resubmit</span>
                                     @else
                                         <button class="btn btn-sm btn-primary py-0 px-1 viewPermitBtn"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#viewPermitModal"
                                                 data-image-url="{{ asset($user->tourism_registration_path) }}"
                                                 data-user-id="{{ $user->id }}"
                                                 data-document-type="tourism_registration">
                                             View
                                         </button>
                                     @endif
                                 @else
                                     N/A
                                 @endif
                             </td>
                             @endif
                            <td id="userApproved{{ $user->id }}">
                                @if ($user->is_approved)
                                    <span class="badge badge-light-success rounded-pill">Yes</span>
                                @else
                                    <span class="badge badge-light-warning rounded-pill">No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center flex-nowrap gap-2">
                                    <button type="button" class="btn btn-info btn-sm action-btn view-btn" 
                                        data-bs-toggle="modal" data-bs-target="#viewUserDetailsModal"
                                        data-username="{{ $user->username }}"
                                        data-birthday="{{ $user->birthday }}"
                                        data-gender="{{ $user->gender }}"
                                        data-address="{{ $user->address }}"
                                        data-phone="{{ $user->phone }}"
                                        data-nationality="{{ $user->nationality }}"
                                        data-first-name="{{ $user->first_name }}"
                                        data-middle-name="{{ $user->middle_name }}"
                                        data-last-name="{{ $user->last_name }}"
                                        data-owner-image="{{ $user->owner_image_path ? asset($user->owner_image_path) : '' }}"
                                        title="View details" aria-label="View details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-user-id="{{ $user->id }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- View User Details Modal -->
    <div class="modal fade" id="viewUserDetailsModal" tabindex="-1" aria-labelledby="viewUserDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserDetailsModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <img id="detailOwnerImage" src="" alt="Profile" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; margin-right: 12px; display: none;">
                        <div class="mb-0"><strong>Name:</strong> <span id="detailFullName">N/A</span></div>
                    </div>
                    <div class="mb-2"><strong>Username:</strong> <span id="detailUsername">N/A</span></div>
                    <div class="mb-2"><strong>B-day:</strong> <span id="detailBirthday">N/A</span></div>
                    <div class="mb-2"><strong>Gender:</strong> <span id="detailGender">N/A</span></div>
                    @if(($userType ?? 'All Users') !== 'Tourist Users')
                        <div class="mb-2"><strong>Address:</strong> <span id="detailAddress">N/A</span></div>
                        <div class="mb-2"><strong>Contact Number:</strong> <span id="detailPhone">N/A</span></div>
                    @endif
                    <div class="mb-2"><strong>Nationality:</strong> <span id="detailNationality">N/A</span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewPermitModal" tabindex="-1" aria-labelledby="viewPermitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPermitModalLabel">View Permit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="permitImage" src="" alt="Permit Document" class="img-fluid" style="max-height: 80vh;">
                    
                    <!-- Resubmit Reason Input (hidden by default) -->
                    <div id="resubmitReasonSection" class="mt-3" style="display: none;">
                        <label for="resubmitReason" class="form-label text-start">Reason for Resubmission:</label>
                        <textarea id="resubmitReason" class="form-control" rows="3" placeholder="Please provide a reason why this permit needs to be resubmitted..."></textarea>
                        <div id="resubmitReasonError" class="text-danger small mt-1" style="display: none;"></div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <button type="button" id="approvePermitButton" class="btn btn-success rounded-pill">Approve</button>
                        <button type="button" id="requestResubmitButton" class="btn btn-warning rounded-pill">Resubmit</button>
                        <button type="button" id="confirmResubmitButton" class="btn btn-danger rounded-pill" style="display: none;">Confirm Resubmit</button>
                        <button type="button" id="cancelResubmitButton" class="btn btn-secondary rounded-pill" style="display: none;">Cancel</button>
                    </div>
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .badge-light-success {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }
        .badge-light-warning {
            background-color: #fff3cd !important;
            color: #85640a !important;
            border: 1px solid #ffeeba !important;
        }
        .badge-success {
            background-color: #28a745 !important;
            color: #fff !important;
        }

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Custom CSS for light background badges */
        .badge-light-success {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }

        .badge-light-warning {
            background-color: #fff3cd !important;
            color: #85640a !important;
            border: 1px solid #ffeeba !important;
        }

        .badge-light-danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }

        .badge-light-info {
            background-color: #e0f7fa !important;
            color: #0c5460 !important;
            border: 1px solid #b8daff !important;
        }

        .badge-light-secondary {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #d3d6da !important;
        }

        .badge-light-black {
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        /* Set width for mobile offcanvas sidebar */
        #mobileSidebar {
            width: 50vw; /* This makes it half the viewport width */
        }

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease; /* Smooth transition for rotation */
        }

        .collapse-icon.rotated {
            transform: rotate(180deg); /* Rotates the arrow downwards */
        }

        /* NEW STYLE: for disabled link */
        .disabled-link {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
        }

        /* Action button styles */
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .action-btn i {
            font-size: 14px;
        }

        /* Custom tooltip for delete button */
        .delete-btn {
            position: relative;
        }

        .delete-btn::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
            margin-bottom: 5px;
        }

        .delete-btn:hover::after {
            opacity: 1;
            visibility: visible;
        }
    </style>
   <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sync arrow rotation with collapse show/hide
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });
            let currentUserId = null;
            let currentDocumentType = null;
            let currentViewButtonEl = null;
            const csrfToken = (document.querySelector('meta[name="csrf-token"]')?.content) || '{{ csrf_token() }}';
            const approvePermitBase = "{{ url('/admin/users') }}";
            
            // View Permit buttons
            document.querySelectorAll('.viewPermitBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const imageUrl = this.getAttribute('data-image-url');
                    currentUserId = this.getAttribute('data-user-id');
                    currentDocumentType = this.getAttribute('document_type') || this.getAttribute('data-document-type');
                    currentViewButtonEl = this;
                    document.getElementById('permitImage').src = imageUrl;
                    
                    const parentCell = this.closest('td');
                    const userRow = this.closest('tr');
                    const userRole = userRow?.dataset?.role || '';
                    
                    // Show approve button only if permit not yet approved, user is not a tourist, and not owner_image (auto-approved)
                    const isApproved = parentCell.querySelector('.badge-light-success');
                    const isTourist = userRole === 'tourist';
                    const isOwnerImage = currentDocumentType === 'owner_image';
                    document.getElementById('approvePermitButton').style.display =
                        (isApproved || isTourist || isOwnerImage) ? 'none' : 'inline-block';
                    // Enable/disable Approve based on resubmit pending for this specific permit cell
                    const approveBtn = document.getElementById('approvePermitButton');
                    const resubmitBtn = document.getElementById('requestResubmitButton');
                    
                    if (approveBtn) {
                        const isResubmitPending = parentCell && parentCell.dataset && parentCell.dataset.resubmitPending === 'true';
                        approveBtn.disabled = !!isResubmitPending || isTourist || isOwnerImage;
                        approveBtn.title = isResubmitPending ? 'Disabled: awaiting new upload after resubmission request for this permit' : 
                                          isTourist ? 'Tourists do not require approval' : isOwnerImage ? 'Owner image is auto-approved' : '';
                    }
                    
                    // Hide resubmit button for tourists and owner_image (auto-approved)
                    if (resubmitBtn) {
                        resubmitBtn.style.display = (isTourist || isOwnerImage) ? 'none' : 'inline-block';
                    }
                    
                    // Reset resubmit reason input and buttons when viewing a permit
                    document.getElementById('resubmitReasonSection').style.display = 'none';
                    document.getElementById('resubmitReason').value = '';
                    document.getElementById('resubmitReasonError').style.display = 'none';
                    document.getElementById('requestResubmitButton').style.display = (isTourist || isOwnerImage) ? 'none' : 'inline-block';
                    document.getElementById('confirmResubmitButton').style.display = 'none';
                    document.getElementById('cancelResubmitButton').style.display = 'none';
                });
            });
            
            // Approve permit in modal
            document.getElementById('approvePermitButton').addEventListener('click', function () {
                if (!currentUserId || !currentDocumentType) return;
                const btn = this;
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Approving...';

                fetch(`${approvePermitBase}/${currentUserId}/approve-permit`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ document_type: currentDocumentType })
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(`Request failed (${response.status}): ${text}`);
                    }
                    const ct = response.headers.get('content-type') || '';
                    if (!ct.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but received: ${text.substring(0, 200)}...`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById('userRow' + currentUserId);
                        const permitCell = row.querySelector(`td.permitCell[data-type="${currentDocumentType}"]`);
                        
                        // Replace the clicked View button with a check icon/badge
                        if (currentViewButtonEl) {
                            const checkSpan = document.createElement('span');
                            checkSpan.className = 'badge badge-light-success';
                            checkSpan.textContent = '✔';
                            currentViewButtonEl.replaceWith(checkSpan);
                        } else {
                            // Fallback: update entire cell if button ref is missing
                            permitCell.innerHTML = '<span class="badge badge-light-success">✔</span>';
                        }
                        
                        // Check if all permits are approved after this action
                        const allPermitCells = row.querySelectorAll('.permitCell');
                        let fullyApproved = true;
                        allPermitCells.forEach(cell => {
                            if (cell.querySelector('button.viewPermitBtn')) {
                                fullyApproved = false;
                            }
                        });
        
                        if (fullyApproved) {
                            // Update the overall approved status
                            row.querySelector(`#userApproved${currentUserId}`).innerHTML =
                                '<span class="badge badge-light-success rounded-pill">Yes</span>';
                            
                            // Remove the "Approve" button
                            const approveButton = row.querySelector('form .btn-primary');
                            if (approveButton) approveButton.remove();

                            // Convert any remaining View buttons to check badges
                            row.querySelectorAll('button.viewPermitBtn').forEach(btn => {
                                const checkSpan = document.createElement('span');
                                checkSpan.className = 'badge badge-light-success';
                                checkSpan.textContent = '✔';
                                btn.replaceWith(checkSpan);
                            });
                        }
                        
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('viewPermitModal'));
                        modal.hide();
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    } else {
                        console.error("Failed to approve. Please try again.");
                        let err = document.getElementById('approveError');
                        if (!err) {
                            err = document.createElement('div');
                            err.id = 'approveError';
                            err.className = 'text-danger small mt-2';
                            document.querySelector('#viewPermitModal .modal-footer').prepend(err);
                        }
                        err.textContent = data.message || 'Approval failed. Please try again.';
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    }
                })
                .catch(err => {
                    console.error(err);
                    let e = document.getElementById('approveError');
                    if (!e) {
                        e = document.createElement('div');
                        e.id = 'approveError';
                        e.className = 'text-danger small mt-2';
                        document.querySelector('#viewPermitModal .modal-footer').prepend(e);
                    }
                    
                    // Try to parse error message from response
                    let errorMessage = 'Approval failed. Please refresh and try again.';
                    if (err.message && err.message.includes('Cannot approve permit')) {
                        errorMessage = err.message.split(': ')[1] || err.message;
                    }
                    
                    e.textContent = errorMessage;
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
            });

            // Show resubmit reason input when Resubmit button is clicked
            document.getElementById('requestResubmitButton').addEventListener('click', function () {
                if (!currentUserId || !currentDocumentType) return;
                
                // Show reason input section
                document.getElementById('resubmitReasonSection').style.display = 'block';
                document.getElementById('resubmitReason').value = '';
                document.getElementById('resubmitReasonError').style.display = 'none';
                
                // Hide/show buttons
                document.getElementById('requestResubmitButton').style.display = 'none';
                document.getElementById('confirmResubmitButton').style.display = 'inline-block';
                document.getElementById('cancelResubmitButton').style.display = 'inline-block';
            });

            // Cancel resubmit - hide reason input and show original buttons
            document.getElementById('cancelResubmitButton').addEventListener('click', function () {
                document.getElementById('resubmitReasonSection').style.display = 'none';
                document.getElementById('resubmitReasonError').style.display = 'none';
                
                // Show/hide buttons
                document.getElementById('requestResubmitButton').style.display = 'inline-block';
                document.getElementById('confirmResubmitButton').style.display = 'none';
                document.getElementById('cancelResubmitButton').style.display = 'none';
            });

            // Confirm resubmit with reason
            document.getElementById('confirmResubmitButton').addEventListener('click', function () {
                if (!currentUserId || !currentDocumentType) return;
                
                const reason = document.getElementById('resubmitReason').value.trim();
                if (!reason) {
                    document.getElementById('resubmitReasonError').textContent = 'Please provide a reason for resubmission.';
                    document.getElementById('resubmitReasonError').style.display = 'block';
                    return;
                }
                
                const btn = this;
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Requesting...';

                fetch(`${approvePermitBase}/${currentUserId}/request-resubmit-permit`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ 
                        document_type: currentDocumentType,
                        reason: reason
                    })
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(`Request failed (${response.status}): ${text}`);
                    }
                    const ct = response.headers.get('content-type') || '';
                    if (!ct.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but received: ${text.substring(0, 200)}...`);
                    }
                    return response.json();
                })
                .then(data => {
                    let info = document.getElementById('resubmitInfo');
                    if (!info) {
                        info = document.createElement('div');
                        info.id = 'resubmitInfo';
                        info.className = 'text-success small mt-2';
                        document.querySelector('#viewPermitModal .modal-footer').prepend(info);
                    }
                    info.textContent = 'Resubmission request sent to owner with reason.';
                    
                    // Hide reason input and reset buttons
                    document.getElementById('resubmitReasonSection').style.display = 'none';
                    document.getElementById('requestResubmitButton').style.display = 'inline-block';
                    document.getElementById('confirmResubmitButton').style.display = 'none';
                    document.getElementById('cancelResubmitButton').style.display = 'none';
                    
                    // Mark only this permit cell as resubmit-pending and disable Approve for this doc only
                    const row = document.getElementById('userRow' + currentUserId);
                    const permitCell = row ? row.querySelector(`td.permitCell[data-type="${currentDocumentType}"]`) : null;
                    if (permitCell) {
                        permitCell.dataset.resubmitPending = 'true';
                        
                        // Update the status badge in the admin table to show "Resubmit"
                        const statusBadge = permitCell.querySelector('.badge');
                        if (statusBadge) {
                            statusBadge.className = 'badge badge-light-warning';
                            statusBadge.textContent = 'Resubmit';
                        }
                    }
                    const approveBtn = document.getElementById('approvePermitButton');
                    if (approveBtn) {
                        approveBtn.disabled = true;
                        approveBtn.title = 'Disabled: awaiting new upload after resubmission request for this permit';
                    }
                    
                    // Send real-time update to user's verified page (if they have it open)
                    // This will update the status on their end immediately
                    if (window.parent !== window) {
                        // If this is in an iframe, send message to parent
                        window.parent.postMessage({
                            type: 'permit_resubmitted',
                            userId: currentUserId,
                            documentType: currentDocumentType,
                            reason: reason
                        }, '*');
                    }
                    
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                })
                .catch(err => {
                    console.error(err);
                    let e = document.getElementById('approveError');
                    if (!e) {
                        e = document.createElement('div');
                        e.id = 'approveError';
                        e.className = 'text-danger small mt-2';
                        document.querySelector('#viewPermitModal .modal-footer').prepend(e);
                    }
                    e.textContent = 'Failed to send resubmission request. Please try again.';
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
            });
            
            // (Resubmit removed)

            // Wire up View User Details modal
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const username = this.getAttribute('data-username') || 'N/A';
                    const birthday = this.getAttribute('data-birthday') || 'N/A';
                    const gender = this.getAttribute('data-gender') || 'N/A';
                    const address = this.getAttribute('data-address') || 'N/A';
                    const phone = this.getAttribute('data-phone') || 'N/A';
                    const nationality = this.getAttribute('data-nationality') || 'N/A';
                    const ownerImage = this.getAttribute('data-owner-image') || '';
                    const firstName = this.getAttribute('data-first-name') || '';
                    const middleName = this.getAttribute('data-middle-name') || '';
                    const lastName = this.getAttribute('data-last-name') || '';

                    const u = document.getElementById('detailUsername');
                    const b = document.getElementById('detailBirthday');
                    const g = document.getElementById('detailGender');
                    const a = document.getElementById('detailAddress');
                    const p = document.getElementById('detailPhone');
                    const n = document.getElementById('detailNationality');
                    const img = document.getElementById('detailOwnerImage');
                    if (u) u.textContent = username;
                    if (b) b.textContent = birthday;
                    if (g) g.textContent = gender;
                    if (a) a.textContent = address;
                    if (p) p.textContent = phone;
                    if (n) n.textContent = nationality;
                    const nameSpan = document.getElementById('detailFullName');
                    if (nameSpan) {
                        const parts = [firstName, middleName, lastName].filter(Boolean);
                        nameSpan.textContent = parts.join(' ');
                    }
                    if (img) {
                        if (ownerImage) {
                            img.src = ownerImage;
                            img.style.display = 'inline-block';
                        } else {
                            img.src = '';
                            img.style.display = 'none';
                        }
                    }
                });
            });
            
            // Handle delete modal
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const form = document.getElementById('deleteUserForm');
                if(form) form.action = `/admin/users/${userId}`;
            });
            
            // Enable Bootstrap tooltips (for view button hover text)
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</x-app-layout>