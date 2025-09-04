// database/migrations/2025_07_04_xxxxxx_add_facebook_link_and_description_to_resorts_table.php

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
            // Add the new columns
            $table->text('description')->nullable()->after('location'); // Add description
            $table->string('facebook_page_link')->nullable()->after('contact_number'); // Add Facebook link
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resorts', function (Blueprint $table) {
            // Drop the columns if the migration is rolled back
            $table->dropColumn('facebook_page_link');
            $table->dropColumn('description');
        });
    }
};