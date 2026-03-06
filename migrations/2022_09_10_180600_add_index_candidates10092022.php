<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexCandidates10092022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
            $table->index('approvedprogramme_id');
            $table->index('paymentstatus_id');
            $table->index('status_id');
            $table->index('coursecompleted_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
            $table->dropIndex('approvedprogramme_id');
            $table->dropIndex('paymentstatus_id');
            $table->dropIndex('status_id');
            $table->dropIndex('coursecompleted_status');
        });
    }
}
