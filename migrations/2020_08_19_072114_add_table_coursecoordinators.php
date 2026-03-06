<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableCoursecoordinators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecoordinators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->integer('title_id');
            $table->string('name');
            $table->integer('salutation_id');
            $table->integer('relationtype_id');
            $table->string('relationname');
            $table->date('dob');
            $table->integer('gender_id');
            $table->enum('disability_status', ['Yes', 'No']);
            $table->string('disability_type')->nullable();
            $table->string('disabilitycertificate_number')->nullable();
            $table->string('aadhaarcard_number')->unique();
            $table->string('mobile_number1')->unique();
            $table->string('mobile_number2')->nullable();
            $table->string('whatsapp_number')->unique();
            $table->string('email_address1')->unique();
            $table->string('email_address2')->nullable();
            $table->text('address');
            $table->integer('city_id');
            $table->integer('pincode');
            $table->integer('coursecoordinatorcoursetype_id');
            $table->string('registration_number');
            $table->date('registration_year');
            $table->date('expiration_year');
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
        Schema::drop('coursecoordinators');
    }
}
