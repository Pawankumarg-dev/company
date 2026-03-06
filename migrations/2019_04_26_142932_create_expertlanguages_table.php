<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertlanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertlanguages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id');
            $table->integer('language_id');
            $table->enum('speak_status', ["Yes", "No"])->default("No");
            $table->enum('read_status', ["Yes", "No"])->default("No");
            $table->enum('write_status', ["Yes", "No"])->default("No");
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
        Schema::drop('expertlanguages');
    }
}
