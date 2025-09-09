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
                                                <button type="button" class="btn btn-success btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#restoreRoomModal" data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}" title="Restore Room">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#deleteRoomModal" data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}" title="Delete Room">
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

    {{-- Restore Room Modal --}}
    <div class="modal fade" id="restoreRoomModal" tabindex="-1" aria-labelledby="restoreRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreRoomModalLabel">Restore Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to restore <strong id="restoreRoomName"></strong>? This will make the room available again.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="restoreRoomForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Confirm Restore</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Room Modal --}}
    <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomModalLabel">Permanently Delete Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning:</strong> This action cannot be undone. The room and all associated data will be permanently deleted.
                    </div>
                    Are you sure you want to permanently delete <strong id="deleteRoomName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteRoomForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Permanently Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle restore room modal
            const restoreModal = document.getElementById('restoreRoomModal');
            if (restoreModal) {
                restoreModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const roomId = button.getAttribute('data-room-id');
                    const roomName = button.getAttribute('data-room-name');
                    const form = restoreModal.querySelector('#restoreRoomForm');
                    const nameSpan = restoreModal.querySelector('#restoreRoomName');
                    
                    form.action = '/resort_owner/rooms/restore/' + roomId;
                    console.log('Restore form action set to:', form.action);
                    console.log('Room ID for restore:', roomId);
                    nameSpan.textContent = roomName;
                });
            }

            // Handle delete room modal
            const deleteModal = document.getElementById('deleteRoomModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const roomId = button.getAttribute('data-room-id');
                    const roomName = button.getAttribute('data-room-name');
                    const form = deleteModal.querySelector('#deleteRoomForm');
                    const nameSpan = deleteModal.querySelector('#deleteRoomName');
                    
                    form.action = '/resort_owner/rooms/' + roomId;
                    nameSpan.textContent = roomName;
                });
            }

            // Image error handling
            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null;
                imgElement.src = defaultImagePath;
            };
            
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
