<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make boat_number nullable without requiring doctrine/dbal
        DB::statement('ALTER TABLE boats MODIFY boat_number VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to NOT NULL (will fail if nulls exist; ensure cleanup before rollback)
        DB::statement("ALTER TABLE boats MODIFY boat_number VARCHAR(255) NOT NULL");
    }
};


