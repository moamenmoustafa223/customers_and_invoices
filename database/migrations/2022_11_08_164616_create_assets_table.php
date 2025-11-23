<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assets_category_id');
            $table->unsignedBigInteger('assets_sub_category_id')->nullable();
            $table->foreignId('payment_method_id');

            $table->string('check_number')->nullable();
            $table->string('code_no');

            $table->string('supplier')->nullable();
            $table->string('supplier_invoice_number')->nullable();

            $table->decimal('amount', 14,3);
            $table->decimal('tax');
            $table->decimal('tax_amount', 14,3);
            $table->decimal('amount_with_tax', 14,3);

            $table->date('expense_date');
            $table->text('description')->nullable();

            $table->string('depreciation_rate');

            $table->string('file')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
