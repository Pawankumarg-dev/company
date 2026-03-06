<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('employee_number')->nullable();
            $table->string('name');
            $table->string('nberdesignation_id');
            $table->string('nberleveltype_id');
            $table->enum('gender', ['Male', 'Female', 'Third Gender'])->default('Male');
            $table->date('dob');
            $table->date('doj');
            $table->integer('bloodgroup_id');
            $table->string('contactnumber1');
            $table->string('contactnumber2')->nullable();
            $table->string('email')->nullable();
            $table->enum('active_status', ['Active', 'Suspend'])->default('Active');
            $table->string('photo')->nullable();
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
        Schema::drop('nbers');
    }
}
