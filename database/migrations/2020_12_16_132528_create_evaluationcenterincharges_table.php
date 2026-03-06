<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationcenterinchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluationcenterincharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('evaluationcenter_id');
            $table->string('code');
            $table->string('name');
            $table->string('designation');
            $table->string('contactnumber');
            $table->string('email');
            $table->integer('active_status');
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
        Schema::drop('evaluationcenterincharges');
    }
}
