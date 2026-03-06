<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExammarksTable27112022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exammarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('candidate_id');
            $table->bigInteger('subject_id');
            $table->bigInteger('exam_id')->nullable();
            $table->integer('internal_mark')->nullable();
            $table->integer('external_mark')->nullable();
            $table->integer('grace_mark');
            $table->integer('grace_mark_status');
            $table->integer('total_mark')->nullable();
            $table->integer('withheld_status');
            $table->string('pass_status');
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
        Schema::drop('exammarks');
    }
}
