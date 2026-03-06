<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despatches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_name');
            $table->string('product_name');
            $table->text('tracking_url');
            $table->string('active_status');
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
        Schema::drop('despatches');
    }
}
