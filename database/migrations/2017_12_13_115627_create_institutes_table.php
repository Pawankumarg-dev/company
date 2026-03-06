<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unique();
			
			$table->string('name');
			$table->string('contact')->nullable();
			$table->string('contactnumber1')->nullable();
			$table->string('contactnumber2')->nullable();
			$table->string('email')->nullable();
			$table->text('address')->nullable();
			$table->string('pincode')->nullable();
			$table->string('enrolmentcode')->nullable();
			
			$table->integer('city_id')->nullable();
			
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->softDeletes();
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
