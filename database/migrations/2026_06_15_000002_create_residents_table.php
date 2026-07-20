<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('residents', function (Blueprint $table) {
        $table->id();

        $table->string('resident_code', 50)->unique()->nullable();
        $table->string('name', 150);
        $table->string('father_name', 150)->nullable();
        $table->string('phone_number', 30)->nullable();
        $table->string('city_name', 120)->nullable();
        $table->string('occupation', 120)->nullable();
        $table->string('work_phone', 30)->nullable();
        $table->string('occupation_location', 255)->nullable();

        $table->string('guarantor_name', 150)->nullable();
        $table->string('guarantor_father_name', 150)->nullable();
        $table->string('guarantor_phone', 30)->nullable();
        $table->string('guarantor_occupation', 150)->nullable();
        $table->string('guarantor_occupation_location', 300)->nullable();

        $table->foreignId('room_id')
              ->constrained('rooms')
              ->cascadeOnDelete();

        $table->string('status', 50)->default('فعال');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
