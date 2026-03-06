<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedprogrammeIdToWithhelds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withhelds', function (Blueprint $table) {
            $table->integer('approvedprogramme_id')->after('exam_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withhelds', function (Blueprint $table) {
            //
        });
    }
}
