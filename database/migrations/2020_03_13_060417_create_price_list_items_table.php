<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('price_list_id');
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('brand_id');
            $table->dateTime('exp_date');
            $table->string('price');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('price_list_id')->references('id')->on('price_lists');
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
        Schema::dropIfExists('price_list_items');
    }
}
