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
        Schema::table('residents', function (Blueprint $table) {
            $table->string('resident_image_url')->nullable()->after('guarantor_occupation_location');
            $table->string('id_card_image_url')->nullable()->after('resident_image_url');
            $table->string('guarantor_image_url')->nullable()->after('id_card_image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn(['resident_image_url', 'id_card_image_url', 'guarantor_image_url']);
        });
    }
};
