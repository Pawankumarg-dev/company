<?php

use Illuminate\Database\Seeder;
use App\Relationtype;

class RelationtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $relation_array = array(
            array("name" => "Father"),
            array("name" => "Mother"),
            array("name" => "Husband"),
            array("name" => "Guardian"),
        );

        foreach ($relation_array as $r) {
            if(Relationtype::where("name", $r["name"])->count() == '0') {
                Relationtype::create([
                    "name" => $r["name"],
                ]);
            }
        }
    }
}
