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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('invoice_status_id')->constrained('invoice_statuses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->decimal('subtotal', 14, 3)->default(0.000);
            $table->decimal('discount', 14, 3)->default(0.000);
            $table->decimal('tax', 14, 3)->default(0.000);
            $table->decimal('total', 14, 3)->default(0.000);
            $table->decimal('paid_amount', 14, 3)->default(0.000);
            $table->decimal('remaining_amount', 14, 3)->default(0.000);
            $table->text('notes_ar')->nullable();
            $table->text('notes_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
