
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Externalexamcenter;
use App\User;

class UserEvaluationcenterSeeder extends Seeder
{
    public function run()
    {
        //
        $data = array(
            ['id'=>24, 'code' =>'EVCCH01', 'password'=>'92971@XIPC'],
            ['id'=>26, 'code' =>'EVCGJ01', 'password'=>'22510@RNQW'],
            ['id'=>28, 'code' =>'EVCKE01', 'password'=>'10474@NJEX'],
            ['id'=>29, 'code' =>'EVCMH01', 'password'=>'51578@VQPW'],
            ['id'=>31, 'code' =>'EVCTN01', 'password'=>'58502@UBEE'],
            ['id'=>33, 'code' =>'EVCUP01', 'password'=>'84251@FVSG'],
            ['id'=>34, 'code' =>'EVCUP02', 'password'=>'87296@PXED'],
            ['id'=>35, 'code' =>'EVCWB01', 'password'=>'63033@VVME'],
            ['id'=>38, 'code' =>'EVCMP01', 'password'=>'10057@QHLP'],
            ['id'=>40, 'code' =>'EVCAP01', 'password'=>'67727@YHGO'],
            ['id'=>41, 'code' =>'EVCAS01', 'password'=>'79130@YJXT'],
            ['id'=>42, 'code' =>'EVCBI01', 'password'=>'77150@XWEV'],
            ['id'=>43, 'code' =>'EVCCA01', 'password'=>'14272@GHQH'],
            ['id'=>44, 'code' =>'EVCHP01', 'password'=>'41448@SGOY'],
            ['id'=>45, 'code' =>'EVCJH01', 'password'=>'95505@REXK'],
            ['id'=>46, 'code' =>'EVCKA09', 'password'=>'63813@QDPE'],
            ['id'=>48, 'code' =>'EVCTL01', 'password'=>'31640@CHFE'],
            ['id'=>49, 'code' =>'EVCUK01', 'password'=>'30892@EPDN'],
            ['id'=>50, 'code' =>'EVCUP03', 'password'=>'42591@ALUY'],
            ['id'=>51, 'code' =>'EVCUP04', 'password'=>'71518@WAVV'],
            ['id'=>52, 'code' =>'EVCMH02', 'password'=>'65383@LZPI'],
            ['id'=>53, 'code' =>'EVCAR01', 'password'=>'19735@RVTJ'],
            ['id'=>56, 'code' =>'EVCMG01', 'password'=>'73212@LHFJ'],
            ['id'=>57, 'code' =>'EVCMH03', 'password'=>'47613@FJSH'],
            ['id'=>58, 'code' =>'EVCOR02', 'password'=>'91657@SQVK'],
            ['id'=>59, 'code' =>'EVCJK01', 'password'=>'95908@DKKM'],
            ['id'=>60, 'code' =>'EVCMN01', 'password'=>'46132@ETQG'],
            ['id'=>61, 'code' =>'EVCMZ01', 'password'=>'97246@BQQD'],
            ['id'=>62, 'code' =>'EVCUTR01', 'password'=>'86159@LKIC']
        );
        
        foreach ($data as $d) {
            $u = \App\User::create([
                "username" => $d["code"],
                "password" => Hash::make($d["password"]),
                "confirmed" => 1,
                "usertype_id" => 7
            ]);
            $ec = \App\Evaluationcenter::find($d['id']);
            $ec->user_id= $u->id;
            $ec->save();
        }
    }
}