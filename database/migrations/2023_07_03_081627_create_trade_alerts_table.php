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
        Schema::create('trade_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('trade_type')->comment('stock, option');
            $table->string('trade_symbol');
            $table->string('trade_direction')->comment('buy, sell');
            $table->string('trade_option')->comment('call, put');
            $table->string('long_short')->comment('long, short');
            $table->date('entry_date');
            $table->decimal('entry_price', 10, 2);
            $table->date('exit_date')->nullable()->comment('Only for closed trades');
            $table->decimal('exit_price', 10, 2)->nullable()->comment('Only for closed trades');
            $table->decimal('position_size', 10, 2);
            $table->decimal('stop_price', 10, 2);
            $table->decimal('projected_target_price', 10, 2)->nullable()->comment('Only for open stock trades');
            $table->decimal('total_position_in_stock', 10, 2)->nullable()->comment('Only for open stock trades');
            $table->decimal('average_price', 10, 2)->nullable()->comment('Only for open stock trades');
            $table->decimal('profit_percentage', 5, 2)->nullable()->comment('Only for closed trades');
            $table->decimal('gain_loss', 10, 2)->nullable()->comment('Only for closed trades');
            $table->decimal('gain_loss_percentage', 5, 2)->nullable()->comment('Only for closed trades');
            $table->text('trade_description')->nullable();
            $table->string('chart_image')->nullable()->comment('The path or URL to the uploaded chart image');
            $table->dateTime('scheduled_at')->nullable()->comment('The date and time for scheduled posting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_alerts');
    }
};
