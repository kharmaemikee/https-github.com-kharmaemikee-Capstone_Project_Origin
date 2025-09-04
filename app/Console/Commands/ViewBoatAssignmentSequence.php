<?php

namespace App\Console\Commands;

use App\Models\Boat;
use App\Models\Setting;
use Illuminate\Console\Command;

class ViewBoatAssignmentSequence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boats:sequence {--reset : Reset the last assigned boat ID to 0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View the current boat assignment sequence and manage the numbering system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastAssignedBoatId = (int) Setting::get('last_assigned_boat_id', 0);
        
        if ($this->option('reset')) {
            Setting::set('last_assigned_boat_id', 0);
            $lastAssignedBoatId = 0;
            $this->info('Last assigned boat ID has been reset to 0.');
        }

        $this->info("Current Last Assigned Boat ID: {$lastAssignedBoatId}");
        $this->newLine();

        // Get all open and approved boats
        $allBoats = Boat::where('status', Boat::STATUS_OPEN)
            ->whereHas('user', function ($query) {
                $query->where('role', 'boat_owner');
            })
            ->orderBy('id')
            ->get();

        if ($allBoats->isEmpty()) {
            $this->warn('No open and approved boats found.');
            return;
        }

        $this->info("Total Available Boats: {$allBoats->count()}");
        $this->newLine();

        // Show the assignment sequence
        $boatsInSequence = Boat::getBoatsInAssignmentSequence($lastAssignedBoatId);
        
        $this->info('Boat Assignment Sequence:');
        $this->info('(Boats will be assigned in this order)');
        $this->newLine();

        $headers = ['#', 'Boat ID', 'Boat Name', 'Boat Number', 'Capacity', 'Owner', 'Status'];
        $rows = [];

        foreach ($boatsInSequence as $index => $boat) {
            $rows[] = [
                $index + 1,
                $boat->id,
                $boat->boat_name,
                $boat->boat_number,
                $boat->boat_capacities,
                $boat->user->name ?? 'N/A',
                $boat->status
            ];
        }

        $this->table($headers, $rows);

        // Show which boat will be assigned next
        $nextBoat = Boat::getNextBoatForAssignment($lastAssignedBoatId);
        if ($nextBoat) {
            $this->newLine();
            $this->info("Next boat to be assigned: {$nextBoat->boat_name} (ID: {$nextBoat->id}, Number: {$nextBoat->boat_number})");
        }

        // Show current boat assignments
        $this->newLine();
        $this->info('Current Boat Assignments:');
        
        $assignedBoats = $allBoats->filter(function ($boat) {
            return $boat->bookings()
                ->where('status', 'approved')
                ->exists();
        });

        if ($assignedBoats->isEmpty()) {
            $this->warn('No boats are currently assigned to bookings.');
        } else {
            $assignmentHeaders = ['Boat ID', 'Boat Name', 'Boat Number', 'Current Bookings'];
            $assignmentRows = [];

            foreach ($assignedBoats as $boat) {
                $currentBookings = $boat->bookings()
                    ->where('status', 'approved')
                    ->get()
                    ->map(function ($booking) {
                        $date = $booking->check_in_date->format('M d, Y');
                        $guests = $booking->number_of_guests;
                        $type = $booking->tour_type;
                        return "{$date} ({$guests} guests, {$type})";
                    })
                    ->join(', ');

                $assignmentRows[] = [
                    $boat->id,
                    $boat->boat_name,
                    $boat->boat_number,
                    $currentBookings ?: 'No active bookings'
                ];
            }

            $this->table($assignmentHeaders, $assignmentRows);
        }

        $this->newLine();
        $this->info('Note: The numbering system ensures all boats are assigned before any boat is reassigned.');
        $this->info('This maintains a fair and organized boat assignment process.');
    }
}
