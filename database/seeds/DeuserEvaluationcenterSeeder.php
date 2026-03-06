
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Externalexamcenter;
use App\User;

class DeuserEvaluationcenterSeeder extends Seeder
{
    public function run()
    {
        //
        $data = array(
            ['id'=>24, 'code' =>'DEEVCCH01','password'=>'87296@VQPW'],
            ['id'=>26, 'code' =>'DEEVCGJ01','password'=>'63033@UBEE'],
            ['id'=>28, 'code' =>'DEEVCKE01','password'=>'10057@FVSG'],
            ['id'=>29, 'code' =>'DEEVCMH01','password'=>'67727@PXED'],
            ['id'=>31, 'code' =>'DEEVCTN01','password'=>'79130@VVME'],
            ['id'=>33, 'code' =>'DEEVCUP01','password'=>'77150@QHLP'],
            ['id'=>34, 'code' =>'DEEVCUP02','password'=>'14272@YHGO'],
            ['id'=>35, 'code' =>'DEEVCWB01','password'=>'41448@YJXT'],
            ['id'=>38, 'code' =>'DEEVCMP01','password'=>'95505@XWEV'],
            ['id'=>40, 'code' =>'DEEVCAP01','password'=>'63813@GHQH'],
            ['id'=>41, 'code' =>'DEEVCAS01','password'=>'31640@SGOY'],
            ['id'=>42, 'code' =>'DEEVCBI01','password'=>'30892@REXK'],
            ['id'=>43, 'code' =>'DEEVCCA01','password'=>'42591@QDPE'],
            ['id'=>44, 'code' =>'DEEVCHP01','password'=>'71518@CHFE'],
            ['id'=>45, 'code' =>'DEEVCJH01','password'=>'65383@EPDN'],
            ['id'=>46, 'code' =>'DEEVCKA09','password'=>'19735@ALUY'],
            ['id'=>48, 'code' =>'DEEVCTL01','password'=>'73212@WAVV'],
            ['id'=>49, 'code' =>'DEEVCUK01','password'=>'47613@LZPI'],
            ['id'=>50, 'code' =>'DEEVCUP03','password'=>'91657@RVTJ'],
            ['id'=>51, 'code' =>'DEEVCUP04','password'=>'95908@LHFJ'],
            ['id'=>52, 'code' =>'DEEVCMH02','password'=>'46132@FJSH'],
            ['id'=>53, 'code' =>'DEEVCAR01','password'=>'97246@SQVK'],
            ['id'=>56, 'code' =>'DEEVCMG01','password'=>'86159@DKKM'],
            ['id'=>57, 'code' =>'DEEVCMH03','password'=>'92971@ETQG'],
            ['id'=>58, 'code' =>'DEEVCOR02','password'=>'22510@BQQD'],
            ['id'=>59, 'code' =>'DEEVCJK01','password'=>'10474@LKIC'],
            ['id'=>60, 'code' =>'DEEVCMN01','password'=>'51578@XIPC'],
            ['id'=>61, 'code' =>'DEEVCMZ01','password'=>'58502@RNQW'],
            ['id'=>62, 'code' =>'DEEVCUTR01','password'=>'84251@NJEX'],
        );
        
        foreach ($data as $d) {
            $u = \App\User::create([
                "username" => $d["code"],
                "password" => Hash::make($d["password"]),
                "confirmed" => 1,
                "usertype_id" => 8
            ]);
            $ec = \App\Evaluationcenter::find($d['id']);
            $ec->deuser_id= $u->id;
            $ec->save();
        }
    }
}