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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->integer('package_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('deposit_id')->nullable();
            $table->string('package_title')->nullable();
            $table->dateTime('date');
            $table->string('duration')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('total_person')->nullable();
            $table->integer('total_infant')->nullable();
            $table->integer('total_adult')->nullable();
            $table->integer('total_children')->nullable();
            $table->integer('start_price')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('lname')->nullable();
            $table->string('fname')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address_two')->nullable();
            $table->string('address_one')->nullable();
            $table->string('trx_id')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 => Pending, 2 => Accepted, 3 => Rejected');
            $table->string('coupon')->nullable();
            $table->tinyInteger('cupon_status')->default('0')->comment('0 => No , 1 => Yes');
            $table->string('cupon_number')->nullable();
            $table->string('discount_amount')->nullable();
            $table->text('message')->nullable();
            $table->text('adult_info')->nullable();
            $table->text('child_info')->nullable();
            $table->text('infant_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
