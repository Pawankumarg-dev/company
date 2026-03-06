<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaslpexamcenterdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baslpexamcenterdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('baslpexam_id');
            $table->integer('baslpexamcenter_id');
            $table->integer('baslpcandidate_id');
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
        Schema::drop('baslpexamcenterdetails');
    }
}
