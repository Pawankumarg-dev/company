<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExaminerpools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('examinerpools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('relationtype_id');
            $table->string('relation_name');
            $table->date('dob');
            $table->integer('gender_id');
            $table->string('contactnumber1');
            $table->string('contactnumber2')->nullable();
            $table->string('email');
            $table->string('aadhaarcard_no')->nullable();
            $table->string('address1');
            $table->string('address2');
            $table->string('address3')->nullable();
            $table->integer('city_id');
            $table->string('postoffice');
            $table->string('rci_crrno')->nullable();
            $table->string('doc_rci_crrno')->nullable();
            $table->string('pancard_no');
            $table->string('bankaccount_no');
            $table->string('ifsc_code');
            $table->integer('paymentbank_id');
            $table->string('doc_bankpassbook');
            $table->string('code')->nullable(rc);
            $table->string('active_status');
            $table->integer('status');
            $table->string('verify_by');
            $table->enum('debarred_status', ["Yes", "No"]);
            $table->timestamps();

        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('examinerpools');
    }
}
