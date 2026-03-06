<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamtimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examtimetables', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('startdate');            
            $table->datetime('enddate');            
            $table->integer('subject_id');
            $table->integer('exam_id');
            $table->string('questionpaper');
            $table->string('password')->nullable();
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
