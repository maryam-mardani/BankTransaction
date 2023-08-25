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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('source_card_number');
            $table->string('target_card_number');
            $table->integer('amount');
            $table->integer('fee');
            $table->unsignedBigInteger('transaction_status_id');
            $table->string('message')->nullable();

            
            $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses');
            $table->index('transaction_status_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
