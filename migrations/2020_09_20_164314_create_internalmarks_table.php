<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internalmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('application_id');
            $table->integer('candidate_id');
            $table->integer('subject_id');
            $table->integer('internal');
            $table->integer('active_status')->default('0');
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
        Schema::drop('internalmarks');
    }
}
