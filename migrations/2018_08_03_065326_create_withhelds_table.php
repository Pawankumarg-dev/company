<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithheldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withhelds',function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('approvedprogramme_id');
            $table->integer('candidate_id');
            $table->integer('status');
            $table->text('comments')->nullable();
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
