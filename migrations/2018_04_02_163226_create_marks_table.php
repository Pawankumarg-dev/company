<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('internal');            
            $table->string('external');
            $table->integer('grace');
            $table->integer('result_id');
            $table->integer('application_id');
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
