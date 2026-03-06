<?php

use Illuminate\Database\Seeder;
use App\Candidate;
use App\Subject;
use App\Mark;
use App\Markcertificate;
use App\Application;
use App\Withheld;
use App\Examresultdate;
use App\Institute;
use App\User;
use App\Approvedprogramme;
use App\Programme;
use App\Examtimetable;
use App\Academicyear;
use App\Examcenter;
use App\Reevaluationresult;
use App\Reevaluation;

class ReevaluationSeeder extends Seeder
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
         array("exam_id" => "15", "enrolmentno" => "221814506", "scode" => "02CPVE", "reevaluated_external_mark" => "26", "grace" => "0", "publish_status" => "1"),
         */

        /*
        $revaluation_array = array(
            array("exam_id" => "17", "publish_status" => "1",  "enrolmentno" => "232008420", "scode" => "01IDIT", "reevaluated_external_mark" => "26", "grace" => "0"),
        );

        $sno = 1;
        foreach($revaluation_array as $rea) {
            $candidate = Candidate::where('enrolmentno', trim($rea["enrolmentno"]))->first();

            if(!is_null($candidate)) {
                $subjects = Subject::where('scode', trim($rea["scode"]))->get();

                foreach ($subjects as $subject) {
                    if(!is_null($subject)) {
                        $application = Application::where('exam_id', $rea["exam_id"])->where('candidate_id', $candidate->id)
                            ->where('subject_id', $subject->id)->first();

                        if(!is_null($application)) {
                            $mark = Mark::where('application_id', $application->id)->first();

                            if(!is_null($mark)) {
                                $reevaluation_id = Reevaluation::where('exam_id', $rea["exam_id"])->first()->id;

                                $re = Reevaluationresult::where('reevaluation_id', $reevaluation_id)->where('candidate_id', $candidate->id)
                                    ->where('subject_id', $subject->id)->first();

                                if(is_null($re)) {
                                    $actual_external_mark = (int) $mark->external + (int) $mark->grace;

                                    $reevaluationresult = Reevaluationresult::create([
                                        'reevaluation_id' => $reevaluation_id,
                                        'mark_id' => $mark->id,
                                        'application_id' => $application->id,
                                        'candidate_id' => $candidate->id,
                                        'subject_id' => $subject->id,
                                        'actual_external_mark' => $actual_external_mark,
                                        'reevaluated_external_mark' => trim($rea["reevaluated_external_mark"]),
                                        'publish_status' => trim($rea["publish_status"])
                                    ]);

                                    if($actual_external_mark == $rea["reevaluated_external_mark"]) {
                                        $reevaluationresult->update([
                                            'reevaluation_remarks' => 'No Change',
                                        ]);
                                    }
                                    else {
                                        $reevaluationresult->update([
                                            'reevaluation_remarks' => 'Change',
                                        ]);
                                    }

                                    $mark->update([
                                        'external' => $rea["reevaluated_external_mark"],
                                        'grace' => $rea["grace"]
                                    ]);
                                }
                                else {
                                    echo '*** '.$sno.'- Re-evaluation Error *** ';
                                }
                            }
                            else {
                                echo '*** '.$sno.'- Mark Error *** ';
                            }
                        }
                        else {
                            echo '*** '.$sno.'- Application Error *** ';
                        }
                    }
                    else {
                        echo '*** '.$sno.'- Subject Error *** ';
                    }
                }
            }
            else {
                echo '*** '.$sno.'- Enrolmentno Error *** ';
            }
            $sno++;
        }
        */

        //$this->configureReevaluationResultDates();
        $this->publishResults();
        //$this->addnewevaluations();
        //$this->updateReevaluationApplicationFees();
    }

    public function addnewevaluations() {
        $reevaluations = Reevaluation::where('exam_id', '18')->first();

        if(!$reevaluations) {
            Reevaluation::create([
                'exam_id' => '18',
                'application_count' => '0',
                'lastdate' => '2022-09-09'
            ]);
        }
    }

    public function updateReevaluationApplicationFees() {
        $reevaluationapplicationfee = \App\Reevaluationapplicationfee::where('exam_id', '18')->get();

        if($reevaluationapplicationfee->count() === 0) {
            \App\Reevaluationapplicationfee::create([
                'exam_id' => '18',
                'reevaluation_fee' => '1000',
                'retotalling_fee' => '500',
                'photocopying_fee' => '500',
                'active_status' => 1
            ]);
        }
    }

    public function configureReevaluationResultDates() {
        $details = array(
            /*array("exam_id" => 18, "resultdate" => "2022-09-10", "publish_status" => 1),
            array("exam_id" => 19, "resultdate" => "2022-09-10", "publish_status" => 1),*/
            array("exam_id" => 20, "resultdate" => "2023-05-01", "publish_status" => 1),
        );

        foreach ($details as $detail) {
            $reevaluation = Reevaluation::where('exam_id', $detail["exam_id"])->first();

            if(!is_null($reevaluation)) {
                $reevaluation->update([
                    "exam_id" => $detail["exam_id"],
                    "resultdate" => $detail["resultdate"],
                    "publish_status" => $detail["publish_status"],
                ]);
            }
        }
    }

    public function publishResults() {
        $revaluation_array = array(
                    /*array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352138904", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"21", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352138905", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352138905", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"19", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352138905", "scode"=>"01IDDCD", "reevaluated_external_mark"=>"14", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352145023", "scode"=>"01IDDTA", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352145023", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352125115", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"23", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352149802", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352125104", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352138911", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"26", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352120506", "scode"=>"01IDDCC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352145021", "scode"=>"01IDDTA", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352145011", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"211912910", "scode"=>"02ASDTI2", "reevaluated_external_mark"=>"32", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"211912910", "scode"=>"01ASDIT", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352120507", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"212020506", "scode"=>"01ASDIT", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"212020506", "scode"=>"02ASDCP", "reevaluated_external_mark"=>"15", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"212020506", "scode"=>"01ASDAA", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352132301", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"11", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352132305", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"22", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352112901", "scode"=>"01IDDCD", "reevaluated_external_mark"=>"13", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352112901", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352148432", "scode"=>"01IDDCD", "reevaluated_external_mark"=>"27", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352125103", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352119304", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"7", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352119304", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352145024", "scode"=>"01IDDTA", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222119306", "scode"=>"01CPCM", "reevaluated_external_mark"=>"33", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222119306", "scode"=>"01CPEC", "reevaluated_external_mark"=>"33", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352119302", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"15", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352119318", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"14", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352120501", "scode"=>"01IDDCC", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352120501", "scode"=>"01IDDTA", "reevaluated_external_mark"=>"19", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352142817", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"19", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352142832", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352142809", "scode"=>"01IDDCL", "reevaluated_external_mark"=>"13", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352119303", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"14", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222125311", "scode"=>"01CPEP", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128027", "scode"=>"01CPIT", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128027", "scode"=>"01CPCM", "reevaluated_external_mark"=>"29", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128027", "scode"=>"01CPEP", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222125302", "scode"=>"01CPEP", "reevaluated_external_mark"=>"31", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128002", "scode"=>"01CPIT", "reevaluated_external_mark"=>"37", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128013", "scode"=>"01CPEP", "reevaluated_external_mark"=>"14", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128013", "scode"=>"01CPEC", "reevaluated_external_mark"=>"26", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128013", "scode"=>"01CPIT", "reevaluated_external_mark"=>"16", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128013", "scode"=>"01CPCM", "reevaluated_external_mark"=>"27", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128029", "scode"=>"01CPEP", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128029", "scode"=>"01CPIT", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352139828", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"15", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352139809", "scode"=>"01IDDCL", "reevaluated_external_mark"=>"19", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128018", "scode"=>"01CPEP", "reevaluated_external_mark"=>"27", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128003", "scode"=>"01CPCM", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222125312", "scode"=>"01CPIT", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222125312", "scode"=>"01CPEP", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222125305", "scode"=>"01CPEP", "reevaluated_external_mark"=>"29", "grace"=> "0"),
                     array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352100313", "scode"=>"01IDDCC", "reevaluated_external_mark"=>"15", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352140311", "scode"=>"01IDDCC", "reevaluated_external_mark"=>"19", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352125314", "scode"=>"01IDDCD", "reevaluated_external_mark"=>"11", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352125314", "scode"=>"01IDDIT", "reevaluated_external_mark"=>"18", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222107903", "scode"=>"01CPCM", "reevaluated_external_mark"=>"34", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128018", "scode"=>"01CPPM", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149004","scode"=>"01IDDCD","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149021","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149018","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143401","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143401","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143407","scode"=>"01IDDCL","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148805","scode"=>"01IDDTA","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127220","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148224","scode"=>"01IDDCL","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148225","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148816","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127216","scode"=>"01IDDTA","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143428","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127230","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111524","scode"=>"01IDDCD","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111509","scode"=>"01IDDCL","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111532","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111532","scode"=>"01IDDCL","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111532","scode"=>"01IDDAC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111523","scode"=>"01IDDAC","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128333","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128333","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149028","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112612","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"362121302","scode"=>"01CBRIE","reevaluated_external_mark"=>"28","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"362121302","scode"=>"01CBRAT","reevaluated_external_mark"=>"34","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"362121303","scode"=>"01CBRIE","reevaluated_external_mark"=>"28","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"362121303","scode"=>"01CBRAT","reevaluated_external_mark"=>"32","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121316","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121301","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111526","scode"=>"01IDDAC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111526","scode"=>"01IDDTA","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352111526","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127208","scode"=>"01IDDTA","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128311","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128311","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127206","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127206","scode"=>"01IDDTA","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127206","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112609","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"362121304","scode"=>"01CBRAT","reevaluated_external_mark"=>"33","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"362121304","scode"=>"01CBRIE","reevaluated_external_mark"=>"29","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121405","scode"=>"01IDDAC","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121405","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143416","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352117017","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112615","scode"=>"01IDDCL","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121333","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121333","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121318","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112610","scode"=>"01IDDCL","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112610","scode"=>"01IDDTA","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112610","scode"=>"01IDDAC","reevaluated_external_mark"=>"9","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112610","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128325","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128327","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143717","scode"=>"01IDDIT","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133320","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112617","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148815","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148317","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148312","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146423","scode"=>"01IDDCC","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148818","scode"=>"01IDDIT","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148826","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148821","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148821","scode"=>"01IDDCL","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112616","scode"=>"01IDDCL","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112608","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112621","scode"=>"01IDDCL","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352121324","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149005","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352123609","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148617","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148617","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147304","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148620","scode"=>"01IDDCC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148620","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148621","scode"=>"01IDDIT","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148602","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148602","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148608","scode"=>"01IDDCC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148608","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148608","scode"=>"01IDDCD","reevaluated_external_mark"=>"4","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148610","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148610","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148603","scode"=>"01IDDCL","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148613","scode"=>"01IDDIT","reevaluated_external_mark"=>"26","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148627","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148627","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148619","scode"=>"01IDDIT","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128304","scode"=>"01IDDTA","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352142105","scode"=>"01IDDCD","reevaluated_external_mark"=>"24","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148814","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352142006","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352142006","scode"=>"01IDDAC","reevaluated_external_mark"=>"6","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133406","scode"=>"01IDDCD","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133401","scode"=>"01IDDCD","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112618","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133409","scode"=>"01IDDCL","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148217","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148217","scode"=>"01IDDCC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148318","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138607","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137701","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137710","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138606","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138605","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148616","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138604","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149013","scode"=>"01IDDIT","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145530","scode"=>"01IDDCC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146209","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146209","scode"=>"01IDDAC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146206","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146206","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138202","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138202","scode"=>"01IDDCC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138202","scode"=>"01IDDTA","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145519","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145529","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145529","scode"=>"01IDDAC","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145521","scode"=>"01IDDAC","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145504","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145504","scode"=>"01IDDTA","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145524","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145524","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145524","scode"=>"01IDDAC","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145524","scode"=>"01IDDCD","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145518","scode"=>"01IDDAC","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149422","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149410","scode"=>"01IDDTA","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149417","scode"=>"01IDDTA","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149404","scode"=>"01IDDCC","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149404","scode"=>"01IDDTA","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149413","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149413","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149413","scode"=>"01IDDTA","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149413","scode"=>"01IDDCC","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149413","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149420","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145511","scode"=>"01IDDAC","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148732","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148705","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148705","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148701","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146426","scode"=>"01IDDCL","reevaluated_external_mark"=>"29","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150101","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150101","scode"=>"01IDDIT","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146403","scode"=>"01IDDCL","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112322","scode"=>"01IDDCL","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145621","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147305","scode"=>"01IDDCD","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147307","scode"=>"01IDDCD","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149020","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148729","scode"=>"01IDDCC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148609","scode"=>"01IDDIT","reevaluated_external_mark"=>"24","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148609","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145507","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145507","scode"=>"01IDDAC","reevaluated_external_mark"=>"29","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145505","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150109","scode"=>"01IDDCC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150109","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146207","scode"=>"01IDDTA","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146207","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146212","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146212","scode"=>"01IDDCL","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146202","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137724","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137724","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149002","scode"=>"01IDDTA","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149002","scode"=>"01IDDIT","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149002","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149002","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149029","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146925","scode"=>"01IDDIT","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352117001","scode"=>"01IDDTA","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352117001","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146904","scode"=>"01IDDCC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146904","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146904","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146904","scode"=>"01IDDAC","reevaluated_external_mark"=>"7","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146904","scode"=>"01IDDTA","reevaluated_external_mark"=>"9","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146923","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146913","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147324","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352117508","scode"=>"01IDDCL","reevaluated_external_mark"=>"26","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352117527","scode"=>"01IDDTA","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146911","scode"=>"01IDDCC","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352117535","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146908","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146918","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147303","scode"=>"01IDDCD","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147303","scode"=>"01IDDCL","reevaluated_external_mark"=>"32","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147306","scode"=>"01IDDCD","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145517","scode"=>"01IDDAC","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145517","scode"=>"01IDDIT","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148731","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148731","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145502","scode"=>"01IDDCC","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145502","scode"=>"01IDDIT","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145502","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116430","scode"=>"01IDDTA","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116429","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146205","scode"=>"01IDDAC","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146204","scode"=>"01IDDAC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146204","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146213","scode"=>"01IDDTA","reevaluated_external_mark"=>"6","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146213","scode"=>"01IDDAC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146208","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145618","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144802","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144802","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144802","scode"=>"01IDDTA","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145620","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145620","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149407","scode"=>"01IDDTA","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149415","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149415","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149415","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149412","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149416","scode"=>"01IDDCC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149416","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137703","scode"=>"01IDDTA","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137703","scode"=>"01IDDCL","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137703","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145622","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145622","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145622","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145622","scode"=>"01IDDTA","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138310","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145509","scode"=>"01IDDAC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128330","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138301","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138304","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138304","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146411","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146411","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143209","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143214","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143215","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143215","scode"=>"01IDDCL","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143219","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127703","scode"=>"01IDDAC","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127703","scode"=>"01IDDTA","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127705","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127711","scode"=>"01IDDAC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127711","scode"=>"01IDDIT","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127723","scode"=>"01IDDCC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127723","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127722","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127714","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127725","scode"=>"01IDDIT","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127732","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127720","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127717","scode"=>"01IDDAC","reevaluated_external_mark"=>"16","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127717","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127726","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127707","scode"=>"01IDDIT","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127724","scode"=>"01IDDTA","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146610","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148311","scode"=>"01IDDTA","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148311","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148107","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148107","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148107","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148124","scode"=>"01IDDAC","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148124","scode"=>"01IDDCD","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148109","scode"=>"01IDDCD","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148109","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148109","scode"=>"01IDDCL","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148109","scode"=>"01IDDCC","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143419","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143419","scode"=>"01IDDCL","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143430","scode"=>"01IDDCD","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148121","scode"=>"01IDDIT","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148115","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148115","scode"=>"01IDDIT","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116426","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146427","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147317","scode"=>"01IDDCD","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147317","scode"=>"01IDDTA","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127727","scode"=>"01IDDIT","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112316","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112316","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352140125","scode"=>"01IDDIT","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352140125","scode"=>"01IDDCL","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352140104","scode"=>"01IDDCD","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150106","scode"=>"01IDDIT","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150106","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150103","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150103","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147327","scode"=>"01IDDIT","reevaluated_external_mark"=>"23","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146606","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144810","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144810","scode"=>"01IDDCC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144810","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144810","scode"=>"01IDDAC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128307","scode"=>"01IDDCD","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128307","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138308","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145921","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137702","scode"=>"01IDDCL","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137713","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137713","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137705","scode"=>"01IDDTA","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137705","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137705","scode"=>"01IDDCL","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149507","scode"=>"01IDDTA","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149507","scode"=>"01IDDCL","reevaluated_external_mark"=>"9","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149507","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149505","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149505","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149502","scode"=>"01IDDAC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133312","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133307","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146609","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146608","scode"=>"01IDDCD","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128328","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143422","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149421","scode"=>"01IDDTA","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146603","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143429","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138307","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116420","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128310","scode"=>"01IDDCD","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128310","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138735","scode"=>"01IDDCD","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145929","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127235","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352123604","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145516","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145516","scode"=>"01IDDAC","reevaluated_external_mark"=>"24","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145912","scode"=>"01IDDCL","reevaluated_external_mark"=>"26","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352123616","scode"=>"01IDDCL","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138728","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149628","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149628","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352143712","scode"=>"01IDDTA","reevaluated_external_mark"=>"3","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133209","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133215","scode"=>"01IDDCD","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149503","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133228","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133222","scode"=>"01IDDIT","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133222","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133207","scode"=>"01IDDIT","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138712","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133221","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133221","scode"=>"01IDDCD","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138727","scode"=>"01IDDCD","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138727","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133208","scode"=>"01IDDIT","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138720","scode"=>"01IDDAC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138720","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145934","scode"=>"01IDDIT","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133219","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145904","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133224","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138724","scode"=>"01IDDTA","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138724","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133210","scode"=>"01IDDTA","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133210","scode"=>"01IDDIT","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112301","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112333","scode"=>"01IDDTA","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133229","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146602","scode"=>"01IDDCD","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146602","scode"=>"01IDDCC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133231","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149626","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149626","scode"=>"01IDDIT","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112324","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352112324","scode"=>"01IDDCL","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150119","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138710","scode"=>"01IDDIT","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138734","scode"=>"01IDDCD","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138733","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138718","scode"=>"01IDDAC","reevaluated_external_mark"=>"25","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138732","scode"=>"01IDDCD","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138721","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138730","scode"=>"01IDDIT","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138730","scode"=>"01IDDCD","reevaluated_external_mark"=>"9","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146601","scode"=>"01IDDCD","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128320","scode"=>"01IDDCL","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137723","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148802","scode"=>"01IDDAC","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148802","scode"=>"01IDDIT","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148802","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145928","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133313","scode"=>"01IDDCL","reevaluated_external_mark"=>"22","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137718","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128329","scode"=>"01IDDTA","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150116","scode"=>"01IDDCD","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150116","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149414","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149414","scode"=>"01IDDTA","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352148811","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137704","scode"=>"01IDDCL","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137704","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137704","scode"=>"01IDDIT","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137704","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138715","scode"=>"01IDDAC","reevaluated_external_mark"=>"24","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145911","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133216","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133214","scode"=>"01IDDAC","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133217","scode"=>"01IDDCD","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133217","scode"=>"01IDDIT","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133205","scode"=>"01IDDIT","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145925","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138205","scode"=>"01IDDAC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150114","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150001","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150001","scode"=>"01IDDCD","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150001","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138313","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138731","scode"=>"01IDDCD","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150003","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144823","scode"=>"01IDDAC","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137808","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144804","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144804","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138309","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138312","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147322","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352147322","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352138203","scode"=>"01IDDAC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150107","scode"=>"01IDDCC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150107","scode"=>"01IDDCL","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149629","scode"=>"01IDDIT","reevaluated_external_mark"=>"20","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127712","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127731","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127731","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352127731","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146402","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137324","scode"=>"01IDDCL","reevaluated_external_mark"=>"27","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137324","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352149627","scode"=>"01IDDTA","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137322","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137322","scode"=>"01IDDCD","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137322","scode"=>"01IDDCC","reevaluated_external_mark"=>"3","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145930","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352145930","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137303","scode"=>"01IDDAC","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137303","scode"=>"01IDDTA","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137303","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137334","scode"=>"01IDDCC","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137316","scode"=>"01IDDAC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137320","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137309","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133330","scode"=>"01IDDCD","reevaluated_external_mark"=>"11","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137307","scode"=>"01IDDTA","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137307","scode"=>"01IDDAC","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137325","scode"=>"01IDDIT","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133301","scode"=>"01IDDCL","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352133301","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137331","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137313","scode"=>"01IDDTA","reevaluated_external_mark"=>"21","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137329","scode"=>"01IDDCL","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137329","scode"=>"01IDDIT","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352137329","scode"=>"01IDDTA","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352144819","scode"=>"01IDDAC","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146611","scode"=>"01IDDCD","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128312","scode"=>"01IDDIT","reevaluated_external_mark"=>"13","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128312","scode"=>"01IDDCC","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146604","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352146607","scode"=>"01IDDCD","reevaluated_external_mark"=>"15","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352123603","scode"=>"01IDDCC","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128334","scode"=>"01IDDTA","reevaluated_external_mark"=>"10","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128334","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352128335","scode"=>"01IDDTA","reevaluated_external_mark"=>"14","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352150006","scode"=>"01IDDIT","reevaluated_external_mark"=>"12","grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352121408", "scode"=>"01IDDCL", "reevaluated_external_mark"=>"13", "grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116702","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116701","scode"=>"01IDDCL","reevaluated_external_mark"=>"7","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116703","scode"=>"01IDDCL","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116620","scode"=>"01IDDIT","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116603","scode"=>"01IDDCD","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116605","scode"=>"01IDDCL","reevaluated_external_mark"=>"8","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352116606","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132710","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132704","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132716","scode"=>"01IDDCL","reevaluated_external_mark"=>"9","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132714","scode"=>"01IDDCL","reevaluated_external_mark"=>"19","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132711","scode"=>"01IDDCL","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132712","scode"=>"01IDDCL","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132713","scode"=>"01IDDCL","reevaluated_external_mark"=>"5","grace"=> "0"),
                    array("exam_id"=>"20","publish_status"=>"1","enrolmentno"=>"352132715","scode"=>"01IDDCL","reevaluated_external_mark"=>"18","grace"=> "0"),*/
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352108401", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352108402", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"24", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222119301", "scode"=>"01CPCM", "reevaluated_external_mark"=>"46", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222119307", "scode"=>"01CPEC", "reevaluated_external_mark"=>"36", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352119308", "scode"=>"01IDDCL", "reevaluated_external_mark"=>"28", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"352139911", "scode"=>"01IDDAC", "reevaluated_external_mark"=>"20", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128006", "scode"=>"01CPIT", "reevaluated_external_mark"=>"38", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128004", "scode"=>"01CPIT", "reevaluated_external_mark"=>"44", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128014", "scode"=>"01CPEP", "reevaluated_external_mark"=>"40", "grace"=> "0"),
                    array("exam_id"=>"20", "publish_status"=>"1", "enrolmentno"=>"222128014", "scode"=>"01CPIT", "reevaluated_external_mark"=>"44", "grace"=> "0"),

                );

        $sno = 1;
        foreach($revaluation_array as $rea) {
            $candidate = Candidate::where('enrolmentno', trim($rea["enrolmentno"]))->first();

            if(!is_null($candidate)) {
                $subjects = Subject::where('scode', trim($rea["scode"]))->get();

                foreach ($subjects as $subject) {
                    if(!is_null($subject)) {
                        $application = Application::where('exam_id', $rea["exam_id"])->where('candidate_id', $candidate->id)
                            ->where('subject_id', $subject->id)->first();

                        if(!is_null($application)) {
                            $mark = Mark::where('application_id', $application->id)->first();

                            if(!is_null($mark)) {
                                $reevaluation_id = Reevaluation::where('exam_id', $rea["exam_id"])->first()->id;

                                $re = Reevaluationresult::where('reevaluation_id', $reevaluation_id)->where('candidate_id', $candidate->id)
                                    ->where('subject_id', $subject->id)->first();

                                if(is_null($re)) {
                                    $actual_external_mark = (int) $mark->external + (int) $mark->grace;

                                    $reevaluationresult = Reevaluationresult::create([
                                        'reevaluation_id' => $reevaluation_id,
                                        'mark_id' => $mark->id,
                                        'application_id' => $application->id,
                                        'candidate_id' => $candidate->id,
                                        'subject_id' => $subject->id,
                                        'actual_external_mark' => $actual_external_mark,
                                        'reevaluated_external_mark' => trim($rea["reevaluated_external_mark"]),
                                        'publish_status' => trim($rea["publish_status"])
                                    ]);

                                    if($actual_external_mark == $rea["reevaluated_external_mark"]) {
                                        $reevaluationresult->update([
                                            'reevaluation_remarks' => 'No Change',
                                        ]);
                                    }
                                    else {
                                        $reevaluationresult->update([
                                            'reevaluation_remarks' => 'Change',
                                        ]);
                                    }

                                    $mark->update([
                                        'external' => $rea["reevaluated_external_mark"],
                                        'grace' => $rea["grace"]
                                    ]);
                                }
                                else {
                                    echo '*** '.$sno.'- Re-evaluation Error *** ';
                                }
                            }
                            else {
                                echo '*** '.$sno.'- Mark Error *** ';
                            }
                        }
                        else {
                            echo '*** '.$sno.'- Application Error *** ';
                        }
                    }
                    else {
                        echo '*** '.$sno.'- Subject Error *** ';
                    }
                }
            }
            else {
                echo '*** '.$sno.'- Enrolmentno Error *** ';
            }
            $sno++;
        }

    }
}
