<?php

use Illuminate\Database\Seeder;
use App\Candidate;
use App\Subject;
use App\Application;
use App\Mark;

class GracemarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
        $collections = array(
            array("exam_id" => "13", "enrolmentno" => "231814505", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231814505", "scode" => "02MRTP"),
            array("exam_id" => "13", "enrolmentno" => "231814509", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231814521", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231814521", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231814521", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231814502", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231814529", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231822113", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822106", "scode" => "02MRTP"),
            array("exam_id" => "13", "enrolmentno" => "211831003", "scode" => "02ASDIC"),
            array("exam_id" => "13", "enrolmentno" => "211831003", "scode" => "02ASDTI1"),
            array("exam_id" => "13", "enrolmentno" => "211831003", "scode" => "02ASDTI2"),
            array("exam_id" => "13", "enrolmentno" => "211831003", "scode" => "02ASDCP"),
            array("exam_id" => "13", "enrolmentno" => "231833909", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231833909", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231833925", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231834006", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840006", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840008", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840017", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840017", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231840017", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231840020", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231840020", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "211819111", "scode" => "02ASDIC"),
            array("exam_id" => "13", "enrolmentno" => "211819111", "scode" => "02ASDTI1"),
            array("exam_id" => "13", "enrolmentno" => "211814512", "scode" => "02ASDTI2"),
            array("exam_id" => "13", "enrolmentno" => "211814513", "scode" => "02ASDTI2"),
            array("exam_id" => "13", "enrolmentno" => "211814520", "scode" => "02ASDAF"),
            array("exam_id" => "13", "enrolmentno" => "211814520", "scode" => "02ASDTI2"),
            array("exam_id" => "13", "enrolmentno" => "211814520", "scode" => "02ASDTI1"),
            array("exam_id" => "13", "enrolmentno" => "231814530", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231817112", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231817113", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231817113", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231817119", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231817119", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231817123", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231817123", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231817130", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231817130", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822128", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822111", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231833917", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840011", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840012", "scode" => "02MRES"),
            array("exam_id" => "13", "enrolmentno" => "231840012", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822125", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822125", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231822125", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231822110", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231822110", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822110", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231833922", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831003", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831023", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831023", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231831022", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231831007", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831020", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831017", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831011", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831011", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231831024", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831024", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231831005", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231831015", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231834005", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231839408", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231839408", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231839423", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231839422", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231839422", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231839421", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231839414", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231839414", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231839414", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231839402", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231839424", "scode" => "02MRES"),
            array("exam_id" => "13", "enrolmentno" => "231839424", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231841913", "scode" => "02MRMT"),
            array("exam_id" => "13", "enrolmentno" => "231841913", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231841912", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231841916", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231841901", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231841902", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231840021", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231822109", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "231810503", "scode" => "02MRSC"),
            array("exam_id" => "13", "enrolmentno" => "211819121", "scode" => "02ASDAF"),
            array("exam_id" => "13", "enrolmentno" => "211819119", "scode" => "02ASDTI2"),
            array("exam_id" => "13", "enrolmentno" => "231840021", "scode" => "02MRIC"),
            array("exam_id" => "13", "enrolmentno" => "231840021", "scode" => "02MRDM"),
            array("exam_id" => "13", "enrolmentno" => "231822109", "scode" => "02MRDM"),
        );
        foreach ($collections as $collection) {
            $candidate = Candidate::where('enrolmentno', $collection["enrolmentno"])->first();

            if(!is_null($candidate)) {
                $subjects = Subject::where('scode', $collection["scode"])->get();

                foreach ($subjects as $subject) {
                    if(!is_null($subject)) {
                        $application = Application::where('exam_id', $collection["exam_id"])->where('candidate_id', $candidate->id)
                            ->where('subject_id', $subject->id)->first();

                        if(!is_null($application)) {
                            $mark = Mark::where('application_id', $application->id)->first();

                            if(!is_null($mark)) {
                                $ext_min_mark = $application->subject->emin_marks;
                                if($mark->external < $ext_min_mark) {
                                    if((int) $ext_min_mark - (int) $mark->external <= 3) {
                                        $grace_mark = $mark->grace;

                                        if($grace_mark == 0) {
                                            $grace_mark = (int) $ext_min_mark - (int) $mark->external;

                                            $mark->update([
                                                "grace" => $grace_mark,
                                            ]);
                                        }

                                        unset($grace_mark);
                                    }
                                }

                                unset($ext_min_mark);
                            }

                            unset($mark);
                        }

                        unset($application);
                    }
                }

                unset($subjects);
            }
            else {
                echo "*** Candidate Enrolmentno : ".$collection["enrolmentno"]." - not found ***";
            }

            unset($candidate);
            unset($collection);
        }
        */
        $this->putgracemark();
    }

    public function putgracemark() {
        $details = array(
            array("markid" => "515168", "grace" => "3"),
            array("markid" => "483164", "grace" => "2"),
            array("markid" => "514893", "grace" => "2"),
            array("markid" => "514991", "grace" => "2"),
            array("markid" => "467960", "grace" => "2"),
            array("markid" => "467963", "grace" => "3"),
            array("markid" => "468004", "grace" => "1"),
        );

        foreach ($details as $detail) {
            Mark::where('id', $detail["markid"])->update([
                "grace" => $detail["grace"]
            ]);

            unset($detail);
        }
    }
}
