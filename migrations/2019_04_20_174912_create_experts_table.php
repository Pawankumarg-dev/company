<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('password');
            $table->string('title');
            $table->string('name');
            $table->integer('relationtype_id');
            $table->string('relation_name');
            $table->date('dob');
            $table->integer('gender_id');
            $table->enum('has_disability', ["Yes", "No"])->default("No");
            $table->string('contactnumber1')->unique();
            $table->string('contactnumber2')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('aadhaarcard_no')->unique()->nullable();
            $table->enum('debarred_status', ["Yes", "No"])->default("No");
            $table->enum('active_status', ["Yes", "No"])->default("Yes");
            $table->enum('has_crr_no', ["Yes", "No"])->default("No");
            $table->string('crr_no')->unique()->nullable();
            $table->string('crr_no_issued_year')->nullable();
            $table->string('crr_no_expiry_year')->nullable();
            $table->string('file_crr_no')->nullable();
            $table->string('door_no')->nullable();
            $table->string('building_name')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('street3')->nullable();
            $table->string('postoffice')->nullable();
            $table->string('talukoffice')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('pincode')->nullable();
            $table->string('landmark')->nullable();
            $table->string('pancard_no')->unique()->nullable();
            $table->string('bank_account_no')->unique()->nullable();
            $table->string('bank_ifsc_code')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->integer('paymentbank_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('file_bank_passbook')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('file_photo')->nullable();
            $table->string('application_no')->unique()->nullable();
            $table->enum('application_status', ["Under Scrutiny", "Accepted", "Rejected"])->default("Under Scrutiny");
            $table->integer('stages_passed');
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
        Schema::drop('experts');
    }
}
