<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{


    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('incomes_category_id');
            $table->unsignedBigInteger('incomes_sub_category_id')->nullable();
            $table->foreignId('payment_method_id');

            $table->string('check_number')->nullable();
            $table->string('supplier')->nullable();
            $table->string('supplier_invoice_number')->nullable();

            $table->decimal('amount', 14,3);
            $table->decimal('tax');
            $table->decimal('amount_with_tax', 14,3);
            $table->decimal('tax_amount', 14,3);

            $table->date('expense_date');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->string('file')->nullable();
            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
