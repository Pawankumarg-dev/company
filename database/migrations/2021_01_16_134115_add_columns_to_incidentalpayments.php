<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToIncidentalpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidentalpayments', function (Blueprint $table) {
            //
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
        Schema::table('incidentalpayments', function (Blueprint $table) {
            //
        });
    }
}
