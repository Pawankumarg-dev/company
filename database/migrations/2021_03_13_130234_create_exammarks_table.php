<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExammarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exammarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('subject_id');
            $table->integer('internal')->nullable();
            $table->integer('external')->nullable();
            $table->integer('total')->default(0);
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
