<?php
// app/Models/TouristNotification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TouristNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // The ID of the tourist user who receives the notification
        'booking_id', // The ID of the booking related to the notification
        'message',
        'type', // e.g., 'booking_approved', 'booking_rejected', 'booking_update', 'booking_completed'
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relationship to the User (Tourist) who owns this notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Assumes 'user_id' is the foreign key by convention
    }

    /**
     * Relationship to the Booking that triggered this notification.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class); // Assumes 'booking_id' is the foreign key by convention
    }
}
