<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituteinformationupdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituteinformationupdates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institute_id');
            $table->integer('user_id');
            $table->text('update_remarks');
            $table->integer('active_status')->default('0');
            $table->integer('verified_on')->nullable();
            $table->date('verified_by')->nullable();
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
        Schema::drop('instituteinformationupdates');
    }
}
