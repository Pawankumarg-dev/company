<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentalpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidentalpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('incidentalfee_id');
            $table->integer('approvedprogramme_id');
            $table->integer('paymenttype_id');
            $table->integer('paymentbank_id');
            $table->date('payment_date');
            $table->string('payment_number')->nullable();
            $table->integer('status_id')->default('1');
            $table->integer('user_id');
            $table->string('reference_number')->nullable();
            $table->string('filename')->nullable();
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
        Schema::drop('incidentalpayments');
    }
}
