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
        Schema::table('boats', function (Blueprint $table) {
            // Add 'status' column with a default value of 'pending'
            // Ensure this column is unique only if you have a specific need, usually it's not.
            $table->string('status')->default('pending')->after('user_id'); // Or after any column you prefer

            // Add 'rejection_reason' column, nullable
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            // Drop the columns in the reverse order of creation
            $table->dropColumn('rejection_reason');
            $table->dropColumn('status');
        });
    }
};
