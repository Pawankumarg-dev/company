<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassattendancepercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classattendancepercentages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programme_id');
            $table->integer('academicyear_id');
            $table->integer('term');
            $table->integer('minimum_theory_percentage')->nullable();
            $table->integer('minimum_practical_percentage')->nullable();
            $table->integer('exception_percentage')->nullable();
            $table->integer('scheme_of_examination')->nullable();
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
        Schema::drop('classattendancepercentages');
    }
}
