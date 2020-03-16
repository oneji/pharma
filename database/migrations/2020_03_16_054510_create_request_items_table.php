<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->text('comment')->nullable();
            $table->integer('changed')->default(0);
            $table->integer('changed_quantity')->default(0);
            $table->unsignedBigInteger('price_list_item_id');
            $table->unsignedBigInteger('request_id');
            $table->integer('removed')->default(0);
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('price_list_item_id')->references('id')->on('price_list_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_items');
    }
}
