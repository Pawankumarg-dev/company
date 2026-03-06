<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatorcoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinatorcourses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursecoordinatorcoursetype_id');
            $table->string('course_mode');
            $table->string('course_name');
            $table->string('course_code');
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
        Schema::drop('coursecoordinatorcourses');
    }
}
