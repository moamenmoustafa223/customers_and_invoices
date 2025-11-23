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
        Schema::create('payment_method_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->foreignId('to_payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->decimal('amount', 14, 3);
            $table->date('transfer_date');
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_transfers');
    }
};
