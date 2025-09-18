<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'is_extended')) {
                $table->boolean('is_extended')->default(false)->after('status');
            }
            if (!Schema::hasColumn('bookings', 'extension_type')) {
                $table->string('extension_type', 16)->nullable()->after('is_extended');
            }
            if (!Schema::hasColumn('bookings', 'extension_value')) {
                $table->integer('extension_value')->nullable()->after('extension_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'is_extended')) {
                $table->dropColumn('is_extended');
            }
            if (Schema::hasColumn('bookings', 'extension_type')) {
                $table->dropColumn('extension_type');
            }
            if (Schema::hasColumn('bookings', 'extension_value')) {
                $table->dropColumn('extension_value');
            }
        });
    }
};
