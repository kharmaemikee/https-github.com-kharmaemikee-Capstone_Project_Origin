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
            if (!Schema::hasColumn('boats', 'captain_name')) {
                $table->string('captain_name')->nullable()->after('boat_capacities');
            }
            if (!Schema::hasColumn('boats', 'captain_contact')) {
                $table->string('captain_contact')->nullable()->after('captain_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            if (Schema::hasColumn('boats', 'captain_contact')) {
                $table->dropColumn('captain_contact');
            }
            if (Schema::hasColumn('boats', 'captain_name')) {
                $table->dropColumn('captain_name');
            }
        });
    }
};


