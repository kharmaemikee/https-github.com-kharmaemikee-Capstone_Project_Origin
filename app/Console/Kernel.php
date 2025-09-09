<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Update booking statuses every hour
        $schedule->command('bookings:update-statuses')->hourly();
        
        // Update boat statuses every 15 minutes
        $schedule->command('boats:update-statuses')->everyFifteenMinutes();
        
        // Assign boats on pickup every 15 minutes
        $schedule->command('boats:assign-on-pickup')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
