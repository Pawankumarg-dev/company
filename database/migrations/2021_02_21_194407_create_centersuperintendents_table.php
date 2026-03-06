<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentersuperintendentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centersuperintendents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('nodalofficer_id');
            $table->integer('externalexamcenter_id');
            $table->string('type');
            $table->string('code');
            $table->string('password');
            $table->integer('title_id');
            $table->string('name');
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->string('contactnumber1');
            $table->string('contactnumber2')->nullable();
            $table->integer('user_id');
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
        Schema::drop('centersuperintendents');
    }
}
