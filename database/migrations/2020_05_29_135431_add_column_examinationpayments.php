<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExaminationpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examinationpayments', function (Blueprint $table) {
            $table->integer('institute_id')->unsigned()->after('examinationfee_id');
            $table->string('verify_remarks')->nullable()->after('amount_paid');
            $table->date('verified_on')->nullable()->after('verify_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examinationpayments', function (Blueprint $table) {
            //
        });
    }
}
