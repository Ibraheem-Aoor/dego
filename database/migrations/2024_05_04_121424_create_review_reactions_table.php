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
        Schema::create('review_reactions', function (Blueprint $table) {
            $table->id();
            $table->integer('review_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('reaction_like')->default('0')->comment('0 => Active, 1');
            $table->tinyInteger('reaction_dislike')->default('0')->comment('0 => inactive, 1 => Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reactions');
    }
};
