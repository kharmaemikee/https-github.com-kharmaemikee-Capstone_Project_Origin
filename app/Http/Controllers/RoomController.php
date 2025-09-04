<?php

namespace App\Http\Controllers;

use App\Models\Resort;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Import for Rule::in

class RoomController extends Controller
{
    /**
     * Display a listing of rooms for a specific resort.
     */
    public function index(Resort $resort)
    {
        // Role check as per your existing routes pattern
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns this resort
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Get rooms for this resort (exclude archived rooms)
        $rooms = $resort->rooms()->notArchived()->orderBy('room_name')->get();
        return view('resort_owner.rooms.index', compact('resort', 'rooms'));
    }

    /**
     * Show the form for creating a new room for a specific resort.
     */
    public function create(Resort $resort)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns this resort
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('resort_owner.rooms.create', compact('resort'));
    }

    /**
     * Store a newly created room in storage for a specific resort.
     */
    public function store(Request $request, Resort $resort)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns this resort
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $rules = [
            'room_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'is_available' => 'boolean', // Checkbox value is 1 if checked, absent if not
            'status' => ['required', Rule::in(['open', 'closed', 'maintenance'])], // New: Validate status
        ];

        // Conditional validation for rehab_reason
        if ($request->input('status') === 'maintenance') {
            $rules['rehab_reason'] = 'required|string|max:500';
        } else {
            $rules['rehab_reason'] = 'nullable|string'; // Ensure it's not required if not maintenance
        }

        $validatedData = $request->validate($rules);

        $imagePath = null;
        if ($request->hasFile('room_image')) {
            $imagePath = $request->file('room_image')->store('room_images', 'public');
        }

        // Create the room associated with this specific resort
        $resort->rooms()->create([
            'room_name' => $validatedData['room_name'],
            'description' => $validatedData['description'],
            'price_per_night' => $validatedData['price_per_night'],
            'max_guests' => $validatedData['max_guests'],
            'image_path' => $imagePath,
            'is_available' => $request->has('is_available'), // Based on the old checkbox
            'status' => $validatedData['status'], // NEW: Save the status
            'rehab_reason' => ($validatedData['status'] === 'maintenance') ? ($validatedData['rehab_reason'] ?? null) : null, // NEW: Save rehab_reason conditionally
            'admin_status' => 'pending', // Default for new rooms, awaiting admin approval
        ]);

        return redirect()->route('resort.owner.rooms.index', $resort->id)
                         ->with('success', 'Room added successfully to ' . $resort->resort_name . '!');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns the resort associated with this room
        if (Auth::id() !== $room->resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Pass the resort to the view as well, for consistency and navigation
        $resort = $room->resort;
        return view('resort_owner.rooms.edit', compact('room', 'resort'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns the resort associated with this room
        if (Auth::id() !== $room->resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $rules = [
            'room_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'delete_image_flag' => 'nullable|boolean',
            'is_available' => 'boolean', // Keep for compatibility, but `status` is preferred
            'status' => ['required', Rule::in(['open', 'closed', 'maintenance'])], // NEW: Validate status
        ];

        // Conditional validation for rehab_reason
        if ($request->input('status') === 'maintenance') {
            $rules['rehab_reason'] = 'required|string|max:500';
        } else {
            $rules['rehab_reason'] = 'nullable|string'; // Ensure it's not required if not maintenance
        }

        $validatedData = $request->validate($rules);

        $imagePath = $room->image_path; // Keep existing image path by default
        if ($request->hasFile('room_image')) {
            // Delete old image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('room_image')->store('room_images', 'public');
        } elseif ($request->input('delete_image_flag')) { // Specific flag to delete existing image
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = null;
        }

        $room->update([
            'room_name' => $validatedData['room_name'],
            'description' => $validatedData['description'],
            'price_per_night' => $validatedData['price_per_night'],
            'max_guests' => $validatedData['max_guests'],
            'image_path' => $imagePath,
            'is_available' => $request->has('is_available'), // Update based on checkbox, for compatibility
            'status' => $validatedData['status'], // NEW: Update the status
            'rehab_reason' => ($validatedData['status'] === 'maintenance') ? ($validatedData['rehab_reason'] ?? null) : null, // NEW: Update rehab_reason conditionally
        ]);

        return redirect()->route('resort.owner.rooms.index', $room->resort->id)
                         ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns the resort associated with this room
        if (Auth::id() !== $room->resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $resortId = $room->resort->id; // Get resort ID before deleting the room (for redirect)

        // Delete associated image file
        if ($room->image_path && Storage::disk('public')->exists($room->image_path)) {
            Storage::disk('public')->delete($room->image_path);
        }

        $room->delete();

        return redirect()->route('resort.owner.rooms.index', $resortId)
                         ->with('success', 'Room deleted successfully!');
    }

    /**
     * Archive the specified room.
     */
    public function archive(Room $room)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns the resort associated with this room
        if (Auth::id() !== $room->resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $room->archive();

        return redirect()->route('resort.owner.information')
                         ->with('success', 'Room archived successfully!');
    }

    /**
     * Restore the specified archived room.
     */
    public function restore(Room $room)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns the resort associated with this room
        if (Auth::id() !== $room->resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $room->unarchive();

        return redirect()->route('resort.owner.rooms.archive.index', $room->resort->id)
                         ->with('success', 'Room restored successfully!');
    }

    /**
     * Display archived rooms for a resort.
     */
    public function archiveIndex(Resort $resort)
    {
        // Role check
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }
        // Ensure the authenticated user owns the resort
        if (Auth::id() !== $resort->user_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $archivedRooms = $resort->rooms()->archived()->paginate(10);
            
            // Debug: Log the query and results
            Log::info('Archive query executed', [
                'resort_id' => $resort->id,
                'archived_rooms_count' => $archivedRooms->count(),
                'query' => $resort->rooms()->archived()->toSql()
            ]);
            
            // Additional debugging for the first room
            if ($archivedRooms->count() > 0) {
                $firstRoom = $archivedRooms->first();
                Log::info('First archived room debug', [
                    'room_id' => $firstRoom->id,
                    'room_name' => $firstRoom->room_name,
                    'archived' => $firstRoom->archived,
                    'archived_at' => $firstRoom->archived_at,
                    'archived_at_type' => gettype($firstRoom->archived_at),
                    'archived_at_class' => $firstRoom->archived_at ? get_class($firstRoom->archived_at) : 'null'
                ]);
            }
            
            return view('resort_owner.rooms.archive', compact('resort', 'archivedRooms'));
        } catch (\Exception $e) {
            Log::error('Error in archiveIndex: ' . $e->getMessage(), [
                'resort_id' => $resort->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Error loading archived rooms: ' . $e->getMessage());
        }
    }
}