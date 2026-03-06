<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNberstaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nberstaffs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->integer('title_id');
            $table->string('name');
            $table->string('designation');
            $table->integer('gender_id');
            $table->date('dob');
            $table->string('mobile_number');
            $table->string('email_address');
            $table->integer('active_status');
            $table->integer('admin');
            $table->softDeletes();
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
        Schema::drop('nberstaffs');
    }
}
