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
        Schema::create('car_booking_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('a booking date for the car to be reserved at');
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('car_booking_id');
            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnDelete();
            $table->foreign('car_booking_id')->references('id')->on('car_bookings')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_booking_dates');
    }
};
