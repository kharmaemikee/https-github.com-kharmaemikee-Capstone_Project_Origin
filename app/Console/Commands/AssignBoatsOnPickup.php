<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Boat;
use App\Models\Booking;
use App\Models\TouristNotification;
use App\Models\BoatOwnerNotification;
use App\Models\ResortOwnerNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AssignBoatsOnPickup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boats:assign-on-pickup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark boats as assigned when their pickup time arrives';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting boat assignment on pickup process...');
        
        $assignedCount = 0;
        $now = Carbon::now();
        
        // Get all approved bookings that have assigned boats but haven't started yet
        $bookings = Booking::where('status', 'approved')
            ->whereNotNull('assigned_boat_id')
            ->with(['assignedBoat'])
            ->get();
        
        foreach ($bookings as $booking) {
            $shouldAssign = false;
            $pickupTime = null;
            
            // New rule: Assign when the calendar date of the reservation arrives (start of check-in day)
            $reservationStart = Carbon::parse($booking->check_in_date)->startOfDay();
            $pickupTime = $reservationStart; // for logging
            $shouldAssign = $now->gte($reservationStart);
            
            if ($shouldAssign && $booking->assignedBoat && $booking->assignedBoat->status === 'open') {
                // Mark the boat as assigned
                $booking->assignedBoat->markAsAssigned();
                $assignedCount++;
                
                $this->info("  - Boat {$booking->assignedBoat->boat_name} marked as assigned for booking {$booking->id} (Pickup: {$pickupTime})");
                
                // Log the status change
                Log::info("Boat {$booking->assignedBoat->boat_name} (ID: {$booking->assignedBoat->id}) status changed from 'open' to 'assigned' for booking {$booking->id} - assignment window reached");

                // Notify Tourist, Boat Owner, and Resort Owner that boat is now assigned (at T-30 mins)
                try {
                    TouristNotification::create([
                        'user_id' => $booking->user_id,
                        'booking_id' => $booking->id,
                        'message' => 'Today is your reservation date. Your boat ' . ($booking->assignedBoat->boat_name ?? 'N/A') . ' has been assigned. Have a great trip!',
                        'type' => 'boat_now_assigned',
                        'is_read' => false,
                    ]);
                } catch (\Exception $e) { /* swallow notify errors */ }

                try {
                    BoatOwnerNotification::create([
                        'user_id' => $booking->assignedBoat->user_id,
                        'booking_id' => $booking->id,
                        'message' => 'Your boat ' . ($booking->assignedBoat->boat_name ?? 'N/A') . ' has been assigned to ' . ($booking->user->name ?? 'Guest') . ' for today\'s reservation.',
                        'type' => 'prepare_pickup',
                        'is_read' => false,
                    ]);
                } catch (\Exception $e) { /* swallow notify errors */ }

                try {
                    ResortOwnerNotification::create([
                        'user_id' => $booking->resort_owner_id,
                        'booking_id' => $booking->id,
                        'message' => 'Today is the guest\'s reservation date. Boat ' . ($booking->assignedBoat->boat_name ?? 'N/A') . ' has been assigned.',
                        'type' => 'boat_now_assigned',
                        'is_read' => false,
                    ]);
                } catch (\Exception $e) { /* swallow notify errors */ }
            }
        }
        
        $this->info("Boat assignment on pickup completed. {$assignedCount} boats marked as assigned.");
        
        if ($assignedCount > 0) {
            Log::info("Boat assignment on pickup command completed. {$assignedCount} boats marked as assigned.");
        }
        
        return 0;
    }
}
