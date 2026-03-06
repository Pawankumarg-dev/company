<?php

use Illuminate\Database\Seeder;
use App\Paymenttype;

class PaymenttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $paymenttype = array(
            array("type" => "Demand Draft", "abbreviation" => "DD"),
            array("type" => "National Electronic Funds Transfer", "abbreviation" => "NEFT"),
            array("type" => "Real Time Gross Settlement", "abbreviation" => "RTGS"),
        );


        foreach ($paymenttype as $pt) {
            $p = Paymenttype::where("abbreviation", $pt["abbreviation"])->first();

            if(is_null($p)) {
                Paymenttype::create([
                    "type" => $pt["type"],
                    "abbreviation" => $pt["abbreviation"],
                ]);
            }
        }
    }
}
