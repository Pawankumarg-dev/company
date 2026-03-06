<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Candidatefiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('candidatefiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('candidate_id');
			$table->string('filename');
			$table->string('description');			
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
