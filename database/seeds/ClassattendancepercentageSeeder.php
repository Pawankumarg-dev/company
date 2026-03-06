<?php

use Illuminate\Database\Seeder;
use App\Programme;
use App\Academicyear;
use App\Classattendancepercentage;

class ClassattendancepercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $percentages = array(
            array("course" => "DECSE (MR)", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-CP", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-ASD", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-MR", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DVR (MR)", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DCBR", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "CCCG", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-MD", "year" => "2017", "term"=> "2", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DECSE (MR)", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-CP", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-ASD", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "0", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-MR", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DVR (MR)", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DCBR", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "CCCG", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
            array("course" => "DEd-SE-MD", "year" => "2018", "term"=> "1", "minimum_theory_percentage" => "75", "minimum_practical_percentage" => "75", "exception_percentage" => "5", "scheme_of_examination" => " 2018", "active_status" => " 1"),
        );

        foreach($percentages as $pe) {
            $pid = Programme::where('abbreviation', $pe["course"])->first()->id;
            $ayid = Academicyear::where('year', $pe["year"])->first()->id;

            $percentage = Classattendancepercentage::where('programme_id', $pid)->where('academicyear_id', $ayid)->where('term', $pe["term"])->where('scheme_of_examination', $pe["scheme_of_examination"])->first();

            if(is_null($percentage)) {
                Classattendancepercentage::create([
                    "programme_id" => $pid,
                    "academicyear_id" => $ayid,
                    "term" => $pe["term"],
                    "minimum_theory_percentage" => $pe["minimum_theory_percentage"],
                    "minimum_practical_percentage" => $pe["minimum_practical_percentage"],
                    "exception_percentage" => $pe["minimum_practical_percentage"],
                    "scheme_of_examination" => $pe["scheme_of_examination"],
                    "active_status" => $pe["active_status"],
                ]);
            }
        }

    }
}
