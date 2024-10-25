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
        Schema::create('driver_rides', function (Blueprint $table) {
            $table->id();
            $table->mediumText('from');
            $table->mediumText('to');
            $table->integer('price');
            $table->unsignedBigInteger('driver_id');
            $table->tinyInteger('status' )->default('0')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_rides');
    }
};
