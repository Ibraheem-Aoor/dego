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
        Schema::create('driver_cars', function (Blueprint $table) {
            $table->id();
            $table->string('thumb')->nullable();
            $table->string('thumb_driver',50)->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('model');
            $table->string('number');
            $table->integer('max_passengers');
            $table->unsignedBigInteger('driver_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_cars');
    }
};
