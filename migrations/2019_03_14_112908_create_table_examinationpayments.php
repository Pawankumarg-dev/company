<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExaminationpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinationpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examinationfee_id');
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
            $table->string('payment_remark')->nullable();
            $table->integer('amount_paid');
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
        Schema::drop('examinationpayments');
    }
}
