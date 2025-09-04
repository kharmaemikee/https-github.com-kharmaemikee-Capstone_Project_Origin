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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Tourist making the booking (renamed from tourist_id to match users table column name)
            $table->foreignId('resort_owner_id')->nullable()->constrained('users')->onDelete('set null'); // NEW: Link to the resort owner (User)

            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            // $table->foreignId('resort_id')->constrained()->onDelete('cascade'); // REMOVED: Since we have resort_owner_id and room_id links to resort, this is redundant. You can get resort info via $booking->room->resort.

            $table->string('guest_name')->nullable(); // Added from your controller
            $table->integer('guest_age')->nullable();
            $table->string('guest_gender')->nullable();
            $table->string('guest_address')->nullable();
            $table->string('guest_nationality')->nullable();
            $table->string('phone_number')->nullable(); // Added from your controller
            $table->string('name_of_resort')->nullable(); // Denormalized for easier access

            $table->date('check_in_date');
            $table->date('check_out_date')->nullable(); // Make nullable for day tour
            $table->integer('number_of_nights')->nullable(); // Make nullable for day tour
            $table->integer('number_of_guests');
            $table->text('special_requests')->nullable();

            $table->string('status')->default('pending'); // pending, approved, rejected, cancelled, completed

            // Tour Type specific fields
            $table->string('tour_type')->nullable(); // 'day_tour' or 'overnight'
            $table->time('day_tour_departure_time')->nullable();
            $table->time('day_tour_time_of_pickup')->nullable();
            $table->dateTime('overnight_date_time_of_pickup')->nullable();
            $table->integer('num_senior_citizens')->default(0);
            $table->integer('num_pwds')->default(0);

            // Boat details
            $table->string('assigned_boat')->nullable();
            $table->string('boat_captain_crew')->nullable();
            $table->string('boat_contact_number')->nullable();

            // $table->decimal('total_price', 10, 2); // Commented out based on previous discussions if not currently calculated/used

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};