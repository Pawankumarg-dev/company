<?php

use Illuminate\Database\Seeder;
use App\Evaluationcenter;

class EvaluationcenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->addEvaluationCenter();
        //$this->updatePassword();

    }

    public function addEvaluationCenter() {
        
        $details = array(

            /*array("code" => "EVCDL02", "password" => "", "name" => "Amar Jyoti Research and Rehabilitation Center", "address" => "Marg Road Number 72, Karlardooma, Anand Vihar", "state" => "New Delhi", "pincode" => "110092", "active_status" => "1"),
            array("code" => "EVCMP01", "password" => "", "name" => "CRC-Bhopal", "address" => "hajuri Kalan Rd, Nagarjun Nagar, Piplani, Gopal Nagar, Bhopal", "state" => "Madhya Pradesh", "pincode" => "462021", "active_status" => "1"),
            array("code" => "EVCTN04", "password" => "", "name" => "NIEPMD", "address" => "ECR, Muttukadu, Kovalam Post, Chennai", "state" => "Tamil Nadu", "pincode" => "603112", "active_status" => "1"),
            array("code"=>"EVCAP01","password"=>"23MGKGW","name"=>"Composite Regional Centre (CRC), Nellore","address"=>"Jubilee Hospital St, Somasekara Puram, Nellore","state"=>"Andhra Pradesh ","pincode"=>"524001","active_status"=>"1"),
            array("code"=>"EVCAS01","password"=>"NPKKG23","name"=>"Composite Regional Centre (CRC), Guwahati","address"=>"Guwahati Medical College Hospital Campus Post Office Indrapur, GMC Hospital Rd, Bhangagarh, Guwahati","state"=>"Assam","pincode"=>"781032","active_status"=>"1"),
            array("code"=>"EVCBI01","password"=>"MKK23SS","name"=>"Composite Regional Centre (CRC), Patna","address"=>"Sheikhpura (Old Dharmshala), Near Igims Nursing College, Sheikhpura, GPO Patna Post Office, Patna Dist., Landmark - Near IGIMS Nursing College","state"=>"Bihar","pincode"=>"800014","active_status"=>"1"),
            array("code"=>"EVCCA01","password"=>"23FRWS","name"=>"Govt. Rehabilitation Institute For Intellectual Disabilities (Griid) Chandigarh","address"=>"Government Rehabilitation Institute For Intellectual Disabilities, Sector 31 C, Chandigarh Post Office, Chandigarh Dist, "state"=> "Chandigarh", "pincode"=> "160047","active_status"=> "1"), 
            array("code"=>"EVCCH01","password"=>"UN23SET","name"=>"Composite Regional Centre (CRC) Rajnadgaon","address"=>"Old Hospital Campus","state"=>"Chhattisgarh","pincode"=>"491441","active_status"=>"1"),
            array("code"=>"EVCGJ01","password"=>"23KWRQB","name"=>"Composite Regional Centre (CRC), Ahmedabad","address"=>"435/8/1, Bhikshukhgruh Rd, G I D C Industrial Area, Odhav, Ahmedabad","state"=>"Gujarat","pincode"=>"382415","active_status"=>"1"),
            array("code"=>"EVCHP01","password"=>"HKS23FN","name"=>"Composite Regional Centre (CRC), Sundernagar","address"=>"Distt Mandi, Himachal Pradesh, Chatrokhari Sundernagar Post Office, Mandi Dist.","state"=>"Himachal Pradesh","pincode"=>"175018","active_status"=>"1"),
            array("code"=>"EVCUP01","password"=>"NEQ23ST","name"=>"NIEPID, RC, Noida","address"=>"C44/A, Sector, 40 Noida","state"=>"Uttar Pradesh","pincode"=>"201301","active_status"=>"1"),
            array("code"=>"EVCJH01","password"=>"PK23CJT","name"=>"Composite Regional Centre (CRC), Ranchi","address"=>"Besides Block Office, Khijri , Namkum, Ranchi""","state"=>"Jharkhand","pincode"=>"834010","active_status"=>"1"),
            array("code"=>"EVCKA09","password"=>"WX23LSP","name"=>"Composite Regional Centre (CRC), Davengere","address"=>"Devaraj Urs Layout B -Block, Blind School CampusDavanagere""","state"=>"Karnataka","pincode"=>"577006","active_status"=>"1"),
            array("code"=>"EVCKE01","password"=>"AED23KZ","name"=>"Composite Regional Centre (CRC), Kozhikode","address"=>"CRC Campus, Golf Link Road, Chevayur P.O. Kozhikode","state"=>"Kerala","pincode"=>"673017","active_status"=>"1"),
            array("code"=>"EVCMH01","password"=>"RGM23WH","name"=>"Composite Regional Centre (CRC), Nagpur","address"=>"Krida Prabodhini Hall, Yashwant Stadium, Dhantoli, Nagpur","state"=>"Maharashtra","pincode"=>"440012","active_status"=>"1"),
            array("code"=>"EVCMP01","password"=>"23LDADF","name"=>"Composite Regional Centre (CRC), Bhopal","address"=>"Khajuri Kalan Rd, Nagarjun Nagar, Piplani, Gopal Nagar, Bhopal","state"=>"Madhya Pradesh","pincode"=>"462021","active_status"=>"1"),
            array("code"=>"EVCOR01","password"=>"23NWJYW","name"=>"Ali Yavar Jung National Institute of Speech & Hearing Disabilities (Regional Centre)","address"=>"At/P.O, Janla Dist, Khordha, Bhuvaneswar","state"=>"Odisha","pincode"=>"752054","active_status"=>"1"),
            array("code"=>"EVCCA01","password"=>"23FRWS","name"=>"Govt. Rehabilitation Institute For Intellectual Disabilities (Griid), Chandigarh","address"=>"Government Rehabilitation Institute For Intellectual Disabilities, Sector 31 C, Chandigarh Post Office, Chandigarh Dist.","state"=>"Chandigarh","pincode"=>"160047","active_status"=>"1"),
            array("code"=>"EVCRJ01","password"=>"DYK23CE","name"=>"Vardhman Mahaveer open University, Kota","address"=>"Rawatbhata Rd, Vardhaman Mahaveer Open University, Akelgarh, Kota","state"=>"Rajasthan","pincode"=>"324021","active_status"=>"1"),
            array("code"=>"EVCTL16","password"=>"UKSCN23","name"=>"NIEPID, Secunderabad","address"=>"Manovikas Nagar, Bowenpally","state"=>"Telangana","pincode"=>"500009","active_status"=>"1"),
            array("code"=>"EVCTN01","password"=>"JMR23XO","name"=>"NIEPMD, Chennai","address"=>"East Coast Road, Muttukadu, Kovalm Post, Chennai","state"=>"Tamil Nadu","pincode"=>"603112","active_status"=>"1"),
            array("code"=>"EVCUP02","password"=>"FEGUZ23","name"=>"Composite Regional Centre (CRC), Lucknow","address"=>"Lucknow, Mohaan Road, Near Mohaan Road Police Chowki, Lucknow","state"=>"Uttar Pradesh","pincode"=>"226017","active_status"=>"1"),
            array("code"=>"EVCUP03","password"=>"23NELGS","name"=>"Composite Regional Centre (CRC), Gorakhpur","address"=>"10, Park Road, Civil Lines, Gorakhpur","state"=>"Uttar Pradesh","pincode"=>"273001","active_status"=>"1"),
            array("code"=>"EVCUP04","password"=>"AWJ23PR","name"=>"AYJNISHD, RC, Noida","address"=>"Plot No.44-A, Block -C, Sector -40, Noida","state"=>"Uttar Pradesh","pincode"=>"201301","active_status"=>"1"),
            array("code"=>"EVCWB01","password"=>"SJ23MEX","name"=>"Ali Yavar Jung National Institute of Speech and Hearing Disabilities- Regional Centre, Kolkata","address"=>"B.T. Road, Bonhooghly, Kolkata","state"=>"West Bengal","pincode"=>"700090","active_status"=>"1"),*/
            array("code"=>"EVCMH02","password"=>"MR23MEX","name"=>"Ali Yavar Jung National Institute of Speech and Hearing Disabilities- Mumbai","address"=>"K.C. Marg, Bandra (W) Reclamation Mumbai","state"=>"Maharastra","pincode"=>"400050","active_status"=>"1"),
            array("code"=>"EVCUK01","password"=>"MR23UK01","name"=>"NIEPVD, Dehradun","address"=>"116, Rajpur Rd, Jakhan, Dehradun, Dehradun","state"=>"Uttarakhand","pincode"=>"248001","active_status"=>"1"),

        );

        foreach ($details as $d) {
            $evaluationcenter = Evaluationcenter::where('code', $d["code"])->first();

            if(is_null($evaluationcenter)) {
                Evaluationcenter::create([
                    "code" => trim(strtoupper($d["code"])),
                    "password" => trim(strtoupper($d["password"])),
                    "name" => trim($d["name"]),
                    "address" => trim($d["address"]),
                    "state" => trim($d["state"]),
                    "pincode" => trim($d["pincode"]),
                    "active_status" => $d["active_status"]
                ]);
            }
            else {
                $evaluationcenter->update([
                    "password" => trim(strtoupper($d["password"])),
                    "name" => trim($d["name"]),
                    "address" => trim($d["address"]),
                    "state" => trim($d["state"]),
                    "pincode" => trim($d["pincode"]),
                    "active_status" => $d["active_status"]
                ]);
            }
        }
    }

    public function updatePassword() {
        $details = array(
            /*array("code" => "EVCDL01", "password" => "618188", "active_status" => "1"),
            array("code" => "EVCDL02", "password" => "346817", "active_status" => "1"),
            array("code" => "EVCHY01", "password" => "317125", "active_status" => "1"),
            array("code" => "EVCCH01", "password" => "620558", "active_status" => "1"),
            array("code" => "EVCMH01", "password" => "205208", "active_status" => "1"),
            array("code" => "EVCMP01", "password" => "473840", "active_status" => "1"),
            array("code" => "EVCGJ01", "password" => "663048", "active_status" => "1"),
            array("code" => "EVCKE01", "password" => "542405", "active_status" => "1"),
            array("code" => "EVCWB01", "password" => "952302", "active_status" => "1"),
            array("code" => "EVCOR01", "password" => "351352", "active_status" => "1"),
            array("code" => "EVCTN01", "password" => "627640", "active_status" => "1"),
            array("code" => "EVCTN02", "password" => "293272", "active_status" => "1"),
            array("code" => "EVCTN03", "password" => "802491", "active_status" => "1"),
            array("code" => "EVCTN04", "password" => "837952", "active_status" => "1"),
            array("code" => "EVCTN01", "password" => "JMR23XO", "active_status" => "1"),*/
            array("code"=> "EVCAP01","password"=> "APVE@21","active_status" => "1"),
            array("code"=> "EVBI01","password"=> "BIVE@21","active_status" => "1"),
            array("code"=> "EVCCA01","password"=> "CAVE@21","active_status" => "1"),
            array("code"=> "EVCUP02","password"=> "CUPVE@21","active_status" => "1"),
            array("code"=> "EVCGJ01","password"=> "CGVE@21","active_status" => "1"),
            array("code"=> "EVCHP01","password"=> "CHPVE@23","active_status" => "1"),
            array("code"=> "EVCJH01","password"=> "CJHEV@MAY23","active_status" => "1"),
            array("code"=> "EVCKE01","password"=> "KLVE@21","active_status" => "1"),
            array("code"=> "EVCMH01","password"=> "CMHVE@23","active_status" => "1"),
            array("code"=> "EVCMP01","password"=> "CMPVE@21","active_status" => "1"),
            array("code"=> "EVCOR01","password"=> "CORVE@21","active_status" => "1"),
            array("code"=> "EVCTL16","password"=> "CTLVE@21","active_status" => "1"),
            array("code"=> "EVCUP01","password"=> "MSE@UP","active_status" => "1"),
            array("code"=> "EVCUP03","password"=> "UPVE@23","active_status" => "1"),
            array("code"=> "EVCWB01","password"=> "WBVE@2023","active_status" => "1"),
            array("code"=> "EVCKA09","password"=> "KAVE@21","active_status" => "1"),

            

        );

        foreach ($details as $d) {
            $evaluationcenter = Evaluationcenter::where('code', $d["code"])->first();

            if($evaluationcenter) {
                $evaluationcenter->update([
                    "password" => trim(strtoupper($d["password"])),
                    "active_status" => $d["active_status"],
                ]);
            }
        }
    }
}
