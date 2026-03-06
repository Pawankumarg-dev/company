<?php

use Illuminate\Database\Seeder;
use App\Enrolmentfee;
use App\Programme;
use App\Academicyear;

class EnrolmentfeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $enrolmentfee = array(
            /*array("academicyear_id" => "9", "programme_id" => "31", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "2", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "8", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "28", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "11", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "6", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "30", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "20", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "7", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),
            array("academicyear_id" => "9", "programme_id" => "12", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "28-07-2022", "ontimepayment_enddate" => "28-09-2022"),*/
            array("academicyear_id" => "10", "programme_id" => "31", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "2", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "8", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "28", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "11", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "6", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "30", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "20", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "7", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "12", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "13", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            array("academicyear_id" => "10", "programme_id" => "32", "enrolment_fee" => "500", "late_fee" => "0", "ontimepayment_startdate" => "06-02-2023", "ontimepayment_enddate" => "28-02-2023"),
            );

        foreach ($enrolmentfee as $ef) {
            $enf = Enrolmentfee::where('academicyear_id', $ef["academicyear_id"])->where('programme_id',  $ef["programme_id"])->first();

            if(is_null($enf)) {
                Enrolmentfee::create([
                    "programme_id" => $ef["programme_id"],
                    "academicyear_id" => $ef["academicyear_id"],
                    "enrolment_fee" => $ef["enrolment_fee"],
                    "late_fee" => $ef["late_fee"],
                    "ontimepayment_startdate" =>  date("Y-m-d", strtotime($ef["ontimepayment_startdate"])),
                    "ontimepayment_enddate" => date("Y-m-d", strtotime($ef["ontimepayment_enddate"])),
                    //"penaltypayment_startdate" => date("Y-m-d", strtotime($ef["penaltypayment_startdate"])),
                    //"penaltypayment_enddate" => date("Y-m-d", strtotime($ef["penaltypayment_enddate"]))
                ]);
            }
        }
    }
}
