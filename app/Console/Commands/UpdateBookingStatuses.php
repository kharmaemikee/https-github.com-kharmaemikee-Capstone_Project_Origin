<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\TouristNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateBookingStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update booking statuses to completed when check-out/departure time has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automatic booking status updates...');
        
        // Get all bookings that should be marked as completed
        $bookingsToComplete = Booking::shouldBeCompleted()->get();
        
        $completedCount = 0;
        
        foreach ($bookingsToComplete as $booking) {
            try {
                // Check if the booking is actually completed by time
                if ($booking->isCompleted()) {
                    $booking->status = 'completed';
                    $booking->save();
                    
                    $completedCount++;
                    
                    $this->info("Marked booking #{$booking->id} as completed for guest: {$booking->guest_name}");
                    
                    // Create completion notification for the tourist
                    TouristNotification::create([
                        'user_id' => $booking->user_id,
                        'booking_id' => $booking->id,
                        'message' => 'Your booking for ' . ($booking->room->room_name ?? 'a room') . ' at ' . ($booking->name_of_resort ?? 'the resort') . ' has been marked as COMPLETED. We hope you enjoyed your visit!',
                        'type' => 'booking_completed',
                        'is_read' => false,
                    ]);
                    
                    // Log the status change
                    Log::info("Booking #{$booking->id} automatically marked as completed", [
                        'guest_name' => $booking->guest_name,
                        'tour_type' => $booking->tour_type,
                        'check_in_date' => $booking->check_in_date,
                        'check_out_date' => $booking->check_out_date,
                        'departure_time' => $booking->day_tour_departure_time,
                    ]);
                }
            } catch (\Exception $e) {
                $this->error("Error updating booking #{$booking->id}: " . $e->getMessage());
                Log::error("Error updating booking status", [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        $this->info("Completed! Updated {$completedCount} bookings to completed status.");
        
        return Command::SUCCESS;
    }
}
