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
        Schema::create('favourite_destinations', function (Blueprint $table) {
            $table->id();
            $table->integer('destination_id');
            $table->integer('user_id');
            $table->tinyInteger('reaction')->default('0')->comment(' 1 => Favourite, 0 => None');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_destinations');
    }
};
