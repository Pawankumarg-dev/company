<?php

use Illuminate\Database\Seeder;
use App\Enrolmentbatch;

class EnrolmentbatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $details = array(
            /*array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "31"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "2"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "8"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "28"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "11"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "6"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "30"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "20"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "7"),
            array("academicyear_id" => "9", "active_status" => "1", "programme_id" => "12"),*/
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "31"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "2"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "8"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "28"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "11"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "6"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "30"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "20"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "7"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "12"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "13"),
            array("academicyear_id" => "10", "active_status" => "1", "programme_id" => "32"),

        );

        foreach ($details as $detail) {
            if(!Enrolmentbatch::where("academicyear_id", $detail["academicyear_id"])->where("programme_id", $detail["programme_id"])->exists()) {
                Enrolmentbatch::create([
                    "academicyear_id" => $detail["academicyear_id"],
                    "programme_id" => $detail["programme_id"],
                    "active_status" => $detail["active_status"]
                ]);
            }

            unset($detail);
        }

        unset($details);
    }
}
