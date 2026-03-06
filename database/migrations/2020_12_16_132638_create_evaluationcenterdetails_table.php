<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationcenterdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluationcenterdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('evaluationcenter_id');
            $table->integer('externalexamcenter_id');
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
        Schema::drop('evaluationcenterdetails');
    }
}
