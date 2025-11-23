<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->default('logo.png');
            $table->string('header')->default('header.png');
            $table->string('header_contract_image')->default('header.png');
            
            $table->string('stamp')->default('stamp.png');

            $table->string('company_name_ar');
            $table->string('company_name_en');
            $table->string('cr_no')->nullable();

            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();

            $table->string('governorate_ar')->nullable();
            $table->string('governorate_en')->nullable();

            $table->string('wilayat_ar')->nullable();
            $table->string('wilayat_en')->nullable();

            $table->string('building_no')->nullable();
            $table->string('PO_box')->nullable();
            $table->string('pc')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_code')->nullable();
            
            $table->string('tax_no')->nullable();
            $table->string('tax')->nullable();
            $table->decimal('tax_percentage', 5, 2)->default(15.00);

            $table->longText('contract_terms_ar')->nullable();
            $table->longText('contract_terms_en')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
