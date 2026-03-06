<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodalofficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodalofficers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->string('name');
            $table->string('designation');
            $table->text('organization');
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->string('contactnumber1');
            $table->string('contactnumber2')->nullable();
            $table->integer('user_id');
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
        Schema::drop('nodalofficers');
    }
}
