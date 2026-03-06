<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExaminerexpertexperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinerexpertexperiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examinerexpert_id');
            $table->string('employer');
            $table->string('designation');
            $table->enum('is_present', ["Yes", "No"])->default("Yes");
            $table->date('from_date');
            $table->date('to_date');
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
        Schema::drop('examinerexpertexperiences');
    }
}
