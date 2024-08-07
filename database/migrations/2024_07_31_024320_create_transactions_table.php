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
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('wedding_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['pending', 'success'])->nullable()->default('process');
            $table->enum('payment_type', ['down payment', 'full payment'])->nullable()->default(NULL);
            $table->enum('condition', ['fraud', 'reject', 'accept'])->nullable()->default(NULL);
            $table->integer('dp_price')->nullable();
            $table->integer('full_price')->nullable();
            $table->integer('price');
            $table->string('invoice');
            $table->date('transaction_date');
            $table->timestamps();
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
