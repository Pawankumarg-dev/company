<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMalpracticefilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('malpracticefiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('malpractice_id');
            $table->text('description');
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
