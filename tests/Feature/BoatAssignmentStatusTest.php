<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Boat;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Resort;
use App\Models\Setting;
use Carbon\Carbon;

class BoatAssignmentStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->boatOwner = User::factory()->boatOwner()->create();
        $this->resortOwner = User::factory()->resortOwner()->create();
        $this->tourist = User::factory()->tourist()->create();
        
        // Create a resort
        $this->resort = Resort::create([
            'user_id' => $this->resortOwner->id,
            'resort_name' => 'Test Resort',
            'description' => 'Test Description',
            'location' => 'Test Address',
            'status' => 'open',
            'admin_status' => 'approved',
        ]);
        
        // Create a room
        $this->room = Room::create([
            'resort_id' => $this->resort->id,
            'room_name' => 'Test Room',
            'price_per_night' => 100,
            'max_guests' => 2,
            'status' => 'open',
            'admin_status' => 'approved',
        ]);
        
        // Create boats
        $this->boat1 = Boat::create([
            'user_id' => $this->boatOwner->id,
            'boat_name' => 'Test Boat 1',
            'boat_number' => 'TB001',
            'boat_prices' => 50,
            'boat_capacities' => 10,
            'status' => 'open',
            'admin_status' => 'approved',
        ]);
        
        $this->boat2 = Boat::create([
            'user_id' => $this->boatOwner->id,
            'boat_name' => 'Test Boat 2',
            'boat_number' => 'TB002',
            'boat_prices' => 60,
            'boat_capacities' => 15,
            'status' => 'open',
            'admin_status' => 'approved',
        ]);
        
        // Initialize settings
        Setting::set('last_assigned_boat_id', 0);
    }

    public function test_boat_status_changes_to_assigned_when_booking_confirmed()
    {
        // Create a booking
        $booking = Booking::create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'guest_name' => 'Test Guest',
            'guest_age' => 25,
            'guest_gender' => 'male',
            'guest_address' => 'Test Address',
            'guest_nationality' => 'Filipino',
            'phone_number' => '09123456789',
            'check_in_date' => Carbon::tomorrow(),
            'check_out_date' => null,
            'number_of_nights' => 0,
            'number_of_guests' => 5,
            'tour_type' => 'day_tour',
            'day_tour_departure_time' => '09:00:00',
            'day_tour_time_of_pickup' => '17:00:00',
            'status' => 'pending',
        ]);

        // Simulate booking confirmation (this would normally be done by the resort owner)
        $this->actingAs($this->resortOwner);
        
        // Get the next boat for assignment
        $nextBoat = Boat::getNextBoatForAssignment(0);
        $this->assertNotNull($nextBoat);
        
        // Mark the boat as assigned
        $nextBoat->markAsAssigned();
        
        // Verify the boat status changed to assigned
        $this->assertEquals('assigned', $nextBoat->fresh()->status);
        
        // Verify the boat is no longer available for assignment
        $availableBoats = Boat::where('status', 'open')->get();
        $this->assertFalse($availableBoats->contains($nextBoat->id));
    }

    public function test_boat_status_changes_to_open_when_booking_period_ends()
    {
        // Create a boat with assigned status
        $this->boat1->update(['status' => 'assigned']);
        
        // Create a past booking
        $pastBooking = Booking::create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'guest_name' => 'Past Guest',
            'guest_age' => 30,
            'guest_gender' => 'female',
            'guest_address' => 'Past Address',
            'guest_nationality' => 'Filipino',
            'phone_number' => '09123456789',
            'check_in_date' => Carbon::yesterday(),
            'check_out_date' => null,
            'number_of_nights' => 0,
            'number_of_guests' => 3,
            'tour_type' => 'day_tour',
            'day_tour_departure_time' => '09:00:00',
            'day_tour_time_of_pickup' => '17:00:00',
            'status' => 'approved',
            'assigned_boat_id' => $this->boat1->id,
        ]);
        
        // Mark boat as available (simulating the command execution)
        $this->boat1->markAsAvailable();
        
        // Verify the boat status changed back to open
        $this->assertEquals('open', $this->boat1->fresh()->status);
    }

    public function test_sequential_assignment_maintains_numbering()
    {
        // Set the last assigned boat ID to boat1
        Setting::set('last_assigned_boat_id', $this->boat1->id);
        
        // Get boats in assignment sequence
        $boatsInSequence = Boat::getBoatsInAssignmentSequence($this->boat1->id);
        
        // The next boat should be boat2 (since boat1 was last assigned)
        $this->assertEquals($this->boat2->id, $boatsInSequence->first()->id);
        
        // After boat2 is assigned, the sequence should cycle back to boat1
        Setting::set('last_assigned_boat_id', $this->boat2->id);
        $nextSequence = Boat::getBoatsInAssignmentSequence($this->boat2->id);
        $this->assertEquals($this->boat1->id, $nextSequence->first()->id);
    }

    public function test_boat_owner_cannot_change_assigned_status()
    {
        // Set boat status to assigned
        $this->boat1->update(['status' => 'assigned']);
        
        // Try to change status as boat owner
        $this->actingAs($this->boatOwner);
        
        $response = $this->put(route('boat.owner.update_status', $this->boat1->id), [
            'status' => 'open'
        ]);
        
        // Should be redirected back with error
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
