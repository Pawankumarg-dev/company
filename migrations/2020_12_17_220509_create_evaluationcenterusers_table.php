<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationcenterusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluationcenterusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('email');
            $table->string('password');
            $table->integer('active_status');
            $table->rememberToken();
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
        Schema::drop('evaluationcenterusers');
    }
}
