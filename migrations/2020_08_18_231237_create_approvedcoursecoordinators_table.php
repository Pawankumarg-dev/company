<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovedcoursecoordinatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvedcoursecoordinators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursecoordinator_id');
            $table->integer('institute_id');
            $table->integer('programme_id');
            $table->date('joining_date')->nullable();
            $table->date('relieving_date')->nullable();
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
        Schema::drop('approvedcoursecoordinators');
    }
}
