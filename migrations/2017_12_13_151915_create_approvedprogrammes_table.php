<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovedprogrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvedprogrammes', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('institute_id');
			$table->integer('programme_id');
			$table->integer('academicyear_id');
			$table->integer('status_id')->default(1);
			$table->string('filename');
			$table->integer('maxintake');
			
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
