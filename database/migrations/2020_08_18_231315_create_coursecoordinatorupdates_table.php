<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatorupdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinatorupdates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institute_id');
            $table->integer('coursecoordinator_id');
            $table->text('update_remarks');
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
        Schema::drop('coursecoordinatorupdates');
    }
}
