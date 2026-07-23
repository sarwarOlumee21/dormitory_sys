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
        // Create meals table
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner'])->nullable();
            $table->timestamps();
        });

        // Create meal_schedules table
        Schema::create('meal_schedules', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('day_of_week')->nullable();
            $table->unsignedBigInteger('meals_id');
            $table->timestamps();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Foreign key constraint
            $table->foreign('meals_id')
                ->references('id')
                ->on('meals')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_schedules');
        Schema::dropIfExists('meals');
    }
};
