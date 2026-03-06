<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExaminerexpertknownlanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinerexpertknownlanguages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examinerexpert_id');
            $table->integer('language_id');
            $table->integer('speak_status');
            $table->integer('read_status');
            $table->integer('write_status');
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
        Schema::drop('examinerexpertknownlanguages');
    }
}
