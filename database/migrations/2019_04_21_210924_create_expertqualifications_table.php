<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertqualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertqualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id');
            $table->string('course_type');
            $table->string('course_name');
            $table->enum('course_mode', ["Regular", "Distance"])->default("Regular");
            $table->string('institute_name');
            $table->integer('state_id');
            $table->string('exambody_name');
            $table->string('course_complete_year');
            $table->string('certificate_no');
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
        Schema::drop('expertqualifications');
    }
}
