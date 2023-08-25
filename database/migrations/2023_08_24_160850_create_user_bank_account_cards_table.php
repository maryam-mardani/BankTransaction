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
        Schema::create('user_bank_account_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_bank_account_id');
            $table->string('card_number');
            $table->integer('cvv2');
            $table->string('expire_year');
            $table->string('expire_month');
            $table->string('password');
            

            $table->foreign('user_bank_account_id')->references('id')->on('user_bank_accounts');
            $table->index('user_bank_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bank_account_cards');
    }
};
