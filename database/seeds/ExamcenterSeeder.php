<?php

use Illuminate\Database\Seeder;
use \App\Examcenter;
use \App\Institute;

class ExamcenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $centers = array(
            array("institute" => "AP04", "examcenter" => "AP04" ),
            array("institute" => "AP09", "examcenter" => "AP09" ),
            array("institute" => "AP13", "examcenter" => "AP13" ),
            array("institute" => "DL05", "examcenter" => "DL05" ),
            array("institute" => "DL03", "examcenter" => "DL05" ),
            array("institute" => "DL11", "examcenter" => "DL11" ),
            array("institute" => "GA02", "examcenter" => "GA02" ),
            array("institute" => "HY03", "examcenter" => "HY03" ),
            array("institute" => "HY01", "examcenter" => "HY13" ),
            array("institute" => "OR02", "examcenter" => "OR02" ),
            array("institute" => "TL13", "examcenter" => "TL13" ),
            array("institute" => "TN02", "examcenter" => "TN02" ),
            array("institute" => "UP02", "examcenter" => "UP02" ),
            array("institute" => "UP16", "examcenter" => "UP16" ),
            array("institute" => "UP09", "examcenter" => "UP47" ),
            array("institute" => "UP30", "examcenter" => "UP41" ),
            array("institute" => "UP34", "examcenter" => "UP34" ),
            array("institute" => "GJ01", "examcenter" => "GJ01" ),
            array("institute" => "MH30", "examcenter" => "MH30" ),
            array("institute" => "MP05", "examcenter" => "MP05" ),
            array("institute" => "RJ06", "examcenter" => "RJ06" ),
        );

        foreach ($centers as $c) {
            $institute_id = Institute::where('code', $c["institute"])->first()->id;
            $examcenter_id = '';
            if($c["institute"] == $c["examcenter"]) {
                $examcenter_id = $institute_id;
            }
            else {
                $examcenter_id = Institute::where('code', $c["examcenter"])->first()->id;
            }
            $ec = Examcenter::where('institute_id', $institute_id)->where('exam_id', '6')->first();

            if(is_null($ec)) {
                Examcenter::create([
                    "institute_id" => $institute_id,
                    "examcenter_id" => $examcenter_id,
                    "exam_id" => "6",
                ]);
            }

        }
    }
}