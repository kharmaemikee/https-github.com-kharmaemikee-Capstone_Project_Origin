<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'boat_name',
        'boat_number',
        'boat_prices',
        'boat_capacities',
        'boat_length',
        'image_path',
        'status',
        'rejection_reason',
        'captain_name',
        'captain_contact',
        // Archive fields
        'archived',
        'archived_at',
    ];

    /**
     * Casts for model attributes
     */
    protected $casts = [
        'archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    /**
     * Define constants for boat statuses.
     * These are used throughout the application to ensure consistency.
     */
    public const STATUS_PENDING = 'pending';    // Initial status after creation by Boat Owner (for admin approval)
    public const STATUS_APPROVED = 'approved';  // Approved by Admin (for admin approval)
    public const STATUS_REJECTED = 'rejected';  // Rejected by Admin (for admin approval)
    public const STATUS_OPEN = 'open';          // Available for booking (set by Admin or Boat Owner)
    public const STATUS_ASSIGNED = 'assigned';  // Currently assigned to a booking (set automatically during booking)
    public const STATUS_CLOSED = 'closed';      // Unavailable for booking (e.g., manually closed by owner)
    public const STATUS_REHAB = 'maintenance';  // Under maintenance/renovation (set by Boat Owner)

    /**
     * Get the user (Boat Owner) that owns the boat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookings for the boat.
     * The foreign key in the 'bookings' table is 'assigned_boat_id'.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'assigned_boat_id'); // CORRECTED: Specify the foreign key
    }

    /**
     * Check if the boat is available for a specific time slot.
     * This method checks for time conflicts with existing approved bookings.
     */
    public function isAvailableForTimeSlot($startTime, $endTime, $excludeBookingId = null): bool
    {
        $conflictingBookings = $this->bookings()
            ->where('status', 'approved')
            ->when($excludeBookingId, function ($query) use ($excludeBookingId) {
                return $query->where('id', '!=', $excludeBookingId);
            })
            ->where(function ($query) use ($startTime, $endTime) {
                // Conflict for Day Tour vs Day Tour or Overnight
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('tour_type', 'day_tour')
                        ->whereDate('check_in_date', $startTime->toDateString())
                        ->whereRaw("TIME(day_tour_departure_time) < ?", [$endTime->format('H:i:s')])
                        ->whereRaw("TIME(day_tour_time_of_pickup) > ?", [$startTime->format('H:i:s')]);
                })
                // Conflict for Overnight vs Overnight or Day Tour
                ->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('tour_type', 'overnight')
                        ->where('overnight_date_time_of_pickup', '<', $endTime)
                        ->where('check_out_date', '>', $startTime);
                });
            });

        return !$conflictingBookings->exists();
    }

    /**
     * Check if the boat has sufficient capacity for the number of guests.
     */
    public function hasSufficientCapacity(int $numberOfGuests): bool
    {
        return $this->boat_capacities >= $numberOfGuests;
    }

    /**
     * Get the next boat in sequence for assignment.
     * This method helps maintain the sequential numbering system.
     */
    public static function getNextBoatForAssignment(int $lastAssignedBoatId = 0): ?self
    {
        $boats = static::where('status', self::STATUS_OPEN)
            ->whereHas('user', function ($query) {
                $query->where('role', 'boat_owner');
            })
            ->with('user') // Load the user relationship to get captain crew details
            ->orderBy('id')
            ->get();

        if ($boats->isEmpty()) {
            return null;
        }

        if ($lastAssignedBoatId === 0) {
            return $boats->first();
        }

        // Find the index of the last assigned boat
        $lastAssignedIndex = $boats->search(function ($boat) use ($lastAssignedBoatId) {
            return $boat->id === $lastAssignedBoatId;
        });

        if ($lastAssignedIndex === false) {
            return $boats->first();
        }

        // Return the next boat in sequence, or the first if we're at the end
        $nextIndex = ($lastAssignedIndex + 1) % $boats->count();
        return $boats->get($nextIndex);
    }

    /**
     * Get all boats in the correct sequence for assignment.
     * This ensures the numbering system is maintained.
     */
    public static function getBoatsInAssignmentSequence(int $lastAssignedBoatId = 0): \Illuminate\Database\Eloquent\Collection
    {
        $boats = static::where('status', self::STATUS_OPEN)
            ->whereHas('user', function ($query) {
                $query->where('role', 'boat_owner');
            })
            ->with('user') // Load the user relationship to get captain crew details
            ->orderBy('id')
            ->get();

        if ($boats->isEmpty()) {
            return $boats; // Return empty Eloquent Collection
        }

        if ($lastAssignedBoatId === 0) {
            return $boats;
        }

        // Find the index of the last assigned boat
        $lastAssignedIndex = $boats->search(function ($boat) use ($lastAssignedBoatId) {
            return $boat->id === $lastAssignedBoatId;
        });

        if ($lastAssignedIndex === false) {
            return $boats;
        }

        // Reorder the collection to start from the next boat after the last assigned
        $startIndex = ($lastAssignedIndex + 1) % $boats->count();
        
        // Create a new Eloquent Collection with reordered boats
        $reorderedBoats = new \Illuminate\Database\Eloquent\Collection();
        
        // Add boats from startIndex to end
        for ($i = $startIndex; $i < $boats->count(); $i++) {
            $reorderedBoats->push($boats->get($i));
        }
        
        // Add boats from beginning to startIndex-1
        for ($i = 0; $i < $startIndex; $i++) {
            $reorderedBoats->push($boats->get($i));
        }

        return $reorderedBoats;
    }

    /**
     * Mark the boat as assigned to a booking.
     * This changes the status from 'open' to 'assigned'.
     */
    public function markAsAssigned(): void
    {
        $this->update(['status' => self::STATUS_ASSIGNED]);
    }

    /**
     * Mark the boat as available again after assignment ends.
     * This changes the status from 'assigned' to 'open'.
     */
    public function markAsAvailable(): void
    {
        $this->update(['status' => self::STATUS_OPEN]);
    }

    /**
     * Check if the boat is currently assigned to a booking.
     */
    public function isAssigned(): bool
    {
        return $this->status === self::STATUS_ASSIGNED;
    }

    /**
     * Get the current active booking for this boat (if any).
     * A booking is considered "current" if:
     * - For day tours: pickup time has arrived but departure time hasn't passed
     * - For overnight: check-in date has arrived but check-out date hasn't passed
     */
    public function getCurrentBooking(): ?Booking
    {
        $now = now();
        
        return $this->bookings()
            ->where('status', 'approved')
            ->where(function ($query) use ($now) {
                // Day tour: pickup time has arrived but departure time hasn't passed
                $query->where(function ($q) use ($now) {
                    $q->where('tour_type', 'day_tour')
                        ->whereDate('check_in_date', $now->toDateString())
                        ->where(function ($timeQuery) use ($now) {
                            $timeQuery->where(function ($pickupQuery) use ($now) {
                                // Pickup time has arrived
                                $pickupQuery->whereNotNull('day_tour_time_of_pickup')
                                    ->whereRaw('CONCAT(check_in_date, " ", day_tour_time_of_pickup) <= ?', [$now]);
                            })->where(function ($departureQuery) use ($now) {
                                // Departure time hasn't passed yet
                                $departureQuery->whereNull('day_tour_departure_time')
                                    ->orWhereRaw('CONCAT(check_in_date, " ", day_tour_departure_time) > ?', [$now]);
                            });
                        });
                })
                // Overnight: check-in date has arrived but check-out date hasn't passed
                ->orWhere(function ($q) use ($now) {
                    $q->where('tour_type', 'overnight')
                        ->where('check_in_date', '<=', $now->toDateString())
                        ->where(function ($checkoutQuery) use ($now) {
                            $checkoutQuery->where('check_out_date', '>', $now->toDateString())
                                ->orWhere(function ($nightsQuery) use ($now) {
                                    $nightsQuery->whereNotNull('number_of_nights')
                                        ->whereRaw('DATE_ADD(check_in_date, INTERVAL number_of_nights DAY) > ?', [$now->toDateString()]);
                                });
                        });
                });
            })
            ->first();
    }

    /**
     * Scope: non-archived boats only
     */
    public function scopeNotArchived($query)
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn('boats', 'archived')) {
                return $query->where(function ($q) {
                    $q->where('archived', false)->orWhereNull('archived');
                });
            }
        } catch (\Throwable $e) {
            // ignore if schema not ready
        }
        return $query; // fallback: no filter if column missing
    }

    /**
     * Scope: archived boats only
     */
    public function scopeArchived($query)
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn('boats', 'archived')) {
                return $query->where('archived', true);
            }
        } catch (\Throwable $e) {
            // ignore
        }
        // If no column, return empty result by forcing impossible condition
        return $query->whereRaw('1 = 0');
    }

    /** Archive the boat */
    public function archive(): void
    {
        $this->update([
            'archived' => true,
            'archived_at' => now(),
        ]);
    }

    /** Unarchive the boat */
    public function unarchive(): void
    {
        $this->update([
            'archived' => false,
            'archived_at' => null,
        ]);
    }
}
