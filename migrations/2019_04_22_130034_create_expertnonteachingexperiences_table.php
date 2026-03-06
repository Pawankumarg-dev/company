<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertnonteachingexperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertnonteachingexperiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id');
            $table->string('organization_name');
            $table->text('organization_address');
            $table->integer('state_id');
            $table->string('organization_category');
            $table->enum('is_presently_working', ["Yes", "No"])->default("No");
            $table->string('designation');
            $table->string('department');
            $table->string('from_date');
            $table->string('to_date');
            $table->float('experience');
            $table->string('file_experience')->nullable();
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
        Schema::drop('expertnonteachingexperiences');
    }
}
