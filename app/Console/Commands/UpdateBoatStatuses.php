<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Boat;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateBoatStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boats:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update boat statuses from assigned to open when bookings are completed or checked out';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting boat status update process...');
        
        $updatedCount = 0;
        $now = Carbon::now();
        $boats = Boat::where('status', 'assigned')->get();
        
        foreach ($boats as $boat) {
            $this->info("Checking boat: {$boat->boat_name} (ID: {$boat->id})");
            
            // Get the current active booking for this boat
            $currentBooking = $boat->getCurrentBooking();
            
            if (!$currentBooking) {
                // No active booking found, mark boat as available
                $boat->markAsAvailable();
                $updatedCount++;
                
                $this->info("  - Boat {$boat->boat_name} marked as available (no active booking)");
                
                // Log the status change
                Log::info("Boat {$boat->boat_name} (ID: {$boat->id}) status changed from 'assigned' to 'open' - no active booking found");
            } else {
                $bookingCompleted = false;
                
                if ($currentBooking->tour_type === 'day_tour') {
                    // For day tours, check if departure time has passed
                    if ($currentBooking->day_tour_departure_time) {
                        try {
                            $departureTime = Carbon::parse($currentBooking->check_in_date->format('Y-m-d') . ' ' . $currentBooking->day_tour_departure_time);
                        } catch (\Exception $e) {
                            continue; // Skip this booking if time parsing fails
                        }
                        $bookingCompleted = $now->gte($departureTime);
                    }
                } else {
                    // For overnight tours, check if check-out date has passed
                    if ($currentBooking->check_out_date) {
                        $bookingCompleted = $now->gte($currentBooking->check_out_date->endOfDay());
                    } elseif ($currentBooking->number_of_nights) {
                        $checkOutDate = $currentBooking->check_in_date->addDays($currentBooking->number_of_nights);
                        $bookingCompleted = $now->gte($checkOutDate->endOfDay());
                    }
                }
                
                if ($bookingCompleted) {
                    // Mark the boat as available
                    $boat->markAsAvailable();
                    $updatedCount++;
                    
                    $this->info("  - Boat {$boat->boat_name} marked as available (booking completed)");
                    
                    // Log the status change
                    Log::info("Boat {$boat->boat_name} (ID: {$boat->id}) status changed from 'assigned' to 'open' - booking {$currentBooking->id} completed");
                } else {
                    $this->info("  - Boat {$boat->boat_name} still has active booking until: " . 
                        ($currentBooking->check_out_date ? $currentBooking->check_out_date->format('Y-m-d H:i') : $currentBooking->check_in_date->format('Y-m-d')));
                }
            }
        }
        
        $this->info("Boat status update completed. {$updatedCount} boats updated.");
        
        if ($updatedCount > 0) {
            Log::info("Boat status update command completed. {$updatedCount} boats marked as available.");
        }
        
        return 0;
    }
}
