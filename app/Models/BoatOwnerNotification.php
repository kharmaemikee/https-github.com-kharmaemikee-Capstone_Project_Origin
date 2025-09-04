<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoatOwnerNotification extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'boat_owner_notifications';

    protected $fillable = [
        'user_id', // The boat owner's user ID
        'booking_id', // The booking related to this notification (nullable if not always related)
        'message',
        'type', // e.g., 'boat_assigned', 'boat_available', 'general', 'booking_completed'
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the user (Boat Owner) that owns this notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the booking associated with the notification.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
