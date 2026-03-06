<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add1ColumnsExternalexamcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('externalexamcenters', function (Blueprint $table) {
            //
            $table->integer('active_status')->after('email2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('externalexamcenters', function (Blueprint $table) {
            //
        });
    }
}
