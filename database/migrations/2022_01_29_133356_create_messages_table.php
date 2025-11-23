<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{


    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->longText('notes');
            $table->longText('reply')->nullable();
            $table->boolean('status')->default('0');
            $table->timestamps();
        });
    }




    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
