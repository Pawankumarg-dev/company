<?php

use App\Internalmark;
use App\Mark;
use Illuminate\Database\Seeder;
use App\Application;
use App\Candidate;
use App\Subject;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $applications = array(

            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CCGBC", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CCGDB", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CCGVI", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGPMD", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGPMI", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGPLI", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGPDB", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGPVI", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGBA", "language_id" => " 11", "examtype_id" => "1"),
            array("exam_id"=>"13", "enrolmentno" => "111935201", "scode" => "CGVV", "language_id" => " 11", "examtype_id" => "1"),

        );

        foreach ($applications as $a) {
            $subject = Subject::where('scode', $a["scode"])->first();
            $candidate = Candidate::where('enrolmentno', $a["enrolmentno"])->first();

            if(!is_null($candidate)) {
                if(!is_null($subject)) {
                    $applicationfound = Application::where('exam_id', $a["exam_id"])->where('candidate_id', $candidate->id)
                        ->where('subject_id', $subject->id)->exists();

                    if(!$applicationfound) {
                        
                    }
                }
            }

            /*
            if(!is_null($subject)) {
                $applicationfound = Application::where('exam_id', $a["exam_id"])->where('candidate_id', $request->candidate_id)
                    ->where('subject_id', $sub->id)->exists();

                if(!$applicationfound) {
                    Application::create([
                        'approvedprogramme_id'=>$ap->id,
                        'candidate_id'=>$request->candidate_id,
                        'subject_id'=>$sub->id,
                        'status_id' => 1,
                        'term'=>$request->term,
                        'language_id'=>$request->language,
                        'exam_id' => $request->exam_id,
                        'linkopen_number' => $request->linkopen_number,
                        'penalty' => $request->penalty
                    ]);

                    $application = Application::where('exam_id', $request->exam_id)->where('candidate_id', $request->candidate_id)
                        ->where('subject_id', $sub->id)->first();

                    if($application->subject->imin_marks == 0) {
                        $mark = Mark::create([
                            "application_id" => $application->id,
                            "exam_id" => $request->exam_id,
                            "candidate_id" => $application->candidate_id,
                            "subject_id" => $application->subject_id,
                            "internal" => "0",
                            "internalresult_id" => 1,
                            "internal_lock" => 1,
                            "internalattendance_id" => 1,
                            "active_status" => 1
                        ]);
                        $mark->increment('total_mark', '0');
                    }
                    else {
                        $internalmark = Internalmark::where('candidate_id', $application->candidate_id)->where('subject_id', $application->subject_id)->first();

                        if(!is_null($internalmark)) {
                            $mark = Mark::create([
                                "application_id" => $application->id,
                                "exam_id" => $request->exam_id,
                                "candidate_id" => $application->candidate_id,
                                "subject_id" => $application->subject_id,
                                "internal" => $internalmark->internal,
                                "internalresult_id" => 1,
                                "internal_lock" => 1,
                                "internalattendance_id" => 1,
                                "active_status" => 1
                            ]);
                            $mark->increment('total_mark', $internalmark->internal);
                        }
                    }
                }



                $app = Application::where('exam_id', $a["exam_id"])->where('candidate_id', $candidate->id)->where('subject_id', $subject->id)->first();

                if(is_null($app)) {
                    Application::create([
                        "exam_id" => $a["exam_id"],
                        "candidate_id" => $candidate->id,
                        "approvedprogramme_id" => $candidate->approvedprogramme_id,
                        "examtype_id" => $a["examtype_id"],
                        "subject_id" => $subject->id,
                        "term" => $subject->syear,
                        "status_id" => "1",
                        "language_id" => $a["language_id"],
                        "linkopen_number" => "1",
                        "penalty" => "Yes"
                    ]);
                }
            }
            else {
                echo 'subject code: '.$a["scode"].'<br>';
            }

            unset($a);
            */
        }
    }
}
