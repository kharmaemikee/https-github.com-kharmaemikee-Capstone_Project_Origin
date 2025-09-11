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
            $table->boolean('bir_resubmitted')->default(false);
            $table->boolean('dti_resubmitted')->default(false);
            $table->boolean('business_permit_resubmitted')->default(false);
            $table->boolean('tourism_registration_resubmitted')->default(false);
            $table->boolean('lgu_resolution_resubmitted')->default(false);
            $table->boolean('marina_cpc_resubmitted')->default(false);
            $table->boolean('boat_association_resubmitted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bir_resubmitted',
                'dti_resubmitted', 
                'business_permit_resubmitted',
                'tourism_registration_resubmitted',
                'lgu_resolution_resubmitted',
                'marina_cpc_resubmitted',
                'boat_association_resubmitted'
            ]);
        });
    }
};
