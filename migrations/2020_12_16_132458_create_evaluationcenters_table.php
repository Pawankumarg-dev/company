<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluationcenters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('password')->nullable();
            $table->string('name');
            $table->text('address');
            $table->string('state');
            $table->integer('pincode');
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
        Schema::drop('evaluationcenters');
    }
}
