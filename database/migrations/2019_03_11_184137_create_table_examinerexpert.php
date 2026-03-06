<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExaminerexpert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinerexperts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('password');
            $table->integer('relationtype_id');
            $table->string('relation_name');
            $table->date('dob');
            $table->string('doc_dob');
            $table->string('photo');
            $table->string('signature');
            $table->integer('gender_id');
            $table->string('contactnumber1')->unique()->nullable();
            $table->string('contactnumber2')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('aadhaarcard_no')->unique()->nullable();
            $table->string('address1');
            $table->string('address2');
            $table->string('address3')->nullable();
            $table->integer('city_id');
            $table->string('postoffice');
            $table->string('rci_crrno')->unique()->nullable();
            $table->string('doc_rci_crrno')->nullable();
            $table->string('pancard_no')->unique()->nullable();
            $table->string('doc_pancard');
            $table->string('bankaccount_no')->unique()->nullable();
            $table->string('ifsc_code');
            $table->integer('paymentbank_id');
            $table->string('doc_bankpassbook');
            $table->enum('active_status', ["Yes", "No"]);
            $table->integer('status_id');
            $table->string('user_id');
            $table->enum('debarred_status', ["Yes", "No"]);
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
        Schema::drop('examinerexperts');
    }
}
