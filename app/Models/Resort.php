<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;

class Resort extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_name',
        'location',
        'contact_number',
        'description',
        'image_path',
        'facebook_page_link',
        'user_id',
        'status',
        'rehab_reason',
        'admin_status',
        'rejection_reason',
        'visit_count', // <--- ADDED: Allow mass assignment for visit_count
    ];

    protected $casts = [
        'visit_count' => 'integer', // <--- ADDED: Cast visit_count to integer
    ];


    /**
     * Get the user (owner) that owns the resort.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rooms for the resort.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the bookings for the resort (through its rooms).
     */
    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(Booking::class, Room::class);
    }

    /**
     * The "booted" method of the model.
     * Used to register a deleting event to remove associated image files.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($resort) {
            if ($resort->image_path) {
                Storage::disk('public')->delete($resort->image_path);
            }
        });
    }
}