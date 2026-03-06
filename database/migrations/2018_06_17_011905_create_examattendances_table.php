<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamattendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('examattendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examattendancefile_id');  
            $table->integer('examtimetable_id');
            $table->string('file');
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
