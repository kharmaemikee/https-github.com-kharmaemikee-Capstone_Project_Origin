<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'overnight_departure_time')) {
                $table->dateTime('overnight_departure_time')->nullable()->after('day_tour_time_of_pickup');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'overnight_departure_time')) {
                $table->dropColumn('overnight_departure_time');
            }
        });
    }
};
