<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExammarksheetdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exammarksheetdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('programme_id');
            $table->integer('academicyear_id');
            $table->integer('term');
            $table->integer('examtype_id');
            $table->date('result_date')->nullable();
            $table->integer('publish_status')->default('1');
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
        Schema::drop('exammarksheetdetails');
    }
}
