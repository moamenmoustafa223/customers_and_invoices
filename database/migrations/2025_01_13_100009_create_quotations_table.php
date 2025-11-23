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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('quotation_date');
            $table->date('valid_until')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->decimal('discount', 14, 3)->default(0.000);
            $table->decimal('subtotal', 14, 3)->default(0.000);
            $table->decimal('tax', 14, 3)->default(0.000);
            $table->decimal('total', 14, 3)->default(0.000);
            $table->text('notes_ar')->nullable();
            $table->text('notes_en')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'converted'])->default('pending');
            $table->foreignId('converted_invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
