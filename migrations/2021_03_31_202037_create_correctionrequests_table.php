<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectionrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correctionrequests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number')->unique();
            $table->integer('candidate_id');
            $table->text('subject');
            $table->string('status');
            $table->integer('active_status')->default(1);
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
        Schema::drop('correctionrequests');
    }
}
