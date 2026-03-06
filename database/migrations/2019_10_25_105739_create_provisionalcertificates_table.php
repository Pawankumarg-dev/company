<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionalcertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provisionalcertificates', function (Blueprint $table) {
            $table->increments('id');
            $table->date('received_date');
            $table->integer('candidate_id');
            $table->string('folio_number')->nullable;
            $table->string('status')->nullable;
            $table->integer('publish_status');
            $table->date('print_date');
            $table->date('despatch_date')->nullable;
            $table->string('tracking_number')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provisionalcertificates');
    }
}
