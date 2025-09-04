<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Specify the custom primary key
    protected $primaryKey = 'key';

    // Indicate that the primary key is not auto-incrementing
    public $incrementing = false;

    // Specify the type of the primary key
    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value.
     *
     * @param string $key Ang key ng setting (e.g., 'last_assigned_boat_id').
     * @param mixed $default Ang default value kung hindi makita ang key.
     * @return mixed Ang value ng setting, o ang default value.
     */
    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->first()->value ?? $default;
    }

    /**
     * Set a setting value.
     *
     * @param string $key Ang key ng setting.
     * @param mixed $value Ang value na ise-set.
     * @return void
     */
    public static function set(string $key, $value): void
    {
        // Use updateOrCreate with the 'key' as the identifier
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
