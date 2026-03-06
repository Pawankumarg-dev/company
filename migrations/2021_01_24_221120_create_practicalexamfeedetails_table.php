<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticalexamfeedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practicalexamfeedetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('practicalexam_id');
            $table->integer('approvedprogramme_id');
            $table->integer('candidate_count');
            $table->integer('paper_count');
            $table->text('payment_date');
            $table->text('transaction_number');
            $table->string('amount_paid');
            $table->text('payment_remark')->nullable();
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
        Schema::drop('practicalexamfeedetails');
    }
}
