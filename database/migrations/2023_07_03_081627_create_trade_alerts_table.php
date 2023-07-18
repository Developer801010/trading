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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->string('trade_type')->comment('stock, option');
            $table->string('trade_symbol');
            $table->string('trade_direction')->comment('buy, sell');
            $table->string('trade_option')->comment('call, put')->nullable()->comment('Only for option trades');      
            $table->date('expiration_date')->nullable();
            $table->decimal('strike_price', 10, 2)->nullable();
            $table->decimal('entry_price', 10, 2);
            $table->string('stop_price');
            $table->decimal('target_price', 10, 2)->nullable()->comment('Only for open stock trades');            
            $table->date('entry_date');
            $table->decimal('position_size', 10, 2);
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
        Schema::dropIfExists('trades');
    }
};
