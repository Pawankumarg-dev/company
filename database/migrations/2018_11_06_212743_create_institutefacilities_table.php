<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutefacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('institutefacilities', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('institute_id');
            $table->float('buildup_area')->nullable();
            $table->float('landarea')->nullable();
            $table->float('city_distance');
            $table->float('postoffice_distance');
            $table->integer('available_rooms');
            $table->integer('classroom_size');
            $table->enum('biometric_facility', ['Yes', 'No']);
            $table->enum('cctv_facility', ['Yes', 'No']);
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
