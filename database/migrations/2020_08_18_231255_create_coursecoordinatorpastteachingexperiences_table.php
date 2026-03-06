<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatorpastteachingexperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinatorpastteachingexperiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursecoordinator_id');
            $table->string('designation');
            $table->string('institute_name');
            $table->integer('state_id');
            $table->date('joining_date');
            $table->date('relieving_date');
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
        Schema::drop('coursecoordinatorpastteachingexperiences');
    }
}
