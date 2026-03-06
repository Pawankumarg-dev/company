<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalexamcenterdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('externalexamcenterdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id')->default('0');
            $table->integer('institute_id')->default('0');
            $table->integer('externalexamcenter_id')->default('0');
            $table->integer('expert_id')->default('0');
            $table->integer('active_status')->default('1');
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
        Schema::drop('externalexamcenterdetails');
    }
}
