<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectionqueryoriginaldocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correctionqueryoriginaldocuments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('correctionquerycandidate_id');
            $table->string('inward_number')->nullable();
            $table->date('inward_date')->nullable();
            $table->string('document_type');
            $table->text('document_number');
            $table->text('document_remark');
            $table->integer('verified_by');
            $table->date('verified_on');
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
        Schema::drop('correctionqueryoriginaldocuments');
    }
}
