<?php

use Illuminate\Database\Seeder;
use App\Academicyear;
class AcademicyearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Academicyear::create(['year'=>'1']);
 
    }
}
