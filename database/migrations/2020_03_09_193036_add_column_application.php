<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnApplication extends Migration
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
            $table->string('internal')->after('language_id');
            $table->integer('internalresult_id')->after('internal');
            $table->integer('internal_lock')->after('internalresult_id');
            $table->integer('grace')->after('internal_lock');
            $table->string('external')->after('grace');
            $table->integer('externalresult_id')->after('external');
            $table->integer('external_lock')->after('externalresult_id');
            $table->integer('total')->after('external_lock');
            $table->integer('result_id')->after('total');
            $table->integer('active_status')->after('result_id');
            $table->date('publish_date')->after('publish_status')->nullable();
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
