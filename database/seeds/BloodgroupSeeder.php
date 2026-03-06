<?php

use Illuminate\Database\Seeder;
use App\Bloodgroup;

class BloodgroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bloodgroup = array(
            array("type"=>"	A+"),
            array("type"=>"	A-"),
            array("type"=>"	B+"),
            array("type"=>"	B-"),
            array("type"=>"	O+"),
            array("type"=>"	O-"),
            array("type"=>"	AB+"),
            array("type"=>"	AB-"),
        );

        foreach ($bloodgroup as $bg) {
            $type = Bloodgroup::where('type', $bg['type'])->first();

            if(is_null($type)) {
                Bloodgroup::create(['type' => $bg['type']]);
            }
        }
    }
}
