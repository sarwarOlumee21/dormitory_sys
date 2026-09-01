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
            'UPDATE residents
             SET room_id = (
                 SELECT contracts.room_id
                 FROM contracts
                 WHERE contracts.resident_id = residents.id
                 AND contracts.room_id IS NOT NULL
                 LIMIT 1
             )
             WHERE EXISTS (
                 SELECT 1
                 FROM contracts
                 WHERE contracts.resident_id = residents.id
                 AND contracts.room_id IS NOT NULL
             )'
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
