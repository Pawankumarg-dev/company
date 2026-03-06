<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReevaluationpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reevaluationpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reevaluationapplication_id');
            $table->integer('reevaluationfee_id');
            $table->date('payment_date');
            $table->integer('paymenttype_id');
            $table->integer('paymentbank_id');
            $table->string('payment_type'); //Single or Bulk
            $table->string('payment_number');
            $table->integer('amount_paid');
            $table->string('payment_status');
            $table->string('receipt_number')->nullable();
            $table->date('receipt_date')->nullable();
            $table->integer('verified_by')->nullable();
            $table->date('verified_date')->nullable();
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
        Schema::drop('reevaluationpayments');
    }
}
