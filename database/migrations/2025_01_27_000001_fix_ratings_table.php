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
        // Check if ratings table exists and fix its structure
        if (Schema::hasTable('ratings')) {
            // Drop the existing ratings table if it has wrong structure
            Schema::dropIfExists('ratings');
        }
        
        // Create the ratings table with correct structure
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tourist who rated
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // Booking that was rated
            $table->foreignId('resort_id')->constrained()->onDelete('cascade'); // Resort that was rated
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade'); // Room that was rated (if applicable)
            $table->integer('rating'); // Rating from 1 to 5 stars
            $table->text('comment')->nullable(); // Optional comment
            $table->timestamps();
            
            // Ensure a user can only rate a booking once
            $table->unique(['user_id', 'booking_id']);
            
            // Index for performance
            $table->index(['resort_id', 'rating']);
            $table->index(['room_id', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
