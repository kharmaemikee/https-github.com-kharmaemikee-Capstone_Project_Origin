<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add assigned_boat_id column as a foreign key to the boats table.
            // It's nullable because a booking is initially pending and might not have an assigned boat yet.
            $table->foreignId('assigned_boat_id')->nullable()->constrained('boats')->onDelete('set null')->after('num_pwds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropConstrainedForeignId('assigned_boat_id');
            // Then drop the column
            $table->dropColumn('assigned_boat_id');
        });
    }
};
