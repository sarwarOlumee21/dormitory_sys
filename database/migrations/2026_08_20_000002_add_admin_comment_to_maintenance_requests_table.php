<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('maintenance_requests') && !Schema::hasColumn('maintenance_requests', 'admin_comment')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->text('admin_comment')->nullable()->after('description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('maintenance_requests') && Schema::hasColumn('maintenance_requests', 'admin_comment')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->dropColumn('admin_comment');
            });
        }
    }
};
