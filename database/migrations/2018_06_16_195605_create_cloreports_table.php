<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloreports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clo_id');
            $table->integer('cloreportfile_id');  
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
