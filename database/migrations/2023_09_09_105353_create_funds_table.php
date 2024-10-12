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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('gateway_id')->unsigned()->nullable();
            $table->integer('fundable_id')->unsigned()->nullable();
            $table->string('fundable_type', 91);
            $table->string('gateway_currency', 191)->nullable();
            $table->decimal('amount', 18, 8)->default(0.00000000);
            $table->decimal('charge', 18, 8)->default(0.00000000);
            $table->decimal('percentage_charge', 18, 8)->default(0.00000000);
            $table->decimal('fixed_charge', 18, 8)->default(0.00000000);
            $table->decimal('final_amount', 18, 8)->default(0.00000000);
            $table->decimal('payable_amount_base_currency', 18, 8)->default(0.00000000);
            $table->decimal('btc_amount', 18, 8)->nullable();
            $table->string('btc_wallet', 191)->nullable();
            $table->string('transaction', 25)->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=> Complete, 2=> Pending, 3 => Cancel, 4=> failed');
            $table->text('detail')->nullable();
            $table->text('feedback')->nullable();
            $table->string('validation_token', 191)->nullable();
            $table->string('referenceno', 191)->nullable();
            $table->string('reason', 191)->nullable();
            $table->text('information')->nullable();
            $table->text('api_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
