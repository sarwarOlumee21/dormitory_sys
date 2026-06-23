<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->date('contract_date')->nullable();
            $table->string('duration', 100)->nullable();
            $table->decimal('contract_amount', 14, 2)->default(0.00);
            $table->decimal('payment_amount', 14, 2)->default(0.00);
            $table->string('payment_status', 50)->default('پرداخت نشده');
            $table->unsignedSmallInteger('months_paid')->nullable();
            $table->string('contract_status', 50)->default('فعال');
            $table->longText('contract_text')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
