<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_employees_id')->constrained()->cascadeOnDelete();
            $table->string('image')->default('avatar.png');

            $table->string('name_ar');
            $table->string('name_en');

            $table->string('employee_no')->unique();
            $table->date('Join_date')->nullable();

            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('password',255);
            $table->rememberToken();

            $table->date('birth_date')->nullable();
            $table->boolean('gender')->default(0);
            $table->string('Nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('social_status')->nullable();

            $table->string('id_number')->nullable();
            $table->date('start_date_id')->nullable();
            $table->date('end_date_id')->nullable();

            $table->string('passport_number')->nullable();
            $table->date('start_date_passport')->nullable();
            $table->date('end_date_passport')->nullable();
            $table->string('Place')->nullable();

            $table->string('academic')->nullable();
            $table->string('type_academic')->nullable();
            $table->string('date_academic')->nullable();
            $table->string('place_academic')->nullable();

            $table->string('jop_ar');
            $table->string('jop_en');

            $table->string('address')->nullable();
            $table->string('notes')->nullable();

            $table->boolean('status')->default('0');
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
        Schema::dropIfExists('employees');
    }
}
