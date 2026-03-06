<?php

use Illuminate\Database\Seeder;

class CoursecoordinatorcoursetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = array(
            array('council_name' => 'Rehabilitation Council of India', 'council_code' => 'RCI', 'certificate_name' => 'Central Rehabilitation Register Number', 'certificate_code' => 'CRR No.'),
            array('council_name' => 'State Nursing Council', 'council_code' => 'SNC', 'certificate_name' =>'Registered Nurse & Registered Midwife Number', 'certificate_code' => 'RN&RM No.'),
        );

        foreach ($data as $d) {
            \App\Coursecoordinatorcoursetype::create([
                "council_name" => $d["council_name"],
                "council_code" => $d["council_code"],
                "certificate_name" => $d["certificate_name"],
                "certificate_code" => $d["certificate_code"],
            ]);
        }
    }
}
