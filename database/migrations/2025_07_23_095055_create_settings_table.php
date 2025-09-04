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
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Add a default entry for last_assigned_boat_id
        // This will track the ID of the last boat assigned to ensure sequential assignment.
        \App\Models\Setting::create(['key' => 'last_assigned_boat_id', 'value' => '0']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
