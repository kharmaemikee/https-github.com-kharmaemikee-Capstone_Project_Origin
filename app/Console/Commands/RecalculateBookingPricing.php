<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Services\PricingCalculationService;

class RecalculateBookingPricing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:recalculate-pricing {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate pricing for all existing bookings that don\'t have pricing fields populated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pricingService = new PricingCalculationService();
        $dryRun = $this->option('dry-run');
        
        // Find bookings that don't have pricing fields populated
        $bookings = Booking::whereNull('final_total_price')
            ->orWhereNull('base_room_price')
            ->with('room')
            ->get();
            
        if ($bookings->isEmpty()) {
            $this->info('No bookings found that need pricing recalculation.');
            return;
        }
        
        $this->info("Found {$bookings->count()} bookings that need pricing recalculation.");
        
        if ($dryRun) {
            $this->info('DRY RUN - No changes will be made.');
        }
        
        $bar = $this->output->createProgressBar($bookings->count());
        $bar->start();
        
        $updated = 0;
        $errors = 0;
        
        foreach ($bookings as $booking) {
            try {
                if (!$dryRun) {
                    $pricingService->updateBookingPricing($booking);
                }
                $updated++;
            } catch (\Exception $e) {
                $errors++;
                $this->error("Error updating booking {$booking->id}: " . $e->getMessage());
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        if ($dryRun) {
            $this->info("DRY RUN COMPLETE: Would have updated {$updated} bookings with {$errors} errors.");
        } else {
            $this->info("COMPLETE: Updated {$updated} bookings with {$errors} errors.");
        }
    }
}
