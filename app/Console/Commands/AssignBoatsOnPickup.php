<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Boat;
use App\Models\Booking;
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
            
            if ($booking->tour_type === 'day_tour') {
                // For day tours, check if pickup time has arrived
                if ($booking->day_tour_time_of_pickup) {
                    try {
                        $pickupTime = Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $booking->day_tour_time_of_pickup);
                    } catch (\Exception $e) {
                        continue; // Skip this booking if time parsing fails
                    }
                    $shouldAssign = $now->gte($pickupTime);
                }
            } else {
                // For overnight tours, check if check-in date has arrived
                $shouldAssign = $now->gte($booking->check_in_date->startOfDay());
                $pickupTime = $booking->check_in_date->startOfDay();
            }
            
            if ($shouldAssign && $booking->assignedBoat && $booking->assignedBoat->status === 'open') {
                // Mark the boat as assigned
                $booking->assignedBoat->markAsAssigned();
                $assignedCount++;
                
                $this->info("  - Boat {$booking->assignedBoat->boat_name} marked as assigned for booking {$booking->id} (Pickup: {$pickupTime})");
                
                // Log the status change
                Log::info("Boat {$booking->assignedBoat->boat_name} (ID: {$booking->assignedBoat->id}) status changed from 'open' to 'assigned' for booking {$booking->id} - pickup time arrived");
            }
        }
        
        $this->info("Boat assignment on pickup completed. {$assignedCount} boats marked as assigned.");
        
        if ($assignedCount > 0) {
            Log::info("Boat assignment on pickup command completed. {$assignedCount} boats marked as assigned.");
        }
        
        return 0;
    }
}
