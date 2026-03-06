<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            //
            $table->integer('exam_application')->after('academicyear_id');
            $table->integer('institute_markentry')->after('exam_application')->default('0');
            $table->integer('nber_markentry')->after('exam_application')->default('0');
            $table->integer('attendance_upload')->after('nber_markentry');
            $table->integer('hallticket_download')->after('attendance_upload');
            $table->integer('questionpaper_download')->after('hallticket_download');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            //
        });
    }
}
