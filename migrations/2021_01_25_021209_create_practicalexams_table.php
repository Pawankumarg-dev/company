<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticalexamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practicalexams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('institute_id');
            $table->string('common_code');
            $table->date('exam_date');
            $table->date('exam_date2')->nullable();
            $table->string('coursecoordinator_name');
            $table->bigInteger('coursecoordinator_contactnumber');
            $table->bigInteger('coursecoordinator_whatsappnumber');
            $table->string('coursecoordinator_email');
            $table->integer('status_id')->default('5');
            $table->integer('to_instituteemail');
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
        Schema::drop('practicalexams');
    }
}
