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
            $table->boolean('bir_approved')->default(false)->after('bir_permit_path');
            $table->boolean('dti_approved')->default(false)->after('dti_permit_path');
            $table->boolean('business_permit_approved')->default(false)->after('business_permit_path');
            $table->boolean('owner_pic_approved')->default(false)->after('owner_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bir_approved',
                'dti_approved',
                'business_permit_approved',
                'owner_pic_approved'
            ]);
        });
    }
};
