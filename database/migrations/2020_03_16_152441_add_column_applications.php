<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->integer('internalattendance_id')->default('0')->after('language_id');
            $table->string('internal_file')->nullable()->after('internal_lock');
            $table->integer('externalattendance_id')->default('0')->after('grace');
            $table->string('external_file')->nullable()->after('external_lock');
            $table->integer('withheld_status')->nullable()->after('marksheet_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
}
