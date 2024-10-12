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
        Schema::create('package_visitors', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id')->nullable();
            $table->ipAddress();
            $table->dateTime('bouncing_time')->nullable();
            $table->string('browser_info')->nullable();
            $table->string('os')->nullable();
            $table->string('device')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_visitors');
    }
};
