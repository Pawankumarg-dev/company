<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadquestionpaperupdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloadquestionpaperupdates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('externalexamcenter_id');
            $table->integer('examtimetable_id');
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
        Schema::drop('downloadquestionpaperupdates');
    }
}
