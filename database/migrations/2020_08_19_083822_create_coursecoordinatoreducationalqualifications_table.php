<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatoreducationalqualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinatoreducationalqualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursecoordinator_id');
            $table->integer('coursecoordinatorcourse_id');
            $table->string('institute_name');
            $table->integer('state_id');
            $table->integer('completion_year');
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
        Schema::drop('coursecoordinatoreducationalqualifications');
    }
}
