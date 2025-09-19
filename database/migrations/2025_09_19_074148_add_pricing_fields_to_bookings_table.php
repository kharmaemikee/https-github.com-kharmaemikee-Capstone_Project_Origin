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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('base_room_price', 10, 2)->nullable()->after('num_pwds');
            $table->decimal('extra_person_charge', 10, 2)->default(0)->after('base_room_price');
            $table->decimal('senior_discount', 10, 2)->default(0)->after('extra_person_charge');
            $table->decimal('final_total_price', 10, 2)->nullable()->after('senior_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['base_room_price', 'extra_person_charge', 'senior_discount', 'final_total_price']);
        });
    }
};
