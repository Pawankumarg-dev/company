<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEnrolmentpayments extends Migration
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
            $table->string('payment_remark')->nullable()->after('filename');
            $table->integer('amount_paid')->after('payment_remark');
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
