<?php

use Illuminate\Database\Seeder;
use App\Candidate;
use App\Withheld;

class MalpracticeSeeder extends Seeder
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
            array("enrolmentno" => "231811002", "exam_id" => "15"),
            array("enrolmentno" => "231811011", "exam_id" => "15"),
            array("enrolmentno" => "231811015", "exam_id" => "15"),
            array("enrolmentno" => "231811016", "exam_id" => "15"),
            array("enrolmentno" => "231811018", "exam_id" => "15"),
            array("enrolmentno" => "231811019", "exam_id" => "15"),
            array("enrolmentno" => "231811023", "exam_id" => "16"),
            array("enrolmentno" => "231811024", "exam_id" => "17"),

        );

        foreach ($details as $detail) {
            $candidate = Candidate::where("enrolmentno", $detail["enrolmentno"])->first();

            if(!is_null($candidate)) {
                $withheld = Withheld::where('exam_id', $detail["exam_id"])->where('candidate_id', $candidate->id)->first();

                if(!is_null($withheld)) {
                    Withheld::where('exam_id', $detail["exam_id"])->where('candidate_id', $candidate->id)->update(['status'=>'1']);
                    unset($withheld);
                }
                else {
                    Withheld::create([
                        'exam_id'=>$detail["exam_id"],
                        'approvedprogramme_id'=>$candidate->approvedprogramme_id,
                        'candidate_id'=>$candidate->id,
                        'status'=>'1'
                    ]);
                }
            }

            unset($candidate);
        }
    }
}
