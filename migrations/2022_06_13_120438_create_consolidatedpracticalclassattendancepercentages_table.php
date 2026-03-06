<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidatedpracticalclassattendancepercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidatedpracticalclassattendancepercentages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->decimal('percentage', 5,2);
            $table->enum('exception_status', ['Eligible', 'Not Eligible', 'Not Applied']);
            $table->string('exception_document')->nullable();
            $table->string('percentage_document')->nullable();
            $table->enum('eligibility_status', ['Eligible', 'Not Eligible']);
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
        Schema::drop('consolidatedpracticalclassattendancepercentages');
    }
}
