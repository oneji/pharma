<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_medicine', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('brand_id');

            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_medicine');
    }
}
