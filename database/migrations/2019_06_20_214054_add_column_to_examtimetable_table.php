<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToExamtimetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examtimetables', function (Blueprint $table) {
            //
            $table->date('examdate')->after('id')->nullable();
            $table->time('starttime')->after('examdate')->nullable();
            $table->time('endtime')->after('starttime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examtimetables', function (Blueprint $table) {
            //
        });
    }
}
