<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('markcertificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slno');     
            $table->integer('pagenumber')->nullable()->default(null);
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
