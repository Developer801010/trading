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
        Schema::table('trade_logs', function (Blueprint $table) {
            $table->string('trade_details_id')->after('trade_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_logs', function (Blueprint $table) {
            $table->dropColumn('trade_details_id');
        });
    }
};
