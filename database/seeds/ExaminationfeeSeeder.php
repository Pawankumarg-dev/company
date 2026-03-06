<?php

use Illuminate\Database\Seeder;
use App\Examinationfee;
use App\Programme;
use App\Academicyear;
use App\Exam;

class ExaminationfeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $examinationfees = [
            // ["programme_id"  => "7 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "6 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "28 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "30 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "12 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "20 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "8 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "29 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "3 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "2 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "11 ", "academicyear_id"  => "7", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "7 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "6 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "28 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "30 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "12 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "20 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "8 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "29 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "3 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "2 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "11 ", "academicyear_id"  => "8", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "7 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "28 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "30 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "12 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "20 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "32 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "8 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "2 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "31 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            // ["programme_id"  => "11 ", "academicyear_id"  => "9", "exam_fee" => "150 ", "late_fee"  => "0 ", "ontimepayment_startdate"=> "2023-04-15","ontimepayment_enddate"=> "2023-05-05","exam_id"=> "21"],
            ["programme_id"=>"7","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"6","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"28","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"30","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"12","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"20","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"8","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"29","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"3","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"2","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"11","academicyear_id"=>"7","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"7","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"6","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"28","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"30","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"12","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"20","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"8","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"29","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"3","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"2","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"11","academicyear_id"=>"8","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"7","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"28","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"30","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"12","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"20","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"32","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"8","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"2","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"31","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"11","academicyear_id"=>"9","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"7","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"28","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"30","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"12","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"20","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"32","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"8","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"2","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"31","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            ["programme_id"=>"11","academicyear_id"=>"10","exam_fee"=>"100","late_fee"=>"0","ontimepayment_startdate"=>"2023-06-20","ontimepayment_enddate"=>"2023-07-20","exam_id"=>"22"],
            
];
            
          
 foreach ($examinationfees as $ex) {
                Examinationfee::updateOrCreate(
                    [

                    "exam_id" => $ex["exam_id"],
                    "programme_id" => $ex["programme_id"],
                    "academicyear_id" => $ex["academicyear_id"],
                    "exam_fee" => $ex["exam_fee"],
                    "late_fee" => $ex["late_fee"],
                    "ontimepayment_startdate" => $ex["ontimepayment_startdate"],
                    "ontimepayment_enddate" => $ex["ontimepayment_enddate"],
                    "active_status" => "1",
                ]
            );
         }
    }
}
