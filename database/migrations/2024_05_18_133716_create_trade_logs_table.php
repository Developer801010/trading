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
        Schema::create('trade_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trade_id')->unsigned();
            $table->string('trade_type', 255)->comment('stock, option');
            $table->string('trade_symbol', 255);
            $table->string('symbol_image', 255)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('trade_direction', 255)->comment('buy, sell, add, close');
            $table->string('trade_title', 255)->nullable();
            $table->string('trade_option', 255)->nullable()->comment('Only for option trades');
            $table->date('expiration_date')->nullable();
            $table->decimal('current_price', 10, 2)->default(0.00);
            $table->decimal('strike_price', 10, 2)->nullable();
            $table->decimal('entry_price', 10, 2);
            $table->string('stop_price', 255);
            $table->decimal('target_price', 10, 2)->nullable()->comment('Only for open stock trades');
            $table->date('entry_date');
            $table->string('share_qty', 255)->nullable();
            $table->string('share_in_amount', 255)->nullable();
            $table->date('exit_date')->nullable();
            $table->decimal('exit_price', 10, 2)->nullable();
            $table->longText('close_comment')->nullable();
            $table->string('close_image', 255)->nullable();
            $table->decimal('position_size', 10, 2);
            $table->longText('trade_description')->nullable();
            $table->string('chart_image', 255)->nullable()->comment('The path or URL to the uploaded chart image');
            $table->dateTime('scheduled_at')->nullable()->comment('The date and time for scheduled posting');
            $table->timestamps();

            $table->foreign('trade_id')->references('id')->on('trades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_logs');
    }
};
