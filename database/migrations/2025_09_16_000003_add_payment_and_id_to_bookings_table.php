<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'downpayment_receipt_path')) {
                $table->string('downpayment_receipt_path')->nullable()->after('special_requests');
            }
            if (!Schema::hasColumn('bookings', 'valid_id_type')) {
                $table->string('valid_id_type', 50)->nullable()->after('downpayment_receipt_path');
            }
            if (!Schema::hasColumn('bookings', 'valid_id_image_path')) {
                $table->string('valid_id_image_path')->nullable()->after('valid_id_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'downpayment_receipt_path')) {
                $table->dropColumn('downpayment_receipt_path');
            }
            if (Schema::hasColumn('bookings', 'valid_id_type')) {
                $table->dropColumn('valid_id_type');
            }
            if (Schema::hasColumn('bookings', 'valid_id_image_path')) {
                $table->dropColumn('valid_id_image_path');
            }
        });
    }
};
