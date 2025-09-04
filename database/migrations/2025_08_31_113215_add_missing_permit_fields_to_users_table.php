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
            // Boat Owner specific permits
            $table->string('lgu_resolution_path')->nullable()->after('owner_image_path');
            $table->string('marina_cpc_path')->nullable()->after('lgu_resolution_path');
            $table->string('boat_association_path')->nullable()->after('marina_cpc_path');
            
            // Resort Owner specific permits
            $table->string('tourism_registration_path')->nullable()->after('boat_association_path');
            
            // Approval fields for new permits
            $table->boolean('lgu_resolution_approved')->default(false)->after('tourism_registration_path');
            $table->boolean('marina_cpc_approved')->default(false)->after('lgu_resolution_approved');
            $table->boolean('boat_association_approved')->default(false)->after('marina_cpc_approved');
            $table->boolean('tourism_registration_approved')->default(false)->after('boat_association_approved');
            
            // Resubmit flags for new permits
            $table->boolean('lgu_resolution_resubmit')->default(false)->after('tourism_registration_approved');
            $table->boolean('marina_cpc_resubmit')->default(false)->after('lgu_resolution_resubmit');
            $table->boolean('boat_association_resubmit')->default(false)->after('marina_cpc_resubmit');
            $table->boolean('tourism_registration_resubmit')->default(false)->after('boat_association_resubmit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'lgu_resolution_path',
                'marina_cpc_path', 
                'boat_association_path',
                'tourism_registration_path',
                'lgu_resolution_approved',
                'marina_cpc_approved',
                'boat_association_approved',
                'tourism_registration_approved',
                'lgu_resolution_resubmit',
                'marina_cpc_resubmit',
                'boat_association_resubmit',
                'tourism_registration_resubmit'
            ]);
        });
    }
};
