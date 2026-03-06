<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReevaluationfeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reevaluationfees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('reevaluation_fee');
            $table->integer('retotalling_fee');
            $table->integer('answerscriptcopy_fee');
            $table->integer('active_status')->default('1');
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
        Schema::drop('reevaluationfees');
    }
}
