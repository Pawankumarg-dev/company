<?php

use Illuminate\Database\Seeder;
use App\Evaluationcenter;
use App\Evaluationcenterincharge;

class EvaluationcenterinchargeSeeder extends Seeder
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
            array("evaluationcentercode" => "EVCH02", "code" => "", "name" => "Dr.Kumar Raju", "designation" => "Director", "contactnumber" => "9546287158", "email" => "crcrajnandgaon@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVDL04", "code" => "", "name" => "Dr.HemantSingh", "designation" => "Principal", "contactnumber" => "7696569224", "email" => "hemantkeshwal@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVGJ05", "code" => "", "name" => "Dr.Ajit Kumar Singh", "designation" => "Asst.Professsor Special Education", "contactnumber" => "9408709288", "email" => "ajitkumarsingh321@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVHY06", "code" => "", "name" => "Dr.A.D.Paswan", "designation" => "Director ", "contactnumber" => "9050305974", "email" => "sirtaracademic@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVKL10", "code" => "", "name" => "Dr.Sunish T V", "designation" => "Asst.Professsor Special Education", "contactnumber" => "9946809250", "email" => "sunishtv@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVMH13", "code" => "", "name" => "Mr.Jagan Mudgade", "designation" => "Asst.Professsor Special Education", "contactnumber" => "7588875899", "email" => "jaganmudgade@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVTN15", "code" => "", "name" => "Mrs.Kavitha Anil Kumar", "designation" => "ADCE, NBER", "contactnumber" => "9444086060", "email" => "kavitha.nber@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVUP17", "code" => "", "name" => "Dr.Amirta Sahay", "designation" => "Asst.Professsor Special Education", "contactnumber" => "9313359139", "email" => "upz1nodalexam@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVUP19", "code" => "", "name" => "Mr.Ravi Kumar", "designation" => "Director ", "contactnumber" => "9798156456", "email" => "crcgkpr@gmail.com / ravislp9@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVOR22", "code" => "", "name" => "Dr.Premanand Mishra", "designation" => "Director", "contactnumber" => "9437316575 / 8637222216", "email" => "drpremanandamishra@gmail.com", "exam_id" => "14", "active_status" => "1"),
            array("evaluationcentercode" => "EVUP23", "code" => "", "name" => "Dr.Ramesh Kumar Pandey", "designation" => "Director", "contactnumber" => "8051292785 / 9873765373", "email" => "crclko@rediffmail.com / rameshkpandey85@gmail.com", "exam_id" => "14", "active_status" => "1"),

        );

        foreach ($details as $d) {
            $evaluationcenterid = Evaluationcenter::where('code', $d["evaluationcentercode"])->first()->id;

            if(!is_null($evaluationcenterid)) {

                $incharge = Evaluationcenterincharge::where("exam_id", $d["exam_id"])
                    ->where("evaluationcenter_id", $evaluationcenterid)
                    ->first();

                if(is_null($incharge)) {
                    Evaluationcenterincharge::create([
                        "exam_id" => $d["exam_id"],
                        "evaluationcenter_id" => $evaluationcenterid,
                        "code" => $d["code"],
                        "name" => $d["name"],
                        "designation" => $d["designation"],
                        "contactnumber" => $d["contactnumber"],
                        "email" => $d["email"],
                        "active_status" => $d["active_status"],
                    ]);
                }
                else {
                    $incharge->update([
                        "exam_id" => $d["exam_id"],
                        "evaluationcenter_id" => $evaluationcenterid,
                        "code" => $d["code"],
                        "name" => $d["name"],
                        "designation" => $d["designation"],
                        "contactnumber" => $d["contactnumber"],
                        "email" => $d["email"],
                        "active_status" => $d["active_status"],
                    ]);
                }

            }
        }
    }
}
