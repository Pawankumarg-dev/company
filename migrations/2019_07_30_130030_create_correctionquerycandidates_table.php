<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectionquerycandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correctionquerycandidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('application_code');
            $table->integer('candidate_id');
            $table->integer('namecorrection_status');
            $table->string('namecorrection_value')->nullable();
            $table->integer('namecorrection_updatestatus');
            $table->integer('fathernamecorrection_status');
            $table->string('fathernamecorrection_value')->nullable();
            $table->integer('fathernamecorrection_updatestatus');
            $table->integer('dobcorrection_status');
            $table->string('dobcorrection_value')->nullable();
            $table->integer('dobcorrection_updatestatus');
            $table->integer('correctionquerystatus_id');
            $table->integer('correctionquery_type');
            $table->string('payment_required')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('proofdocument_required')->nullable();
            $table->string('proofdocument_status')->nullable();
            $table->string('originaldocument_required')->nullable();
            $table->string('originaldocument_status')->nullable();
            $table->date('created_on')->nullable();
            $table->integer('created_by')->nullable();
            $table->date('verified_on')->nullable();
            $table->integer('verified_by')->nullable();
            $table->date('printed_on')->nullable();
            $table->integer('printed_by')->nullable();
            $table->date('completed_on')->nullable();
            $table->integer('despatch_id')->default('0');
            $table->string('tracking_number')->nullable();
            $table->date('despatched_on')->nullable();
            $table->integer('active_status');
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
        Schema::drop('correctionquerycandidates');
    }
}
