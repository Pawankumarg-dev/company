<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExambatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exambatches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('programme_id');
            $table->integer('academicyear_id');
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
        Schema::drop('exambatches');
    }
}
