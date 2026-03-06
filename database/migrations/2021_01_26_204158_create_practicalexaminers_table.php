<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticalexaminersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practicalexaminers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('practicalexam_id');
            $table->integer('practicalexaminertype_id');
            $table->integer('title_id');
            $table->string('name');
            $table->integer('age');
            $table->integer('gender_id');
            $table->string('qualification');
            $table->string('crrnumber');
            $table->integer('experience');
            $table->text('address');
            $table->integer('city_id');
            $table->integer('pincode');
            $table->bigInteger('contactnumber');
            $table->bigInteger('whatsappnumber');
            $table->string('email');
            $table->integer('select_status');
            $table->integer('edit_status');
            $table->integer('active_status');
            $table->date('selected_date')->nullable();
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
        Schema::drop('practicalexaminers');
    }
}
