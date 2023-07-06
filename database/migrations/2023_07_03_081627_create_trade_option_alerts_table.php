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
        Schema::create('trade_option_alerts', function (Blueprint $table) {
            $table->id();
            $table->integer('direction')->default(0)->comment('0:buy, 1:sell');
            $table->string('symbol');
            $table->string('option_type');
            $table->datetime('expiry_date')->comment('the expiration date of the option');
            $table->string('strike_price')->comment('the strike price of the option');
            $table->string('buy_price')->comment('');
            $table->string('stop_price')->comment('the predetermined stop price');
            $table->string('target_price')->comment('predetermined target price');
            $table->string('position_size')->comment('desired position size as a percentage of the account size.');
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
        Schema::dropIfExists('trade_option_alerts');
    }
};
