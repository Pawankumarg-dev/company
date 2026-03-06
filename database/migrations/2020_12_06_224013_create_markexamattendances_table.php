<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkexamattendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markexamattendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('externalexamcenter_id');
            $table->integer('examtimetable_id');
            $table->integer('approvedprogrammeid');
            $table->integer('application_id');
            $table->integer('language_id');
            $table->integer('externalattendance_id');
            $table->string('filename')->nullable();
            $table->string('answersheet_serialnumber')->nullable();
            $table->string('dummy_number')->nullable();
            $table->string('bundle_number')->nullable();
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
        Schema::drop('markexamattendances');
    }
}
