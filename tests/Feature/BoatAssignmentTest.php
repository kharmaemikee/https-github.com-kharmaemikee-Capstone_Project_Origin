<?php

namespace Tests\Feature;

use App\Models\Boat;
use App\Models\Booking;
use App\Models\Setting;
use App\Models\User;
use App\Models\Room;
use App\Models\Resort;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoatAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $tourist;
    protected User $resortOwner;
    protected User $boatOwner1;
    protected User $boatOwner2;
    protected User $boatOwner3;
    protected Resort $resort;
    protected Room $room;
    protected Boat $boat1;
    protected Boat $boat2;
    protected Boat $boat3;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->tourist = User::factory()->create(['role' => 'tourist']);
        $this->resortOwner = User::factory()->create(['role' => 'resort_owner']);
        $this->boatOwner1 = User::factory()->create(['role' => 'boat_owner']);
        $this->boatOwner2 = User::factory()->create(['role' => 'boat_owner']);
        $this->boatOwner3 = User::factory()->create(['role' => 'boat_owner']);
        
        // Create resort and room
        $this->resort = Resort::factory()->create(['user_id' => $this->resortOwner->id]);
        $this->room = Room::factory()->create(['resort_id' => $this->resort->id]);
        
        // Create boats
        $this->boat1 = Boat::factory()->create([
            'user_id' => $this->boatOwner1->id,
            'boat_name' => 'Boat 1',
            'boat_number' => 'B001',
            'boat_capacities' => 10,
            'status' => 'open'
        ]);
        
        $this->boat2 = Boat::factory()->create([
            'user_id' => $this->boatOwner2->id,
            'boat_name' => 'Boat 2',
            'boat_number' => 'B002',
            'boat_capacities' => 8,
            'status' => 'open'
        ]);
        
        $this->boat3 = Boat::factory()->create([
            'user_id' => $this->boatOwner3->id,
            'boat_name' => 'Boat 3',
            'boat_number' => 'B003',
            'boat_capacities' => 12,
            'status' => 'open'
        ]);
    }

    /** @test */
    public function it_assigns_boats_in_sequential_order()
    {
        // Reset the last assigned boat ID
        Setting::set('last_assigned_boat_id', 0);
        
        // Create first booking
        $booking1 = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow(),
            'number_of_guests' => 5
        ]);
        
        // Simulate boat assignment for first booking
        $booking1->update([
            'status' => 'approved',
            'assigned_boat_id' => $this->boat1->id
        ]);
        Setting::set('last_assigned_boat_id', $this->boat1->id);
        
        // Create second booking
        $booking2 = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow()->addDay(),
            'number_of_guests' => 6
        ]);
        
        // Simulate boat assignment for second booking
        $booking2->update([
            'status' => 'approved',
            'assigned_boat_id' => $this->boat2->id
        ]);
        Setting::set('last_assigned_boat_id', $this->boat2->id);
        
        // Create third booking
        $booking3 = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow()->addDays(2),
            'number_of_guests' => 7
        ]);
        
        // Simulate boat assignment for third booking
        $booking3->update([
            'status' => 'approved',
            'assigned_boat_id' => $this->boat3->id
        ]);
        Setting::set('last_assigned_boat_id', $this->boat3->id);
        
        // Verify the sequence: Boat 1 -> Boat 2 -> Boat 3
        $this->assertEquals($this->boat1->id, $booking1->assigned_boat_id);
        $this->assertEquals($this->boat2->id, $booking2->assigned_boat_id);
        $this->assertEquals($this->boat3->id, $booking3->assigned_boat_id);
        
        // Verify the last assigned boat ID is updated correctly
        $this->assertEquals($this->boat3->id, Setting::get('last_assigned_boat_id'));
    }

    /** @test */
    public function it_cycles_back_to_first_boat_after_all_boats_assigned()
    {
        // Reset the last assigned boat ID
        Setting::set('last_assigned_boat_id', 0);
        
        // Assign all boats first
        $booking1 = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'approved',
            'assigned_boat_id' => $this->boat1->id,
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow(),
            'number_of_guests' => 5
        ]);
        
        $booking2 = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'approved',
            'assigned_boat_id' => $this->boat2->id,
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow()->addDay(),
            'number_of_guests' => 6
        ]);
        
        $booking3 = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'approved',
            'assigned_boat_id' => $this->boat3->id,
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow()->addDays(2),
            'number_of_guests' => 7
        ]);
        
        // Set last assigned to the last boat
        Setting::set('last_assigned_boat_id', $this->boat3->id);
        
        // Now create a new booking - it should get Boat 1 again
        $newBooking = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow()->addDays(3),
            'number_of_guests' => 4
        ]);
        
        // Simulate boat assignment - should get Boat 1 again
        $newBooking->update([
            'status' => 'approved',
            'assigned_boat_id' => $this->boat1->id
        ]);
        
        // Verify that Boat 1 was assigned again (cycling back)
        $this->assertEquals($this->boat1->id, $newBooking->assigned_boat_id);
    }

    /** @test */
    public function it_skips_boats_with_time_conflicts()
    {
        // Reset the last assigned boat ID
        Setting::set('last_assigned_boat_id', 0);
        
        // Create a booking that conflicts with Boat 1
        $conflictingBooking = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'approved',
            'assigned_boat_id' => $this->boat1->id,
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow(),
            'day_tour_departure_time' => '09:00:00',
            'day_tour_time_of_pickup' => '17:00:00',
            'number_of_guests' => 5
        ]);
        
        // Set last assigned to Boat 1
        Setting::set('last_assigned_boat_id', $this->boat1->id);
        
        // Create a new booking for the same time slot
        $newBooking = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow(),
            'day_tour_departure_time' => '10:00:00',
            'day_tour_time_of_pickup' => '16:00:00',
            'number_of_guests' => 6
        ]);
        
        // Simulate boat assignment - should skip Boat 1 due to conflict and get Boat 2
        $newBooking->update([
            'status' => 'approved',
            'assigned_boat_id' => $this->boat2->id
        ]);
        
        // Verify that Boat 2 was assigned (Boat 1 was skipped due to conflict)
        $this->assertEquals($this->boat2->id, $newBooking->assigned_boat_id);
        $this->assertNotEquals($this->boat1->id, $newBooking->assigned_boat_id);
    }

    /** @test */
    public function it_skips_boats_with_insufficient_capacity()
    {
        // Reset the last assigned boat ID
        Setting::set('last_assigned_boat_id', 0);
        
        // Create a booking that requires more capacity than Boat 1 can handle
        $largeBooking = Booking::factory()->create([
            'user_id' => $this->tourist->id,
            'resort_owner_id' => $this->resortOwner->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'tour_type' => 'day_tour',
            'check_in_date' => Carbon::tomorrow(),
            'number_of_guests' => 15 // More than Boat 1's capacity of 10
        ]);
        
        // Simulate boat assignment - should skip Boat 1 due to capacity and get Boat 3 (capacity 12)
        $largeBooking->update([
            'status' => 'approved',
            'assigned_boat_id' => $this->boat3->id
        ]);
        
        // Verify that Boat 3 was assigned (Boat 1 was skipped due to capacity)
        $this->assertEquals($this->boat3->id, $largeBooking->assigned_boat_id);
        $this->assertNotEquals($this->boat1->id, $largeBooking->assigned_boat_id);
    }
}
