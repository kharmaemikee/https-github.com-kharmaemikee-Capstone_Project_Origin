<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            if (!Schema::hasColumn('boats', 'archived')) {
                $table->boolean('archived')->default(false)->after('status');
            }
            if (!Schema::hasColumn('boats', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('archived');
            }
        });
    }

    public function down(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            if (Schema::hasColumn('boats', 'archived_at')) {
                $table->dropColumn('archived_at');
            }
            if (Schema::hasColumn('boats', 'archived')) {
                $table->dropColumn('archived');
            }
        });
    }
};


