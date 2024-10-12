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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('short_name', 20)->nullable();
            $table->string('flag', 100)->nullable();
            $table->string('flag_driver', 20)->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 => Inactive, 1 => Active');
            $table->tinyInteger('rtl')->default(0)->comment('0 => Inactive, 1 => Active');
            $table->tinyInteger('default_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
