<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectionquerypaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correctionquerypayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('correctionquerycandidate_id');
            $table->string('inward_number')->nullable();
            $table->date('inward_date')->nullable();
            $table->integer('paymenttype_id')->nullable();
            $table->integer('paymentbank_id')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_number')->nullable();
            $table->text('payment_remark')->nullable();
            $table->string('amount_paid');
            $table->integer('verified_by');
            $table->date('verified_on');
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
        Schema::drop('correctionquerypayments');
    }
}
