<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableNewClientRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_client_requests', function (Blueprint $table) {
            $table->string('address')->after('phone');

            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_client_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->dropColumn('address');
        });
    }
}
