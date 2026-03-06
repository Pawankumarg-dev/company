<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableColumnApprovedprogramme30082022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approvedprogrammes', function (Blueprint $table) {
            //
            $table->integer('verificationpending_count')->after('enrolment_count')->unsigned();
            $table->integer('approved_count')->after('verificationpending_count')->unsigned();
            $table->integer('pending_count')->after('approved_count')->unsigned();
            $table->integer('rejected_count')->after('pending_count')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approvedprogrammes', function (Blueprint $table) {
            //
        });
    }
}
