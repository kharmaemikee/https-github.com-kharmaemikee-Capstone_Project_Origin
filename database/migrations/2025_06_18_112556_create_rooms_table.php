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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            // Foreign key to link rooms to a specific resort
            $table->foreignId('resort_id')->constrained('resorts')->onDelete('cascade');
            $table->string('room_name');
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 10, 2); // e.g., 5000.00
            $table->integer('max_guests');
            $table->string('image_path')->nullable(); // Path to room image, can be null
            $table->boolean('is_available')->default(true); // Is the room currently available for booking?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};