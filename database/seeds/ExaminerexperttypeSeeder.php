<?php

use Illuminate\Database\Seeder;
use App\ExaminerExperttype;

class ExaminerexperttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $examinerexperttype_array = array(
            array("name" => "Center Level Observer", "abbreviation" => "CLO"),
            array("name" => "External Examiner", "abbreviation" => "EXE"),
            array("name" => "Evaluator", "abbreviation" => "EVA"),
            array("name" => "Question Paper Setter", "abbreviation" => "QPS"),
        );

        foreach ($examinerexperttype_array as $e) {
            if(ExaminerExperttype::where("name", $e["name"])->count() == '0') {
                ExaminerExperttype::create([
                    "name" => $e["name"],
                    "abbreviation" => $e["abbreviation"],
                ]);
            }
        }
    }
}
