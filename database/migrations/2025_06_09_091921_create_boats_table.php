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
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the boat owner
            $table->string('boat_name');
            $table->string('boat_number')->unique();
            $table->decimal('boat_prices', 10, 2); // Assuming prices can have decimals
            $table->integer('boat_capacities');
            $table->string('image_path')->nullable(); // Store the path to the uploaded image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boats');
    }
};