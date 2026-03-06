<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsApplications extends Migration
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
            $table->integer('examtype_id')->after('exam_id');
            $table->string('dummy_number')->after('language_id')->nullable();
            $table->string('bundle_number')->after('dummy_number')->nullable();
            $table->integer('exammarksheetdetail_id')->after('bundle_number')->default('0');
            $table->string('marksheet_number')->after('exammarksheetdetail_id');
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
