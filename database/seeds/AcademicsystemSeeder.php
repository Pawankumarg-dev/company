<?php

use Illuminate\Database\Seeder;

use App\Academicsystem;
class AcademicsystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Academicsystem::create(['name'=>'Short Term','months'=>'3']);
        Academicsystem::create(['name'=>'Semester','months'=>'6']);
        Academicsystem::create(['name'=>'Yearly','months'=>'12']);
        Academicsystem::create(['name'=>'Trimester','months'=>'18']);
	}
}