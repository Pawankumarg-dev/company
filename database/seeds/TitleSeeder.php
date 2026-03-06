<?php

use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
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
            array("title" => "Dr."),
            array("title" => "Mr."),
            array("title" => "Mrs."),
            array("title" => "Ms.")
        );
        
        foreach ($data as $d) {
            \App\Title::create([
                "title" => $d["title"]
            ]);
        }
    }
}
