<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
       $users = array(
           array("id" => "1759", "password" => "jeopaul@123"),
           array("id" => "1760", "password" => "SaranPoovi001"),
           array("id" => "1761", "password" => "BrightNber@2019"),
           array("id" => "1762", "password" => "Ilovenber_A1"),
           array("id" => "1763", "password" => "*kothandan79"),
           array("id" => "1764", "password" => "SOBILOVE"),
           array("id" => "1765", "password" => "kathir10779"),
           array("id" => "1766", "password" => "Hybiscus40"),
           array("id" => "1768", "password" => "archana@123"),
           array("id" => "1769", "password" => "ruby@1980"),
           array("id" => "1770", "password" => "Sanmanbvc"),
           array("id" => "1773", "password" => "NiepmdNberandragogy7"),
           array("id" => "1777", "password" => "!nber@123"),
           array("id" => "1778", "password" => "Abijit@1991"),
           array("id" => "1779", "password" => "Irayi@19"),
           array("id" => "22837", "password" => "!nber@123"),
            array("username" => "PJ03", "password" => "15JsAk219")
       );

        $users = array(
            //array("username" => "KE17", "password" => "2017ek2po")
            array("username" => "KA03", "password" => "2014iRc62")
        );

        foreach($users as $u) {

            $user = User::where('username', $u["username"])->first();
            $user->update([
                "password" => bcrypt($u["password"]),
                "confirmation_code" => $u["password"]
            ]);

            User::where("username", $u["username"])->update([
                "password" => bcrypt($u["password"]),
                "confirmation_code" => $u["password"]
            ]);
        }
        */

        //$this->createUser();
        $this->updateUser();
    }

    public function createUser() {
        $users = array(
            //array("username" => "ansaari", "password" => "Arifansaari", "email" => "Ibmansaari1998@gmail.com"),
            //array("username" => "shobhaodunavar", "password" => "2020@shobha", "email" => "shobha.odunavar2010@gmail.com"),
            //array("username" => "jahidulislam", "password" => "aduri781127", "email" => "islamjahidul98765@gmail.com"),
            //array("username" => "stamanna", "password" => "tamannaayubi", "email" => "tamannamehar@gmail.com"),
            //array("username" => "sumitra", "password" => "Pragasum", "email" => "sumitramanoharan50@gmail.com"),
            //array("username" => "nithya", "password" => "Nithyakathir", "email" => "nithy.mdu@gmail.com"),
            //array("username" => "accountadmin", "password" => "accountadmin", "email" => "accountadmin@gmail.com"),
            //array("username" => "mathivanan", "password" => "mathi198414", "email" => "vrmathivanan@gmail.com", "usertype_id" => "1"),
            //array("username" => "ramamurthi", "password" => "ram0306", "email" => "rammsbioinfo@gmail.com", "usertype_id" => "1"),
            //array("username" => "shylaja", "password" => "1234", "email" => "shylaja_theetharappan@yahoo.com", "usertype_id" => "1"),
            //array("username" => "Meenakshi", "password" => "Meena@2022", "email" => "ks.meenaraman@gmail.com", "usertype_id" => "1"),
        );

        foreach ($users as $user) {
            User::firstOrCreate([
                "username" => $user["username"],
                "password" => bcrypt($user["password"]),
                "email" => $user["email"],
                "usertype_id" => $user["usertype_id"],
                "confirmation_code"=> $user["password"]
            ]);
        }
    }

    public function updateUser() {
        $users = array(
            /*array("username" => "mathivanan", "password" => "mathi198414"),*/
            array("username" => "mathivanan", "password" => "Nber@ADCE"),
            array("username" => "ramamurthi", "password" => "lingu@0306"),
            array("username" => "Meenakshi", "password" => "notactive"),
            
            

            /*
            array("username" => "jahidulislam", "password" => "notactive"),
            array("username" => "sumitra", "password" => "notactive"),
            array("username" => "nqanapriya", "password" => "notactive"),
            array("username" => "hy15", "password" => "hy152021"),
            array("username" => "nithya", "password" => "notactive"),
            array("username" => "bharath", "password" => "notactive"),
            */
        );

        foreach ($users as $user) {
            User::where("username", $user["username"])->update([
                "password" => bcrypt($user["password"]),
                "confirmation_code"=> $user["password"]
            ]);
        }
    }
}
