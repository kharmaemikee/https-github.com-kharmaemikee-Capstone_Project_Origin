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
        Schema::table('rooms', function (Blueprint $table) {
            // Add the 'status' column
            $table->string('status')->default('open')->after('is_available'); // 'open', 'closed', 'rehab'

            // Add the 'rehab_reason' column, nullable
            $table->text('rehab_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Drop the new columns if rolling back the migration
            $table->dropColumn('rehab_reason');
            $table->dropColumn('status');
        });
    }
};