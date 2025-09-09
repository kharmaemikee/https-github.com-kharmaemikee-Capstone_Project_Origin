<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this for bookings

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_id',
        'accommodation_type',
        'room_name',
        'description',
        'price_per_night',
        'max_guests',
        'image_path',
        'is_available',     // Keep for now if existing logic relies on it, but 'status' will be primary
        'admin_status',     // Added for approval workflow
        'rejection_reason', // Added for storing admin rejection reasons
        'status',           // NEW: To manage Open, Closed, Maintenance states
        'rehab_reason',     // NEW: Reason for maintenance (keeping column name for now)
        'archived',         // NEW: Archive status
        'archived_at',      // NEW: When the room was archived
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'archived' => 'boolean',
        'archived_at' => 'datetime',
        'is_available' => 'boolean',
    ];

    /**
     * Scope for rooms only.
     */
    public function scopeOnlyRooms($query)
    {
        return $query->where('accommodation_type', 'room');
    }

    /**
     * Scope for cottages only.
     */
    public function scopeOnlyCottages($query)
    {
        return $query->where('accommodation_type', 'cottage');
    }

    /**
     * Get the resort that owns the room.
     */
    public function resort(): BelongsTo
    {
        return $this->belongsTo(Resort::class);
    }

    /**
     * Get the bookings for the room.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if the room is available for a specific date.
     * Returns true if no active bookings exist for that date.
     */
    public function isAvailableForDate($date)
    {
        // Convert to Carbon instance if it's a string
        if (is_string($date)) {
            try {
                $date = \Carbon\Carbon::parse($date);
            } catch (\Exception $e) {
                // If parsing fails, return false for availability
                return false;
            }
        }

        // Check if there are any active (non-completed) bookings for this date
        $hasBookings = $this->bookings()
            ->active() // Use the new scope that excludes completed bookings
            ->where('check_in_date', '=', $date->format('Y-m-d'))
            ->exists();

        return !$hasBookings;
    }

    /**
     * Get the conflicting booking for a specific date (if any).
     * Returns the booking object or null.
     */
    public function getConflictingBooking($date)
    {
        // Convert to Carbon instance if it's a string
        if (is_string($date)) {
            try {
                $date = \Carbon\Carbon::parse($date);
            } catch (\Exception $e) {
                // If parsing fails, return false for availability
                return false;
            }
        }

        return $this->bookings()
            ->active() // Use the new scope that excludes completed bookings
            ->where('check_in_date', '=', $date->format('Y-m-d'))
            ->first();
    }

    /**
     * Scope to get only non-archived rooms.
     */
    public function scopeNotArchived($query)
    {
        return $query->where('archived', false);
    }

    /**
     * Scope to get only archived rooms.
     * This scope removes the global scope to show archived rooms.
     */
    public function scopeArchived($query)
    {
        return $query->withoutGlobalScope('notArchived')->where('archived', true);
    }

    /**
     * Scope to get all rooms including archived ones.
     * This scope removes the global scope to show all rooms.
     */
    public function scopeWithArchived($query)
    {
        return $query->withoutGlobalScope('notArchived');
    }

    /**
     * Archive the room.
     */
    public function archive()
    {
        $this->update([
            'archived' => true,
            'archived_at' => now(),
        ]);
    }

    /**
     * Unarchive the room.
     */
    public function unarchive()
    {
        $this->update([
            'archived' => false,
            'archived_at' => null,
        ]);
    }

    /**
     * Check if the room is available for the specified dates.
     * This method checks for date conflicts with existing bookings.
     */
    public function isAvailableForDates($checkInDate, $checkOutDate = null)
    {
        // If no check-out date (day tour), just check the check-in date
        if (!$checkOutDate) {
            $checkOutDate = $checkInDate;
        }

        // Convert to Carbon instances if they're strings
        if (is_string($checkInDate)) {
            try {
                $checkInDate = \Carbon\Carbon::parse($checkInDate);
            } catch (\Exception $e) {
                return false; // Return false for availability check
            }
        }
        if (is_string($checkOutDate)) {
            try {
                $checkOutDate = \Carbon\Carbon::parse($checkOutDate);
            } catch (\Exception $e) {
                return false; // Return false for availability check
            }
        }

        // Check for conflicting bookings
        $conflictingBookings = $this->bookings()
            ->where('status', '!=', 'cancelled') // Exclude cancelled bookings
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                    // Check if the new booking overlaps with existing bookings
                    // Case 1: New check-in is between existing check-in and check-out
                    $q->where('check_in_date', '<=', $checkInDate)
                      ->where('check_out_date', '>=', $checkInDate);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 2: New check-out is between existing check-in and check-out
                    $q->where('check_in_date', '<=', $checkOutDate)
                      ->where('check_out_date', '>=', $checkOutDate);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 3: New booking completely encompasses existing booking
                    $q->where('check_in_date', '>=', $checkInDate)
                      ->where('check_out_date', '<=', $checkOutDate);
                });
            })
            ->exists();

        return !$conflictingBookings;
    }

    /**
     * Get conflicting bookings for the specified dates.
     * This method returns the actual conflicting bookings for debugging or display purposes.
     */
    public function getConflictingBookings($checkInDate, $checkOutDate = null)
    {
        // If no check-out date (day tour), just check the check-in date
        if (!$checkOutDate) {
            $checkOutDate = $checkInDate;
        }

        // Convert to Carbon instances if they're strings
        if (is_string($checkInDate)) {
            try {
                $checkInDate = \Carbon\Carbon::parse($checkInDate);
            } catch (\Exception $e) {
                return false; // Return false for availability check
            }
        }
        if (is_string($checkOutDate)) {
            try {
                $checkOutDate = \Carbon\Carbon::parse($checkOutDate);
            } catch (\Exception $e) {
                return false; // Return false for availability check
            }
        }

        return $this->bookings()
            ->where('status', '!=', 'cancelled') // Exclude cancelled bookings
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                    // Check if the new booking overlaps with existing bookings
                    // Case 1: New check-in is between existing check-in and check-out
                    $q->where('check_in_date', '<=', $checkInDate)
                      ->where('check_out_date', '>=', $checkInDate);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 2: New check-out is between existing check-in and check-out
                    $q->where('check_in_date', '<=', $checkOutDate)
                      ->where('check_out_date', '>=', $checkOutDate);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 3: New booking completely encompasses existing booking
                    $q->where('check_in_date', '>=', $checkInDate)
                      ->where('check_out_date', '<=', $checkOutDate);
                });
            })
            ->with('user') // Eager load user information
            ->get();
    }

    /**
     * The "booted" method of the model.
     * Used to register a deleting event to remove associated image files.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($room) {
            // Delete the associated image file from storage if it exists
            if ($room->image_path) {
                Storage::disk('public')->delete($room->image_path);
            }
        });
    }
}