<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumnsToEnrolmentpayments extends Migration
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
            $table->enum('fee_exemption', ['No', 'Yes'])->default('No')->after('candidate_id');
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
