<?php

use Illuminate\Database\Seeder;

class DespatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $despatch_array = array(
            array("vendor_name" => "Indian Post", "product_name" => "Speed Post", "tracking_url" => "https://www.indiapost.gov.in/MBE/Pages/Content/Speed-Post.aspx", "active_status" => "1"),
        );
    }
}
