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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('package_category_id')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('infant_price')->nullable();
            $table->integer('children_Price')->nullable();
            $table->integer('adult_price')->nullable();
            $table->integer('destination_id')->nullable();
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('map')->nullable();
            $table->string('created-at')->nullable();
            $table->text('maximumTravelers')->nullable();
            $table->text('minimumTravelers')->nullable();
            $table->text('endMessage')->nullable();
            $table->text('startMessage')->nullable();
            $table->text('facility')->nullable();
            $table->text('description')->nullable();
            $table->string('thumb_driver')->nullable();
            $table->string('thumb')->nullable();
            $table->string('end_point')->nullable();
            $table->string('start_point')->nullable();
            $table->tinyInteger('status')->nullable()->comment('0=>Inactive, 1=>Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
