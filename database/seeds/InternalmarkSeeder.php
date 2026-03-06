<?php

use Illuminate\Database\Seeder;

class InternalmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array("exam_id" => "13", "application_id" => "449761", "internal" => "40"),
        );

        foreach($data as $d) {
            $application = \App\Application::find($d["application_id"]);

            if(is_null($application)) {
                if(!is_null($application->mark)) {
                    $internalattendanceid = ($d["internal"] == 'Abs') ? (int) 2 : (int) 1;
                    $internalresult_id = ((int) $internalattendanceid == (int) 2) ? (int) 3 : (((int) $application->subject->imin_marks > (int) $d["internal"]) ? (int) 2 : (int) 1);

                    $application->mark->update([
                        "internal" => $d["internal"],
                        "internalresult_id" => $internalresult_id,
                        "internalattendance_id" => $internalattendanceid,
                        "total_mark" => $application->mark->grace + ((($application->mark->external == 'Abs') || ($application->mark->external == '')) ? 0 : (int) $application->mark->external) + ((int) $internalattendanceid == (int) 2) ? 0 : $d["internal"]
                    ]);

                    $datafound = \App\Internalmark::where("candidate_id", $d["candidate_id"])->where("subject_id", $d["subject_id"])->exists();

                    if(!$datafound) {
                        if($application->mark->internalresult_id == 1) {

                        }
                    }
                    else {

                    }

                }
            }

            $datafound = \App\Internalmark::where("candidate_id", $d["candidate_id"])->where("subject_id", $d["subject_id"])->exists();

            if(!$datafound) {
                \App\Internalmark::create([
                    "exam_id" => $d["exam_id"],
                    "application_id" => $d["application_id"],
                    "candidate_id" => $d["candidate_id"],
                    "subject_id" => $d["subject_id"],
                    "internal" => $d["internal"],
                    "active_status" => "1",
                ]);

                unset($d);
            }
        }
    }
}
