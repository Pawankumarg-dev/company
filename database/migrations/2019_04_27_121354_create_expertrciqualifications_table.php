<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertrciqualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertrciqualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id');
            $table->string('rcicourse_id');
            $table->string('institute_name');
            $table->integer('state_id');
            $table->string('exambody_name')->nullable();
            $table->string('course_complete_year');
            $table->string('certificate_no')->nullable();
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
        Schema::drop('expertrciqualifications');
    }
}
