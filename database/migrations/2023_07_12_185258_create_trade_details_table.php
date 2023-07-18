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
        Schema::create('trade_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_id');
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

            $table->foreign('trade_id')->references('id')->on('trades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_details');
    }
};
