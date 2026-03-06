<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEnrolmentfees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolmentfees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('academicyear_id');
            $table->integer('programme_id');
            $table->integer('enrolment_fee');
            $table->integer('late_fee');
            $table->date('ontimepayment_startdate')->nullable();
            $table->date('ontimepayment_enddate')->nullable();
            $table->date('penaltypayment_startdate')->nullable();
            $table->date('penaltypayment_enddate')->nullable();
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
        Schema::drop('enrolmentfees');
    }
}
