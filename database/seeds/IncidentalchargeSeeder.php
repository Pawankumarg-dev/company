<?php

use Illuminate\Database\Seeder;
use App\Incidentalfee;

class IncidentalchargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $incidentalcharges = array(
            /*array("academicyear_id" => "9", "programme_id" => "31", "term" => "1", "fee" => "8000"),
            array("academicyear_id" => "9", "programme_id" => "31", "term" => "2", "fee" => "8000"),
            array("academicyear_id" => "9", "programme_id" => "2", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "2", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "8", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "8", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "20", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "20", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "11", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "11", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "28", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "30", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "7", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "12", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "9", "programme_id" => "6", "term" => "1", "fee" => "4000"),*/
            array("academicyear_id" => "10", "programme_id" => "31", "term" => "1", "fee" => "8000"),
            array("academicyear_id" => "10", "programme_id" => "31", "term" => "2", "fee" => "8000"),
            array("academicyear_id" => "10", "programme_id" => "2", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "2", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "8", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "8", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "20", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "20", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "11", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "11", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "32", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "32", "term" => "2", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "28", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "30", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "7", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "12", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "6", "term" => "1", "fee" => "4000"),
            array("academicyear_id" => "10", "programme_id" => "13", "term" => "1", "fee" => "4000"),
        );

        foreach ($incidentalcharges as $ic) {
            if(Incidentalfee::where('academicyear_id', $ic['academicyear_id'])->where('programme_id', $ic['programme_id'])->where('term', $ic['term'])->count() == 0) {
                Incidentalfee::create([
                    'academicyear_id' => $ic['academicyear_id'],
                    'programme_id' => $ic['programme_id'],
                    'term' => $ic['term'],
                    'fee' => $ic['fee']
                ]);
            }
        }
    }
}
