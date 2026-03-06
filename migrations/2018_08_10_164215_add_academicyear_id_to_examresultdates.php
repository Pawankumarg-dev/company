<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcademicyearIdToExamresultdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examresultdates', function (Blueprint $table) {
            $table->integer('academicyear_id')->after('programme_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examresultdates', function (Blueprint $table) {
            //
        });
    }
}
