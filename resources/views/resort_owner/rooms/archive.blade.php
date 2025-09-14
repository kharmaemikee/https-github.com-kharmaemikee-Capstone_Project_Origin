<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Rooms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="px-4 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="h4 mb-0">Archived Rooms for {{ $resort->resort_name }}</h3>
                        </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif



                    <div class="px-4">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Price / Night</th>
                                    <th scope="col">Max Guests</th>
                                    <th scope="col">Archived Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($archivedRooms as $room)
                                    <tr>
                                        <td>
                                            @if ($room->image_path)
                                                <img src="{{ asset($room->image_path) }}"
                                                    alt="{{ $room->room_name }}"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                    >
                                            @else
                                                <img src="{{ asset('images/default_room.png') }}"
                                                    alt="Default Room Image"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                            @endif
                                        </td>
                                        <td>{{ $room->room_name }}</td>
                                        <td>₱{{ number_format($room->price_per_night, 2) }}</td>
                                        <td>{{ $room->max_guests }}</td>
                                        <td>
                                            <span class="text-muted">
                                                @if($room->archived_at)
                                                    @if($room->archived_at instanceof \Carbon\Carbon)
                                                        {{ $room->archived_at->format('M d, Y H:i') }}
                                                    @else
                                                        {{ is_string($room->archived_at) ? $room->archived_at : 'Invalid Date' }}
                                                    @endif
                                                @else
                                                    Unknown
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-success btn-sm btn-icon restore-btn" data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}" title="Restore Room">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-icon delete-btn" data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}" title="Delete Room">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                                                                         <div class="text-muted">
                                                 <i class="fas fa-archive fa-3x mb-3"></i>
                                                 <p>No archived rooms found.</p>
                                             </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>

                    @if($archivedRooms->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $archivedRooms->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Custom CSS for icon buttons */
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-icon:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-icon i {
            font-size: 14px;
        }
        
        /* Enhanced tooltip styling */
        .tooltip {
            font-size: 12px;
            font-weight: 500;
        }
        
        .tooltip-inner {
            background-color: #333;
            color: white;
            border-radius: 4px;
            padding: 6px 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* SweetAlert2 Responsive Styles */
        .swal2-popup-responsive {
            font-size: 14px !important;
            max-width: 90% !important;
        }

        .swal2-title-responsive {
            font-size: 18px !important;
            line-height: 1.4 !important;
        }

        .swal2-content-responsive {
            font-size: 14px !important;
            line-height: 1.4 !important;
        }

        .swal2-confirm-responsive {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        .swal2-cancel-responsive {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .swal2-popup-responsive {
                font-size: 12px !important;
                max-width: 95% !important;
                margin: 10px !important;
            }

            .swal2-title-responsive {
                font-size: 16px !important;
            }

            .swal2-content-responsive {
                font-size: 12px !important;
            }

            .swal2-confirm-responsive,
            .swal2-cancel-responsive {
                font-size: 12px !important;
                padding: 6px 12px !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image error handling
            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null;
                imgElement.src = defaultImagePath;
            };

            // Restore room button logic
            document.querySelectorAll('.restore-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-room-id');
                    const roomName = this.getAttribute('data-room-name');
                    const roomRow = this.closest('tr');
                    
                    Swal.fire({
                        title: "Restore Room",
                        html: `Are you sure you want to restore <strong>${roomName}</strong>? This will make the room available again.`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, restore it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive',
                            confirmButton: 'swal2-confirm-responsive',
                            cancelButton: 'swal2-cancel-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Restoring...",
                                text: "Please wait while we restore the room.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-popup-responsive',
                                    title: 'swal2-title-responsive',
                                    content: 'swal2-content-responsive'
                                }
                            });
                            
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');
                            
                            fetch(`/resort_owner/rooms/restore/${roomId}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    if (roomRow) roomRow.remove();
                                    Swal.fire({
                                        title: "Restored!",
                                        text: "The room has been restored successfully.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                } else {
                                    throw new Error('Restore failed');
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to restore room. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive',
                                        confirmButton: 'swal2-confirm-responsive'
                                    }
                                });
                            });
                        }
                    });
                });
            });

            // Delete room button logic
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-room-id');
                    const roomName = this.getAttribute('data-room-name');
                    const roomRow = this.closest('tr');
                    
                    Swal.fire({
                        title: "Permanently Delete Room",
                        html: `
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Warning:</strong> This action cannot be undone. The room and all associated data will be permanently deleted.
                            </div>
                            Are you sure you want to permanently delete <strong>${roomName}</strong>?
                        `,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, delete permanently!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive',
                            confirmButton: 'swal2-confirm-responsive',
                            cancelButton: 'swal2-cancel-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Deleting...",
                                text: "Please wait while we permanently delete the room.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-popup-responsive',
                                    title: 'swal2-title-responsive',
                                    content: 'swal2-content-responsive'
                                }
                            });
                            
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');
                            
                            fetch(`/resort_owner/rooms/${roomId}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    if (roomRow) roomRow.remove();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The room has been permanently deleted.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete room. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive',
                                        confirmButton: 'swal2-confirm-responsive'
                                    }
                                });
                            });
                        }
                    });
                });
            });
            
            // Initialize Bootstrap tooltips for better tooltip functionality
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    placement: 'top',
                    trigger: 'hover'
                });
            });
        });
    </script>
</x-app-layout>
