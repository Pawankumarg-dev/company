<?php

use Illuminate\Database\Seeder;
use App\Exam;
use App\Language;
use App\Application;
use App\Candidate;
use App\Result;
use App\Subject;
use App\Status;
use App\Mark;

class OldmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $exam_id = Exam::where('name', 'June 2017')->first();
        $language_id = Language::where('language', 'English')->first();

        $mark_array = array(
            array("marksheet_number" => "RCI/NBER/NIEPMD/2016-17/00001", "enrolmentno" => "111605901", "scode" => "CCGBC", "internal" => "24", "external" => "54", "result" => "Pass"),

            );

        foreach ($mark_array as $m) {
            $candidate = Candidate::where("enrolmentno", $m["enrolmentno"])->first();
            $subject = Subject::where("scode", $m["scode"])->first();
            $result_id = Result::where("result", $m["result"])->first()->id;

            $application1 = Application::where("exam_id", $exam_id)->where("candidate_id", $candidate->id)
                ->where("subject_id", $subject->id)->first();

            if($m["internal"] == "Abs" || $m["internal"] < $subject->imin_marks) {
                $internalresult_id = '0';
                $internal_lock = '0';
            }
            else {
                $internalresult_id = '1';
                $internal_lock = '1';
            }
            if($m["external"] == "Abs" || $m["external"] < $subject->emin_marks) {
                $externalresult_id = '0';
                $external_lock = '0';
            }
            else {
                $externalresult_id = '1';
                $external_lock = '1';
            }

            if(is_null($application1)) {

                $application2 = Application::create([
                    "exam_id" => $exam_id,
                    "approvedprogramme_id" => $candidate->approvedprogramme_id,
                    "candidate_id" => $candidate->id,
                    "subject_id" => $subject->id,
                    "language_id" => $language_id,
                    "term" => $subject->syear,
                    "status_id" => "2",
                    "linkopen_number" => "1",
                    "penalty" => "No",
                ]);

                $mark2 = Mark::where("application_id", $application2)->first();

                if(is_null($mark2)){
                    Mark::create([
                        "application_id" => $application2->id,
                        "exam_id" => $exam_id,
                        "subject_id" => $application2->id,
                        "internal" => $m["internal"],
                        "internalresult_id" => $internalresult_id,
                        "internal_lock" => $internal_lock,
                        "external" => $m["external"],
                        "externalresult_id" => $externalresult_id,
                        "external_lock" => $external_lock,
                        "result_id" => $result_id,
                        "marksheet_number" => $m["marksheet_number"],
                        "active_status" => "1",
                    ]);
                }
                else {
                    $mark2->update([
                        "application_id" => $application2->id,
                        "exam_id" => $exam_id,
                        "subject_id" => $application2->id,
                        "internal" => $m["internal"],
                        "external" => $m["external"],
                        "result_id" => $result_id,
                        "marksheet_number" => $m["marksheet_number"],
                        "active_status" => "1",
                    ]);
                }
            }
            else {
                $mark1 = Mark::where("application_id", $application1)->first();

                if(is_null($mark1)){
                    Mark::create([
                        "application_id" => $application1->id,
                        "exam_id" => $exam_id,
                        "subject_id" => $application1->id,
                        "internal" => $m["internal"],
                        "internalresult_id" => $internalresult_id,
                        "internal_lock" => $internal_lock,
                        "external" => $m["external"],
                        "externalresult_id" => $externalresult_id,
                        "external_lock" => $external_lock,
                        "result_id" => $result_id,
                        "marksheet_number" => $m["marksheet_number"],
                        "active_status" => "1",
                    ]);
                }
                else {
                    $mark1->update([
                        "application_id" => $application1->id,
                        "exam_id" => $exam_id,
                        "subject_id" => $application1->id,
                        "internal" => $m["internal"],
                        "external" => $m["external"],
                        "result_id" => $result_id,
                        "marksheet_number" => $m["marksheet_number"],
                        "active_status" => "1",
                    ]);
                }
            }

        }
    }
}
