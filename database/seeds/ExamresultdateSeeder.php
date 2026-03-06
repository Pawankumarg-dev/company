<?php

use Illuminate\Database\Seeder;
use App\Examresultdate;
use App\Programme;
use App\Academicyear;
use App\Exam;
use App\Exambatch;

class ExamresultdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $ay = Academicyear::where('year', '2017')->first();
        $p = Programme::where('abbreviation', 'DEd-SE-MR')->first();
        $ert = Examresultdate::where('exam_id', '2')->where('programme_id', $p->id)->where('academicyear_id', $ay->id)->get();

        if($ert->count() == 0) {
            Examresultdate::where('exam_id', '2')->where('programme_id', $p->id)->where('academicyear_id', $ay->id);
            Examresultdate::create([
                'exam_id'=>'2',
                'programme_id'=>$p->id,
                'academicyear_id'=>$ay->id,
                'publish_date'=>'2018-08-31',
                'publish_status'=>'1']);
        }
        */


        /*
        $eid = Exam::where('id', '2')->first()->id;
        $examresultdate_array = array(

            array("course" => "DEd-SE-MR(NIEPID)", "year" => "2017", "publish_date" => "2018-08-18", "publish_status" => "1"),
            array("course" => "DVR (MR)", "year" => "2015", "publish_date" => "2018-08-18", "publish_status" => "1"),
            array("course" => "DEd-SE-ASD", "year" => "2015", "publish_date" => "2018-08-18", "publish_status" => "1"),
            array("course" => "DEd-SE-CP", "year" => "2015", "publish_date" => "2018-08-18", "publish_status" => "1"),
            array("course" => "DEd-SE-MR", "year" => "2015", "publish_date" => "2018-08-18", "publish_status" => "1"),
            array("course" => "DEd-SE-MR(NIMH)", "year" => "2015", "publish_date" => "2018-08-18", "publish_status" => "1"),

            array("course" => "DEd-SE-ASD", "year" => "2014", "publish_date" => "2018-08-18", "publish_status" => "1"),
            array("course" => "DEd-SE-MR(NIMH)", "year" => "2017", "publish_date" => "2018-08-18", "publish_status" => "1"),
        );

        foreach ($examresultdate_array as $exa) {
            $pid = Programme::where('abbreviation', $exa["course"])->first()->id;
            $ayid = $ay = Academicyear::where('year', $exa["year"])->first()->id;

            $ert = Examresultdate::where('exam_id', $eid)->where('programme_id', $pid)->where('academicyear_id', $ayid)->first();

            if(is_null($ert)) {
                Examresultdate::create([
                    "exam_id" => $eid,
                    "programme_id" => $pid,
                    "academicyear_id" => $ayid,
                    "publish_date" => $exa["publish_date"],
                    "publish_status" => $exa["publish_status"],
                 ]);
            }
        }
        */

        /*
        $eid = Exam::where('id', '3')->first()->id;
        $examresultdate_array = array(
            array("course" => "ACCIE(CD)", "year" => "2017", "publish_date" => "2018-10-13", "publish_status" => "1"),
            array("course" => "CCRT", "year" => "2017", "publish_date" => "2018-10-13", "publish_status" => "1"),
            array("course" => "CPO", "year" => "2017", "publish_date" => "2018-10-13", "publish_status" => "1"),
            array("course" => "DPO", "year" => "2017", "publish_date" => "2018-10-13", "publish_status" => "1"),
            array("course" => "DRT", "year" => "2017", "publish_date" => "2018-10-13", "publish_status" => "1"),
            array("course" => "DRT", "year" => "2016", "publish_date" => "2018-10-13", "publish_status" => "1"),

            array("course" => "DPO", "year" => "2016", "publish_date" => "2018-10-13", "publish_status" => "1"),
        );

        foreach ($examresultdate_array as $exa) {
            $pid = Programme::where('abbreviation', $exa["course"])->first()->id;
            $ayid = $ay = Academicyear::where('year', $exa["year"])->first()->id;

            $ert = Examresultdate::where('exam_id', $eid)->where('programme_id', $pid)->where('academicyear_id', $ayid)->first();

            if(is_null($ert)) {
                Examresultdate::create([
                    "exam_id" => $eid,
                    "programme_id" => $pid,
                    "academicyear_id" => $ayid,
                    "publish_date" => $exa["publish_date"],
                    "publish_status" => $exa["publish_status"],
                ]);
            }
        }

        $eid = Exam::where('id', '5')->first()->id;
        $examresultdate_array = array(
            array("course" => "DEd-SE-CP", "year" => "2015", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-CP", "year" => "2016", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-CP", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-ASD", "year" => "2015", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-ASD", "year" => "2016", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-ASD", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-MR", "year" => "2015", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-MR", "year" => "2016", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-MR", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DVR (MR)", "year" => "2015", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DVR (MR)", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DCBR", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "ACCIE(CD) - 2 (FEB - JUL)", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DEd-SE-MR(NIMH)", "year" => "2015", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DRT", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
            array("course" => "DPO", "year" => "2017", "publish_date" => "2019-02-05", "publish_status" => "1"),
        );
        */
        /*

        $examresultdate_array = array(
            array("programme_id" => "22", "academicyear_id" => "7", "publish_date" => "15-09-2020", "publish_status" => "1"),
        );

        $examid = Exam::where('name', 'March 2020')->first()->id;

        foreach ($examresultdate_array as $erta) {
            $ert = Examresultdate::where('exam_id', $examid)->where('programme_id', $erta["programme_id"])
                ->where('academicyear_id', $erta["academicyear_id"])->first();

            if(is_null($ert)) {
                Examresultdate::create([
                    "exam_id" => $examid,
                    "programme_id" => $erta["programme_id"],
                    "academicyear_id" => $erta["academicyear_id"],
                    "publish_date" => date('Y-m-d', strtotime($erta["publish_date"])),
                    "publish_status" => "1",
                ]);
            }
        }
        */

        $examresultdate_array = array(
            /*array("programme_id" => "7", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "12", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "28", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "28", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "6", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "6", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "4", "academicyear_id" => "1", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "4", "academicyear_id" => "6", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "30", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "30", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "18", "term" => "1", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "1", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "6", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "1", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "6", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "7", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "8", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "4", "academicyear_id" => "1", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "4", "academicyear_id" => "6", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),
            array("programme_id" => "11", "academicyear_id" => "8", "publish_date" => "16-08-2022", "exam_id" => "19", "term" => "2", "publish_status" => 1),*/
            array("programme_id" => "7", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "6", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "28", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "30", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "12", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "8", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "8", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "11", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "11", "academicyear_id" => "7","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "7", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "6", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "28", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "30", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "12", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "8", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "8", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "29", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "3", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "11", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "11", "academicyear_id" => "8","publish_date" => "31-05-2023", "exam_id" => "21","term" => "2","publish_status" => 1),
            array("programme_id" => "7", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "28", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "30", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "12", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "20", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "32", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "8", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "2", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "31", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
            array("programme_id" => "11", "academicyear_id" => "9","publish_date" => "31-05-2023", "exam_id" => "21","term" => "1","publish_status" => 1),
           

        );

        foreach ($examresultdate_array as $erta) {
            $ert = Examresultdate::where('exam_id', $erta["exam_id"])->where('programme_id', $erta["programme_id"])
                ->where('academicyear_id', $erta["academicyear_id"])->first();

            if(is_null($ert)) {
                Examresultdate::create([
                    "exam_id" => $erta["exam_id"],
                    "programme_id" => $erta["programme_id"],
                    "academicyear_id" => $erta["academicyear_id"],
                    "publish_date" => date('Y-m-d', strtotime($erta["publish_date"])),
                    "publish_status" => $erta["publish_status"],
                ]);
            }
            else {
                unset($ert);
            }
            unset($erta);
        }
    }
}
