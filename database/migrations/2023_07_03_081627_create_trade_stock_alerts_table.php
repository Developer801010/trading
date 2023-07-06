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
        Schema::create('trade_stock_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->integer('direction')->default(0)->comment('0:buy, 1:sell');
            $table->string('entry_price')->comment('the price at which the trade was entered');
            $table->string('position_size')->comment('desired position size as a percentage of the account size.');
            $table->string('stop_loss')->comment('predetermined stop loss price');
            $table->string('target_price')->comment('predetermined target price');
            $table->datetime('trade_date')->comment('the date when the trade was executed');
            $table->text('trade_description')->nullable()->comment('additional details or commentary about the trade');
            $table->string('chart_image_path')->nullable()->comment('chart image related to the trade.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_stock_alerts');
    }
};
