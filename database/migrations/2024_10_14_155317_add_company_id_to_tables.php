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
        // tables that might a company have
        Schema::table('destinations', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropForeign('destinations_company_id_foreign');
            $table->dropColumn('company_id');
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign('packages_company_id_foreign');
            $table->dropColumn('company_id');
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }

};
