<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            //
            $table->integer('internalresult_id')->after('internal');
            $table->integer('internal_lock')->after('internalresult_id');
            $table->integer('externalresult_id')->after('external');
            $table->integer('external_lock')->after('externalresult_id');
            $table->integer('total_mark')->after('grace');
            $table->text('marksheet_number')->after('result_id');
            $table->integer('active_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marks', function (Blueprint $table) {
            //
        });
    }
}
