<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaslpexamcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baslpexamcenters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('abbreviation')->nullable();
            $table->string('address')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('landmark')->nullable();
            $table->string('contactnumber1')->nullable();
            $table->string('contactnumber2')->nullable();
            $table->string('email')->nullable();
            $table->integer('sortorder')->nullable();
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
        Schema::drop('baslpexamcenters');
    }
}
