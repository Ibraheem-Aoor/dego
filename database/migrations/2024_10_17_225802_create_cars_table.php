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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('thumb')->nullable();
            $table->string('thumb_driver',50)->nullable();
            $table->mediumText('name');
            $table->unsignedBigInteger('company_id');
            $table->string('engine_type')->comment('petrol, diesel, hybrid, electric');
            $table->string('transmission_type')->comment('manual, automatic');
            $table->integer('doors_count');
            $table->integer('passengers_count');
            $table->integer('storage_bag_count');
            $table->mediumText('pickup_location');
            $table->mediumText('drop_location');
            $table->text('fuel_policy')->nullable();
            $table->text('insurance_info')->nullable();
            $table->double('rent_price' , 10 , 2);
            $table->double('insurance_price' , 10 , 2)->default(0);
            $table->tinyInteger('status' )->default('0')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
