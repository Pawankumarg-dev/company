<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatorknownlanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinatorknownlanguages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursecoordinator_id');
            $table->integer('language_id');
            $table->integer('read_status');
            $table->integer('write_status');
            $table->integer('speak_status');
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
        Schema::drop('coursecoordinatorknownlanguages');
    }
}
