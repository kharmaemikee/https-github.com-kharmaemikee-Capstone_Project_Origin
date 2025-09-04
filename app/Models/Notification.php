<?php
// app/Models/Notification.php (This is the suggested new model.
// If you have an existing generic Notification model, provide it.
// Otherwise, this is a placeholder for future implementation if you
// decide to add a generic notifications table later.)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // The ID of the user who will receive the notification (tourist or boat owner)
        'message',
        'type', // e.g., 'booking_approved', 'boat_booked'
        'is_read',
        'related_id', // Optional: to link to a specific booking_id or boat_id if needed
        'related_type', // Optional: 'booking', 'boat'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
