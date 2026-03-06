<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsProvisionalcertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provisionalcertificates', function (Blueprint $table) {
            //
            $table->integer('exam_id')->after('received_date');
            $table->integer('active_status')->after('publish_status')->default('1');
            $table->string('authorised_sign')->after('folio_number');
            $table->integer('download_count')->after('authorised_sign')->default('0');
            //$table->dropColumn(['status', 'received_date', 'despatch_date', 'tracking_number', 'print_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provisionalcertificates', function (Blueprint $table) {
            //
        });
    }
}
