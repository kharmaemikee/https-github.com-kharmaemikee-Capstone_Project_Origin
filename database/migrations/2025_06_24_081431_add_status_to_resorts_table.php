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
        Schema::table('resorts', function (Blueprint $table) {
            // Add the 'status' column. It will default to 'open'.
            // You can choose where to place it; 'after' contact_number is a common choice.
            $table->string('status')->default('open')->after('contact_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resorts', function (Blueprint $table) {
            // Drop the 'status' column if rolling back the migration
            $table->dropColumn('status');
        });
    }
};