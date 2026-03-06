<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaslpexamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baslpexams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->time('starttime')->nullable();
            $table->time('endtime')->nullable();
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
        Schema::drop('baslpexams');
    }
}
