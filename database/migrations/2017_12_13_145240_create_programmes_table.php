<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function(Blueprint $table)
		{
			$table->increments('id');
			
            $talbe->integer('programmegroup_id');
            
			$table->string('code');
			$table->string('abbreviation');
			$table->string('name');
			$table->integer('numberofterms');
			$table->string('enrolmentcode')->nullable();
			
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
