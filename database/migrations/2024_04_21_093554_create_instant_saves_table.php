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
        Schema::create('instant_saves', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->integer('deposit_id')->nullable();
            $table->integer('total_adult')->nullable();
            $table->integer('total_children')->nullable();
            $table->integer('total_infant')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('total_gross')->nullable();
            $table->string('date')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->text('message')->nullable();
            $table->tinyInteger('cupon_status')->default('0')->comment('0 => No, 1 => Yes');
            $table->string('cupon_code')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instant_saves');
    }
};
