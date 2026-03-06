<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            //
            $table->string('internalattendance_id')->after('subject_id');
            $table->integer('internal_file')->after('internal_lock')->nullable();
            $table->string('externalattendance_id')->after('internal_file');
            $table->integer('external_file')->after('external_lock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marks', function (Blueprint $table) {
            //
        });
    }
}
