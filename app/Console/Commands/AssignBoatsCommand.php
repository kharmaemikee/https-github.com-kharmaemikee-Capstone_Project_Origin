<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Boat;
use App\Models\Setting;
use App\Models\TouristNotification;
use App\Models\ResortOwnerNotification;
use App\Models\BoatOwnerNotification;
use App\Services\SemaphoreSmsService;
use Carbon\Carbon;

class AssignBoatsCommand extends Command
{
    protected $signature = 'boats:assign';
    protected $description = 'Assign boats to approved bookings whose departure times have arrived, using sequential numbering order.';

    public function handle(): int
    {
        $now = Carbon::now();

        // Fetch approved bookings without assigned boats, whose departure time is now/past
        $candidates = Booking::where('status', 'approved')
            ->whereNull('assigned_boat_id')
            ->get()
            ->filter(function (Booking $b) use ($now) {
                try {
                    if ($b->tour_type === 'day_tour' && $b->check_in_date && $b->day_tour_departure_time) {
                        $depTime = $b->day_tour_departure_time;
                        if (is_string($depTime) && strpos($depTime, ' ') !== false) {
                            $parts = explode(' ', $depTime);
                            $depTime = end($parts);
                        }
                        $start = Carbon::parse(optional($b->check_in_date)->format('Y-m-d') . ' ' . $depTime);
                        return $now->greaterThanOrEqualTo($start);
                    }
                    if ($b->tour_type === 'overnight' && $b->overnight_departure_time) {
                        $start = Carbon::parse($b->overnight_departure_time);
                        return $now->greaterThanOrEqualTo($start);
                    }
                } catch (\Throwable $e) {
                    return false;
                }
                return false;
            });

        if ($candidates->isEmpty()) {
            return Command::SUCCESS;
        }

        $lastAssignedBoatId = (int) Setting::get('last_assigned_boat_id', 0);
        $boatsInSequence = Boat::getBoatsInAssignmentSequence($lastAssignedBoatId);

        foreach ($candidates as $booking) {
            try {
                $foundBoat = null;
                foreach ($boatsInSequence as $boat) {
                    if (!$boat->hasSufficientCapacity($booking->number_of_guests)) {
                        continue;
                    }
                    // Determine time slot (end is pickup or end-of-day for overnight)
                    $start = null; $end = null;
                    if ($booking->tour_type === 'day_tour' && $booking->check_in_date && $booking->day_tour_departure_time && $booking->day_tour_time_of_pickup) {
                        $dep = $booking->day_tour_departure_time;
                        $pick = $booking->day_tour_time_of_pickup;
                        if (is_string($dep) && strpos($dep, ' ') !== false) { $dep = explode(' ', $dep)[1]; }
                        if (is_string($pick) && strpos($pick, ' ') !== false) { $pick = explode(' ', $pick)[1]; }
                        $start = Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $dep);
                        $end = Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $pick);
                        if ($end->lessThan($start)) { $end->addDay(); }
                    } elseif ($booking->tour_type === 'overnight' && $booking->overnight_departure_time && $booking->check_out_date) {
                        $start = Carbon::parse($booking->overnight_departure_time);
                        $end = Carbon::parse($booking->check_out_date->format('Y-m-d') . ' 23:59:59');
                    }
                    if (!$start || !$end) { continue; }

                    if ($boat->isAvailableForTimeSlot($start, $end)) {
                        $foundBoat = $boat;
                        break;
                    }
                }

                if (!$foundBoat) {
                    // Skip if no boat available; will try next run
                    continue;
                }

                if (!$foundBoat->relationLoaded('user')) { $foundBoat->load('user'); }

                // Assign now
                $booking->assigned_boat_id = $foundBoat->id;
                $booking->assigned_boat = $foundBoat->boat_name . ' (#' . $foundBoat->boat_number . ')';
                $booking->boat_captain_crew = $foundBoat->captain_name ?? 'N/A';
                $booking->boat_contact_number = $foundBoat->captain_contact ?? 'N/A';
                $booking->save();

                // Update sequence
                Setting::set('last_assigned_boat_id', $foundBoat->id);

                // Notify tourist & resort owner
                TouristNotification::create([
                    'user_id' => $booking->user_id,
                    'booking_id' => $booking->id,
                    'message' => 'Boat assigned: ' . $booking->assigned_boat . '. Have a great trip!',
                    'type' => 'boat_assigned',
                    'is_read' => false,
                ]);
                // Also send SMS to tourist with boat, captain, contact and times
                try {
                    $tourist = $booking->user;
                    if ($tourist && $tourist->phone) {
                        $depInfo = '';
                        $pickInfo = '';
                        try {
                            if ($booking->tour_type === 'day_tour') {
                                if ($booking->day_tour_departure_time && $booking->check_in_date) {
                                    $dep = Carbon::parse(optional($booking->check_in_date)->format('Y-m-d') . ' ' . (is_string($booking->day_tour_departure_time) && strpos($booking->day_tour_departure_time, ' ') !== false
                                        ? explode(' ', $booking->day_tour_departure_time)[1]
                                        : $booking->day_tour_departure_time));
                                    $depInfo = $dep->format('M j, Y g:i A');
                                }
                                if ($booking->day_tour_time_of_pickup && $booking->check_in_date) {
                                    $pick = Carbon::parse(optional($booking->check_in_date)->format('Y-m-d') . ' ' . (is_string($booking->day_tour_time_of_pickup) && strpos($booking->day_tour_time_of_pickup, ' ') !== false
                                        ? explode(' ', $booking->day_tour_time_of_pickup)[1]
                                        : $booking->day_tour_time_of_pickup));
                                    $pickInfo = $pick->format('M j, Y g:i A');
                                }
                            } else { // overnight
                                if ($booking->overnight_departure_time) {
                                    $depInfo = Carbon::parse($booking->overnight_departure_time)->format('M j, Y g:i A');
                                }
                                if ($booking->overnight_date_time_of_pickup) {
                                    $pickInfo = Carbon::parse($booking->overnight_date_time_of_pickup)->format('M j, Y g:i A');
                                }
                            }
                        } catch (\Throwable $e) { /* ignore */ }

                        $message = 'Boat Details Assigned!\n' .
                            'Hello ' . (trim((string)($booking->user->first_name ?? '')) ?: ($booking->user->name ?? 'Guest')) . ', your boat for ' . ($booking->name_of_resort ?? 'the resort') . ' has been scheduled.\n\n' .
                            'Boat Name: ' . ($booking->assigned_boat ?? 'N/A') . '  ' .
                            'Boat Captain: ' . ($booking->boat_captain_crew ?? 'N/A') . "\n" .
                            'Departure Time: ' . (($depInfo ?: 'TBA')) . "\n\n" .
                            'Kindly be at your pickup location on time.\n' .
                            'Need help? Contact us at ' . (($booking->boat_contact_number ?? 'N/A')) . '.';
                        $smsSvc = new SemaphoreSmsService();
                        $smsSvc->send($tourist->phone, $message);
                    }
                } catch (\Throwable $e) { /* ignore SMS errors */ }
                ResortOwnerNotification::create([
                    'user_id' => $booking->resort_owner_id,
                    'booking_id' => $booking->id,
                    'message' => 'Boat assigned to booking ID ' . $booking->id . ': ' . $booking->assigned_boat . '.',
                    'type' => 'boat_assigned',
                    'is_read' => false,
                ]);

                // Notify boat owner
                if ($foundBoat->user_id) {
                    BoatOwnerNotification::create([
                        'user_id' => $foundBoat->user_id,
                        'booking_id' => $booking->id,
                        'message' => 'Your boat ' . $foundBoat->boat_name . ' was assigned to a booking (ID ' . $booking->id . '). Departure now.',
                        'type' => 'boat_assigned_now',
                        'is_read' => false,
                    ]);

                    // Send SMS notification to boat owner
                    try {
                        $boatOwner = $foundBoat->user;
                        $smsService = new SemaphoreSmsService();

                        // Format departure/pickup times
                        $departureTime = '';
                        $pickupTime = '';
                        
                        if ($booking->tour_type === 'day_tour' && $booking->day_tour_departure_time) {
                            $depTime = $booking->day_tour_departure_time;
                            if (is_string($depTime) && strpos($depTime, ' ') !== false) {
                                $depTime = explode(' ', $depTime)[1];
                            }
                            $departureTime = \Carbon\Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $depTime)->format('M j, Y g:i A');
                        } elseif ($booking->tour_type === 'overnight' && $booking->overnight_departure_time) {
                            $departureTime = \Carbon\Carbon::parse($booking->overnight_departure_time)->format('M j, Y g:i A');
                        }
                        
                        if ($booking->tour_type === 'day_tour' && $booking->day_tour_time_of_pickup) {
                            $pickTime = $booking->day_tour_time_of_pickup;
                            if (is_string($pickTime) && strpos($pickTime, ' ') !== false) {
                                $pickTime = explode(' ', $pickTime)[1];
                            }
                            $pickupTime = \Carbon\Carbon::parse($booking->check_in_date->format('Y-m-d') . ' ' . $pickTime)->format('M j, Y g:i A');
                        } elseif ($booking->tour_type === 'overnight' && $booking->overnight_date_time_of_pickup) {
                            $pickupTime = \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('M j, Y g:i A');
                        }

                        $message = 'Matnog Tourism — Assigned today. Tourist: ' . (trim((string)($booking->guest_name ?? '')) ?: ($booking->user->name ?? 'N/A'))
                            . '. Resort: ' . ($booking->name_of_resort ?? 'N/A')
                            . '. Room: ' . (($booking->room->room_name ?? 'N/A'))
                            . '. Boat: ' . $foundBoat->boat_name
                            . '. Departure: ' . ($departureTime ?: 'TBA')
                            . ($pickupTime ? ('. Pickup: ' . $pickupTime) : '') . '.';

                        // Prefer captain contact; fallback to boat owner phone
                        $recipient = $foundBoat->captain_contact ?: ($boatOwner->phone_number ?? null);
                        if ($recipient) {
                            $smsService->send($recipient, $message);
                            $this->info("SMS sent to captain/owner: " . $recipient . " for booking " . $booking->id);
                        }
                    } catch (\Throwable $e) {
                        $this->error("Failed to send SMS to boat owner for booking " . $booking->id . ": " . $e->getMessage());
                    }
                }

            } catch (\Throwable $e) {
                // continue with others
                continue;
            }
        }

        return Command::SUCCESS;
    }
}
