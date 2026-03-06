<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('institute_id');
			$table->integer('academicyear_id');
			$table->integer('totalamount');
			$table->string('transactionid');
			$table->date('date');
			$table->string('bank');
			$table->string('remark');	
			$table->integer('status_id');	
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
        //
    }
}
