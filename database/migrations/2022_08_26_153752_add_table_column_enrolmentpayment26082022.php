<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableColumnEnrolmentpayment26082022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrolmentpayments', function (Blueprint $table) {
            //
            $table->integer('order_id')->after('candidate_id');
            $table->text('payment_mode')->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolmentpayments', function (Blueprint $table) {
            //
        });
    }
}
