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
        Schema::table('trade_details', function (Blueprint $table) {
            $table->string('share_qty')->after('entry_date')->nullable();
            $table->string('share_in_amount')->after('share_qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_details', function (Blueprint $table) {
            $table->dropColumn('share_qty');
            $table->dropColumn('share_in_amount');
        });
    }
};
