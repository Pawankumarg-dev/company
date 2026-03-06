<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToApprovedprogrammes extends Migration
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
            $table->integer('current_term')->after('maxintake');
            $table->integer('allotted_count')->after('current_term');
            $table->integer('enrolled_count')->after('allotted_count');
            $table->integer('enrolment_count')->after('enrolled_count');
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
