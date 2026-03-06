<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumnsToEnrolmentfees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrolmentfees', function (Blueprint $table) {
            //
            $table->integer('superlate_fee')->after('late_fee')->nullable();
            $table->date('superlatepayment_startdate')->after('penaltypayment_enddate')->nullable();
            $table->date('superlatepayment_enddate')->after('superlatepayment_startdate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolmentfees', function (Blueprint $table) {
            //
        });
    }
}
