<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecoordinatorcoursetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinatorcoursetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('council_name');
            $table->string('council_code');
            $table->string('certificate_name');
            $table->string('certificate_code');
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
        Schema::drop('coursecoordinatorcoursetypes');
    }
}
