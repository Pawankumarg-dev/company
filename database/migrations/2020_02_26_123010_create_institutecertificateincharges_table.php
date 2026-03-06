<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutecertificateinchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutecertificateincharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institute_id');
            $table->string('name');
            $table->string('designation');
            $table->string('contactnumber1');
            $table->string('contactnumber2');
            $table->string('email');
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
        Schema::drop('institutecertificateincharges');
    }
}
