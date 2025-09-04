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
        Schema::table('users', function (Blueprint $table) {
            // Add columns for document paths, nullable as they are only for owners
            // Note: 'is_approved' is NOT included here as it's already in 2025_06_14_070953_add_is_approved_to_users_table.php
            $table->string('bir_permit_path')->nullable()->after('address');
            $table->string('dti_permit_path')->nullable()->after('bir_permit_path');
            $table->string('business_permit_path')->nullable()->after('dti_permit_path');
            $table->string('owner_image_path')->nullable()->after('business_permit_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns if rolling back the migration
            // Note: 'is_approved' is NOT dropped here
            $table->dropColumn([
                'bir_permit_path',
                'dti_permit_path',
                'business_permit_path',
                'owner_image_path'
            ]);
        });
    }
};