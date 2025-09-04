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
            // Check if the column already exists to prevent errors on re-running
            if (!Schema::hasColumn('resorts', 'visit_count')) {
                $table->integer('visit_count')->default(0)->after('image_path');
                // You can change 'image_path' to another existing column name
                // if you want the 'visit_count' column to appear elsewhere in your table structure.
                // For example: ->after('contact_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resorts', function (Blueprint $table) {
            if (Schema::hasColumn('resorts', 'visit_count')) {
                $table->dropColumn('visit_count');
            }
        });
    }
};