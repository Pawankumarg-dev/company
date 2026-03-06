<?php

use Illuminate\Database\Seeder;
use App\Exambatch;
use App\Programme;
use App\Academicyear;
use App\Exam;

class ExambatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exambatches = [
            // ["exam_id" => 21, "programme_id" =>7, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>6, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>28, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>30, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>12, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>20, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>20, "academicyear_id"  =>7, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>8, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>8, "academicyear_id"  =>7, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>29, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>29, "academicyear_id"  =>7, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>3, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>3, "academicyear_id"  =>7, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>2, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>2, "academicyear_id"  =>7, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>11, "academicyear_id"  =>7, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>11, "academicyear_id"  =>7, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>7, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>6, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>28, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>30, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>12, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>20, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>20, "academicyear_id"  =>8, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>8, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>8, "academicyear_id"  =>8, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>29, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>29, "academicyear_id"  =>8, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>3, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>3, "academicyear_id"  =>8, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>2, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>2, "academicyear_id"  =>8, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>11, "academicyear_id"  =>8, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>11, "academicyear_id"  =>8, "term"  =>2],
            // ["exam_id" => 21, "programme_id" =>7, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>28, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>30, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>12, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>20, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>32, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>8, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>2, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>31, "academicyear_id"  =>9, "term"  =>1],
            // ["exam_id" => 21, "programme_id" =>11, "academicyear_id"  =>9, "term"  =>1],
            ["exam_id" => 22, "programme_id" =>7,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>6,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>28,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>30,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>12,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>7,"term"=>2],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>7,"term"=>2],
            ["exam_id" => 22, "programme_id" =>29,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>29,"academicyear_id"=>7,"term"=>2],
            ["exam_id" => 22, "programme_id" =>3,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>3,"academicyear_id"=>7,"term"=>2],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>7,"term"=>2],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>7,"term"=>1],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>7,"term"=>2],
            ["exam_id" => 22, "programme_id" =>7,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>6,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>28,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>30,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>12,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>8,"term"=>2],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>8,"term"=>2],
            ["exam_id" => 22, "programme_id" =>29,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>29,"academicyear_id"=>8,"term"=>2],
            ["exam_id" => 22, "programme_id" =>3,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>3,"academicyear_id"=>8,"term"=>2],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>8,"term"=>2],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>8,"term"=>1],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>8,"term"=>2],
            ["exam_id" => 22, "programme_id" =>7,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>28,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>30,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>12,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>9,"term"=>2],
            ["exam_id" => 22, "programme_id" =>32,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>32,"academicyear_id"=>9,"term"=>2],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>9,"term"=>2],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>9,"term"=>2],
            ["exam_id" => 22, "programme_id" =>31,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>31,"academicyear_id"=>9,"term"=>2],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>9,"term"=>1],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>9,"term"=>2],
            ["exam_id" => 22, "programme_id" =>7,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>28,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>30,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>12,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>20,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>32,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>8,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>2,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>31,"academicyear_id"=>10,"term"=>1],
            ["exam_id" => 22, "programme_id" =>11,"academicyear_id"=>10,"term"=>1],
            
        ];
        
        foreach ($exambatches as $exambatch) {
            Exambatch::updateOrCreate(
                    [
                        "exam_id"         => $exambatch["exam_id"],
                        "programme_id"    => $exambatch["programme_id"],
                        "academicyear_id" => $exambatch["academicyear_id"],
                        "term"            => $exambatch["term"],
                    ]
            );
         }
    }
}
