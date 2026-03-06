<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('candidates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('approvedprogramme_id');
			
			$table->string('enrolmentno')->nullable();
			$table->string('name');
			$table->string('fathername');
			$table->string('mothername');
			$table->decimal('percentage');
			$table->date('dob');
			$table->text('address');
			$table->string('pincode');
			$table->string('contactnumber');
			$table->date('mobile_otp_verified_on')->nullable()->default(null);
			$table->string('email')->unique();
			$table->date('email_otp_verified_on')->nullable()->default(null);
			$table->string('aadhaar');
			$table->string('photo');
			$table->string('doc_mark');
			$table->string('doc_dob');
			$table->string('doc_disability')->nullable();
			$table->string('doc_community')->nullable();
			$table->string('doc_percentage_exception')->nullable();
			
			$table->integer('community_id');
			$table->integer('disability_id');
			$table->integer('gender_id');
			$table->integer('city_id');
			$table->integer('status_id')->default(1);
			$table->integer('salutation_id');
			
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
