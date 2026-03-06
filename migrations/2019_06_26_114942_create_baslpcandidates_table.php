<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaslpcandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baslpcandidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('roll_no')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->integer('relationtype_id')->nullable();
            $table->string('relation_name')->nullable();
            $table->date('dob')->nullable();
            $table->integer('gender_id')->nullable();
            $table->integer('community_id')->nullable();
            $table->string('address')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('contactnumber1')->nullable();
            $table->string('contactnumber2')->nullable();
            $table->string('email')->nullable();
            $table->string('file_photo')->nullable();
            $table->string('application_year')->nullable();
            $table->integer('active_status')->nullable();
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
        Schema::drop('baslpcandidates');
    }
}
