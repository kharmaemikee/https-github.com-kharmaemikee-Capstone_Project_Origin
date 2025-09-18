<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'senior_id_image_path')) {
                $table->string('senior_id_image_path', 255)->nullable()->after('valid_id_image_path');
            }
            if (!Schema::hasColumn('bookings', 'pwd_id_image_path')) {
                $table->string('pwd_id_image_path', 255)->nullable()->after('senior_id_image_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'senior_id_image_path')) {
                $table->dropColumn('senior_id_image_path');
            }
            if (Schema::hasColumn('bookings', 'pwd_id_image_path')) {
                $table->dropColumn('pwd_id_image_path');
            }
        });
    }
};


