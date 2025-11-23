<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number');

            $table->string('name');

            $table->string('job_name_ar');
            $table->string('job_name_en');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('date')->nullable();

            $table->double('basic_salary', 14,3);

            $table->double('cost_of_living_allowance', 14,3)->nullable();
            $table->double('food_allowance', 14,3)->nullable();
            $table->double('housing_allowance', 14,3)->nullable();
            $table->double('transfer_allowance', 14,3)->nullable();
            $table->double('overtime', 14,3)->nullable();
            $table->double('phone_allowance', 14,3)->nullable();
            $table->double('medical', 14,3)->nullable();
            $table->double('other_allowance', 14,3)->nullable();

            $table->double('Social_insurance_discount', 14,3)->nullable();

            $table->double('total_salary', 14,3)->nullable();

            $table->string('contract_duration')->nullable();
            $table->longText('contract_terms_ar')->nullable();
            $table->longText('contract_terms_en')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
