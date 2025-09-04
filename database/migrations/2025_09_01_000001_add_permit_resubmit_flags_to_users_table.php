<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('bir_resubmit')->default(false)->after('bir_approved');
            $table->boolean('dti_resubmit')->default(false)->after('dti_approved');
            $table->boolean('business_permit_resubmit')->default(false)->after('business_permit_approved');
            $table->boolean('owner_pic_resubmit')->default(false)->after('owner_pic_approved');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bir_resubmit','dti_resubmit','business_permit_resubmit','owner_pic_resubmit']);
        });
    }
};


