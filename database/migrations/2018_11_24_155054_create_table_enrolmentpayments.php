<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEnrolmentpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolmentpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enrolmentfee_id');
            $table->integer('candidate_id');
            $table->enum('latefee_remark', ['No', 'Yes'])->default('No');
            $table->integer('paymenttype_id');
            $table->integer('paymentbank_id');
            $table->date('payment_date');
            $table->string('payment_number');
            $table->integer('status_id')->default('1');
            $table->integer('user_id');
            $table->string('reference_number');
            $table->string('filename');
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
        Schema::drop('enrolmentpayments');
    }
}
