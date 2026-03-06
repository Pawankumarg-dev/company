<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoexamattendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demoexamattendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('enrolmentno');
            $table->string('name');
            $table->integer('language_id');
            $table->integer('externalattendance_id');
            $table->string('filename')->nullable();
            $table->string('answersheet_serialnumber')->nullable();
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
        Schema::drop('demoexamattendances');
    }
}
