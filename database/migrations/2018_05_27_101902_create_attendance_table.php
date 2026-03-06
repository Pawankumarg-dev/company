<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exam_id');            
            $table->string('candidate_id');
            $table->float('attendance_t');
            $table->string('document_t');
            $table->float('attendance_p');
            $table->string('document_p');
            $table->integer('exemption');            
            $table->string('document_exemption')->default(null)->nullable();
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
