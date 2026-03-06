<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReevaluationapplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reevaluationapplications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('application_number');
            $table->integer('exam_id');
            $table->integer('application_id');
            $table->integer('mark_id');
            $table->integer('candidate_id');
            $table->integer('actual_mark');
            $table->string('actual_result');
            $table->integer('reevaluated_mark');
            $table->string('reevaluated_result');
            $table->string('reevaluated_remark');
            $table->integer('publish_status');
            $table->date('result_date');
            $table->integer('mark_entered_by');
            $table->string('payment_required')->default('Yes');
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
        Schema::drop('reevaluationapplications');
    }
}
