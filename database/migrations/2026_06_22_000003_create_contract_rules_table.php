<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_rules', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreignId('contracts_id')->constrained('contracts')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_rules');
    }
};
