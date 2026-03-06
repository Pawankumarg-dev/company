<?php

use Illuminate\Database\Seeder;

use App\Salutation;
class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Salutation::create(['salutation'=>'S/O']);
		Salutation::create(['salutation'=>'D/O']);
		Salutation::create(['salutation'=>'W/O']);
	}
}