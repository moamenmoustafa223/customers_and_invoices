<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('image')->default('avatar.png');

            $table->string('name_ar');
            $table->string('name_en');

            $table->string('email')->unique();
            $table->string('phone')->unique();

            $table->string('id_number')->unique();

            $table->string('jop_ar');
            $table->string('jop_en');

            $table->boolean('gender')->default(0);
            $table->string('Nationality');
            $table->string('religion')->nullable();
            $table->string('social_status')->nullable();
            $table->string('address');

            $table->string('academic')->nullable();
            $table->string('type_academic')->nullable();
            $table->string('date_academic')->nullable();
            $table->string('place_academic')->nullable();

            $table->string('training_department')->nullable();
            $table->string('training_duration')->nullable();
            $table->string('training_salary')->nullable();

            $table->date('start_training_date')->nullable();
            $table->date('end_training_date')->nullable();
            $table->text('training_place')->nullable();

            $table->boolean('attend_training')->default(0);
            $table->string('management_skills')->nullable();
            $table->string('technical_skills')->nullable();
            $table->string('evaluation')->nullable();

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
        Schema::dropIfExists('trainees');
    }
}
