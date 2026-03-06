<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExamlinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('examlinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('enrolment_status');
            $table->integer('examapplication_status');
            $table->integer('institute_mark_entry_status');
            $table->integer('nber_mark_entry_status');
            $table->integer('upload_attendance_status');
            $table->integer('download_hallticket_status');
            $table->integer('download_questionpaper_status');
            $table->integer('publish_mark_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
