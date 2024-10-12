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
        Schema::create('favourite_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('reaction')->default('0')->comment(' 0 => Inactive, 1 => Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_lists');
    }
};
