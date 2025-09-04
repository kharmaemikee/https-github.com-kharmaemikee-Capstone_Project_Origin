<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'resort_id', // The resort owner to whom the notification is addressed
        'message',
        'is_read',
    ];

    /**
     * Get the booking that the notification belongs to.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the resort associated with the notification.
     */
    public function resort(): BelongsTo
    {
        return $this->belongsTo(Resort::class);
    }
}
