<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyNameToNewClientRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_client_requests', function (Blueprint $table) {
            $table->string('company_name')->after('phone');
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
            $table->dropColumn('company_name');
        });
    }
}
