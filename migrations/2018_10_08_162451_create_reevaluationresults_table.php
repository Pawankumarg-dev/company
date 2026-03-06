<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReevaluationresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('reevaluationresults', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reevaluation_id');
            $table->integer('mark_id');
            $table->integer('application_id');
            $table->integer('candidate_id');
            $table->integer('subject_id');
            $table->string('actual_external_mark');
            $table->string('reevaluated_external_mark');
            $table->string('reevaluation_remarks');
            $table->integer('publish_status');
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
        //
    }
}
