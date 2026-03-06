<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassattendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classattendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('classattendancepercentage_id');
            $table->float('theory_percentage')->nullable();
            $table->float('practical_percentage')->nullable();
            $table->float('attendance_percentage')->nullable();
            $table->string('file_attendance_percentage')->nullable();
            $table->enum('exception_percentage', ['Yes', 'No'])->default('No');
            $table->string('file_exception_percentage')->nullable();
            $table->text('exception_percentage_remarks')->nullable();
            $table->integer('status_id')->default('1');
            $table->integer('active_status')->default('1');
            $table->integer('verified_by')->nullable();
            $table->text('verification_marks')->nullable();
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
        Schema::drop('classattendances');
    }
}
