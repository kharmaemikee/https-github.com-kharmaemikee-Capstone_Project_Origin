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
        Schema::create('tourist_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // This is the ID of the tourist (User)
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade'); // Link to booking
            $table->text('message');
            $table->string('type')->nullable(); // e.g., 'booking_approved', 'booking_rejected', 'booking_update'
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_notifications');
    }
};