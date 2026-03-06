<?php

use Illuminate\Database\Seeder;

class NodalofficerSeeder extends Seeder
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
            array("exam_id" => "15", "name" => "Dr .Ajit  Kumar", "designation" => "Asst. Professor (Spl.Edu)", "organization" => "CRC Ahmedabad", "email1" => "Ajitkumarsingh321@gmail.com", "email2" => "", "contactnumber1" => "9408709288", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr. Jagan Raghunath Mudgade", "designation" => "Asst. Professor (Spl.Edu)", "organization" => "CRC Nagpur", "email1" => "jaganmudgade@gmail.com", "email2" => "", "contactnumber1" => "7588875899", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Dr Sunish T.V.", "designation" => "Asst. Professor (Spl.Edu)", "organization" => "CRC Kozhikode", "email1" => "sunishtv@gmail.com", "email2" => "", "contactnumber1" => "9946809250", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Dr. AD.Paswan", "designation" => "Principal", "organization" => "State Institute for Rehabilitation Training & Research, Haryana", "email1" => "sirtaracademic@gmail.com", "email2" => "", "contactnumber1" => "9050305974", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Dr. Amrita Sahay", "designation" => "Assistant Prof.", "organization" => "NIEPID-RC, Noida", "email1" => "niepidrcnoida@gmail.com", "email2" => "", "contactnumber1" => "9313359139", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr.Rajeev Ranjan", "designation" => "Asst. Professor Speech & Hearing", "organization" => "CRC Lucknow", "email1" => "rajeevcrcap@gmail.com", "email2" => "", "contactnumber1" => "7376501258", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr.T. Mugesh", "designation" => "Officer in charge", "organization" => "NIEPID RC Kolkata", "email1" => "thulasikanthanmugesh@gmail.com", "email2" => "", "contactnumber1" => "8074594163", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr. B.M.Tiwari", "designation" => "Administrative Officer  ", "organization" => "PDUNIPPD, New Delhi", "email1" => "adopduiph@gmail.com", "email2" => "", "contactnumber1" => "9999977696", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr. Ajay Kumar Mahapatra", "designation" => "Lecturer", "organization" => "AYJNIHH RC, Bhubaneswar", "email1" => "raamukyaja@gmail.com", "email2" => "", "contactnumber1" => "9937197357", "contactnumber2" => "8144014057", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr. Kumar Raju", "designation" => "Director", "organization" => "CRC Rajnadgaon", "email1" => "crcrajnandgaon2016@gmail.com", "email2" => "", "contactnumber1" => "9546287158", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Shri.Rajesh Ramachandran", "designation" => "Rehabilitation Officer, Service& Programme", "organization" => "NIEPMD, Chennai", "email1" => "Rajeshrniepmd@gmail.com", "email2" => "", "contactnumber1" => "9444582174", "contactnumber2" => "", "active_status" => "1"),
            array("exam_id" => "15", "name" => "Mr. P. Kamaraj", "designation" => "Lecturer, Spl Edu", "organization" => "NIEPMD, Chennai", "email1" => "Kamaraj_nimh@yahoo.com", "email2" => "", "contactnumber1" => "9840380628", "contactnumber2" => "", "active_status" => "1"),

        );

        foreach ($details as $detail) {
            \App\Nodalofficer::create([
                "exam_id" => $detail["exam_id"],
                "name" => trim($detail["name"]),
                "designation" => trim($detail["designation"]),
                "organization" => trim($detail["organization"]),
                "email1" => trim(strtolower($detail["email1"])),
                "email2" => $detail["email2"] == '' ? null : trim(strtolower($detail["email2"])),
                "contactnumber1" => trim($detail["contactnumber1"]),
                "contactnumber2" => $detail["contactnumber2"] == '' ? null : trim($detail["contactnumber2"]),
                "user_id" => 1778,
                "active_status" => 1,
            ]);
        }
    }
}
