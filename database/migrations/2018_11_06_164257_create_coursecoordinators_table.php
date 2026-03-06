<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinators', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('institute_id');
            $table->integer('programme_id');
            $table->string('name');
            $table->string('designation');
            $table->string('qualification');
            $table->string('rci_reg_no');
            $table->string('email');
            $table->string('contactnumber1');
            $table->string('contactnumber2')->nullable();
            $table->float('experience');
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
        //
    }
}
