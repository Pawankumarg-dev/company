<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCandidateexamresultdate17082022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidateexamresultdates', function (Blueprint $table) {
            //
            $table->softDeletes();
            $table->integer('underreview_status')->after('candidate_id');
            $table->text('underreview_remarks')->nullable()->after('underreview_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidateexamresultdates', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });
    }
}
