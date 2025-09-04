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
        Schema::create('boat_owner_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The boat owner
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null'); // The booking related to the notification
            $table->text('message');
            $table->string('type')->default('general'); // e.g., 'boat_assigned', 'boat_available', 'general'
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boat_owner_notifications');
    }
};
