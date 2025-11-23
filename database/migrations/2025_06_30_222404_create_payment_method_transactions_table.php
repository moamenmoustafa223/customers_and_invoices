<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * القيود اليومية
     */
    public function up(): void
    {
        Schema::create('payment_method_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id');
            $table->date('transaction_date');
            $table->decimal('amount', 14, 3);
            $table->enum('type', ['credit', 'debit']); // + or -
            $table->string('source_type'); // e.g., 'expenses', 'salaries'
            $table->string('description'); 
            $table->unsignedBigInteger('source_id'); // ID from the original table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_transactions');
    }
};
