<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExaminerexpertroles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinerexpertroles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examinerexpert_id');
            $table->integer('examinerexperttype_id');
            $table->integer('status_id');
            $table->integer('user_id');
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
        Schema::drop('examinerexpertroles');
    }
}
