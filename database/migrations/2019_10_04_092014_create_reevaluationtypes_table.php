<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReevaluationtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reevaluationtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('code');
            $table->timestamps();
        });

        /*
        $values = array([
            array('type' => 'Re-Evaluation', 'code' => 'RE'),
            array('type' => 'Re-Totalling', 'code' => 'RT'),
            array('type' => 'Answer Script Copy', 'code' => 'ASC'),
            array('type' => 'Re-Evaluation + Re-Totalling', 'code' => 'RE + RT'),
            array('type' => 'Re-Evaluation + Answer Script Copy', 'code' => 'RE + ASC'),
            array('type' => 'Re-Totalling + Answer Script Copy', 'code' => 'RT + ASC'),
            array('type' => 'Re-Totalling + Re-Totalling + Answer Script Copy', 'code' => 'RE + RT + ASC'),
        ]);

        DB::table('reevaluationtypes')->insert($values);
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reevaluationtypes');
    }
}
