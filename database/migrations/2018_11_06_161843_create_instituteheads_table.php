<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituteheadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituteheads', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('institute_id');
            $table->string('name');
            $table->string('designation');
            $table->string('qualification');
            $table->string('rci_reg_no');
            $table->string('email');
            $table->string('contactnumber1');
            $table->string('contactnumber2')->nullable();
            $table->string('faxno')->nullable();
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
