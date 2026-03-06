<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditStatusToInstitutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutes', function (Blueprint $table) {
            //
            $table->text('address1');
            $table->text('address2');
            $table->text('address3')->nullable();
            $table->text('postoffice');
            $table->text('landmark');
            $table->text('website')->nullable();
            $table->integer('edit_status');
            $table->integer('verify_status');
            $table->string('code');
            $table->string('faxno')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutes', function (Blueprint $table) {
            //
        });
    }
}
