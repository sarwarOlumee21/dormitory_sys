<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // انتقال اتاق‌های قراردادها به ساکنین مرتبط
        DB::statement(
            'UPDATE residents JOIN contracts ON residents.id = contracts.resident_id SET residents.room_id = contracts.room_id WHERE contracts.room_id IS NOT NULL'
        );

        Schema::table('contracts', function (Blueprint $table) {
            if (Schema::hasColumn('contracts', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn('room_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
        });
    }
};
