<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// This is a dummy Booking model for demonstration.
// Replace this with your actual Booking model if it exists and has different fields/relationships.
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Tourist ID
        'resort_owner_id', // Resort Owner User ID
        'boat_owner_id', // Boat Owner User ID (if directly stored here)
        'tour_type', // 'day_tour' or 'overnight'
        'check_in_date',
        'check_out_date', // Nullable for daytour
        'number_of_guests',
        'status', // e.g., 'pending', 'approved', 'completed', 'cancelled'
        'room_id', // If bookings can also be linked to rooms (e.g., for resort bookings)
        'guest_name',
        'guest_age',
        'guest_gender',
        'guest_address',
        'guest_nationality',
        'phone_number',
        'number_of_nights',
        'special_requests',
        'day_tour_departure_time',
        'day_tour_time_of_pickup',
        'overnight_date_time_of_pickup',
        'num_senior_citizens',
        'num_pwds',
        'assigned_boat_id',
        'assigned_boat',
        'boat_captain_crew',
        'boat_contact_number',
        'name_of_resort',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'day_tour_departure_time' => 'datetime',
        'overnight_date_time_of_pickup' => 'datetime',
    ];

    /**
     * Check if the booking is completed based on time.
     * For day tours: completed after departure time on check-in date
     * For overnight: completed after check-out date
     */
    public function isCompleted(): bool
    {
        $now = now();
        
        if ($this->tour_type === 'day_tour') {
            // For day tours, check if departure time has passed on check-in date
            if ($this->day_tour_departure_time) {
                try {
                    // If departure_time is already a full datetime, use it directly
                    if ($this->day_tour_departure_time instanceof \Carbon\Carbon) {
                        $departureDateTime = $this->day_tour_departure_time;
                    } else {
                        // If it's just a time string, combine with check-in date
                        $timeString = $this->day_tour_departure_time;
                        if (is_string($timeString)) {
                            // Extract just the time part if it's a full datetime string
                            if (strpos($timeString, ' ') !== false) {
                                $timeParts = explode(' ', $timeString);
                                $timeString = end($timeParts); // Get the last part which should be the time
                            }
                            $departureDateTime = \Carbon\Carbon::parse($this->check_in_date->format('Y-m-d') . ' ' . $timeString);
                        } else {
                            $departureDateTime = \Carbon\Carbon::parse($this->day_tour_departure_time);
                        }
                    }
                    // Only mark as completed if departure time has passed AND it's the check-in date
                    if ($now->toDateString() === $this->check_in_date->toDateString()) {
                        return $now->isAfter($departureDateTime);
                    }
                    return false;
                } catch (\Exception $e) {
                    // If parsing fails, don't mark as completed
                    return false;
                }
            }
            // If no departure time set, don't mark as completed
            return false;
        } else {
            // For overnight, check if check-out date has passed
            if ($this->check_out_date) {
                return $now->isAfter($this->check_out_date);
            }
            // If no check-out date, check if check-in date + number of nights has passed
            if ($this->number_of_nights) {
                $calculatedCheckOut = $this->check_in_date->addDays($this->number_of_nights);
                return $now->isAfter($calculatedCheckOut);
            }
            return false;
        }
    }

    /**
     * Get the human-readable status for display.
     * Only shows 'completed' if the stored status is actually 'completed'.
     * The automatic completion is handled by the command, not here.
     */
    public function getDisplayStatusAttribute(): string
    {
        // Only return 'completed' if the stored status is actually 'completed'
        // Don't automatically override the status here
        return $this->status;
    }

    /**
     * Scope to get only active (non-completed) bookings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled')
                    ->where('status', '!=', 'completed');
    }

    /**
     * Scope to get only completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get bookings that should be marked as completed.
     */
    public function scopeShouldBeCompleted($query)
    {
        return $query->where('status', '!=', 'cancelled')
                    ->where('status', '!=', 'completed')
                    ->where(function ($q) {
                        $q->where(function ($subQ) {
                            // Day tour: departure time has passed
                            $subQ->where('tour_type', 'day_tour')
                                 ->whereNotNull('day_tour_departure_time')
                                 ->where(function ($innerQ) {
                                     // Try to parse the departure time properly
                                     $innerQ->whereRaw('DATE(day_tour_departure_time) = check_in_date AND TIME(day_tour_departure_time) < CURTIME()')
                                            ->orWhereRaw('CONCAT(check_in_date, " ", TIME(day_tour_departure_time)) < NOW()');
                                 });
                        })->orWhere(function ($subQ) {
                            // Overnight: check-out date has passed
                            $subQ->where('tour_type', 'overnight')
                                 ->whereNotNull('check_out_date')
                                 ->where('check_out_date', '<', now()->toDateString());
                        })->orWhere(function ($subQ) {
                            // Overnight: calculated check-out has passed
                            $subQ->where('tour_type', 'overnight')
                                 ->whereNotNull('number_of_nights')
                                 ->whereRaw('DATE_ADD(check_in_date, INTERVAL number_of_nights DAY) < CURDATE()');
                        });
                    });
    }

    /**
     * Get the tourist (User) who made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the resort owner (User) for this booking.
     */
    public function resortOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resort_owner_id');
    }

    /**
     * Get the assigned boat for this booking.
     */
    public function assignedBoat(): BelongsTo
    {
        return $this->belongsTo(Boat::class, 'assigned_boat_id');
    }

    /**
     * Get the room associated with the booking (if applicable).
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
