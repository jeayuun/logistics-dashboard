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
        Schema::table('alert_logs', function (Blueprint $table) {
            $table->decimal('route_distance', 10, 2)->nullable()->after('distance');
            $table->decimal('duration', 10, 2)->nullable()->after('route_distance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alert_logs', function (Blueprint $table) {
            //
        });
    }
};
