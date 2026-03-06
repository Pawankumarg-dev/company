<?php

namespace App\Http\Controllers\Nber;

use App\Nberstaff;
use App\Title;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Http\Requests;
use App\Programme;
use App\Configuration;

use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(){
        $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        $verification = DB::select("select 
            u.username as username, 
            i.name as institute, 
            p.abbreviation as programme, 
            ap.maxintake as maxintake,  count(c.id) as applications_received, sum(if(c.status_id=6,1,0)) as not_verified,  sum(if(c.status_id=2,1,0)) as verified, sum(if(c.status_id=1,1,0)) as rejected   from approvedprogrammes ap
        left join institutes i  on i.id = ap.institute_id
        left join programmes p on p.id = ap.programme_id
        left join nbers n on n.id = p.nber_id
        left join users u on u.id = i.user_id
        left outer join candidates c on c.approvedprogramme_id = ap.id
        where  p.nber_id = ".$nber_id."  and ap.academicyear_id = ".Session::get('academicyear_id')."  group by ap.id order  by u.username");
        //return $verification;
        return view('nber.dashboard.dashboard',compact('verification'));
    }
    public function changeayid($id){
        Session::put('academicyear_id',$id);
        return back();
    }
    public function showDashboard() {

    }
    public function settings(){
        $niname = Configuration::find(1);
        $logo = Configuration::find(2);
        $enrolment = Configuration::find(3);
        $offline = Configuration::where('attribute','offline')->first();
        $online = Configuration::where('attribute','online')->first();
        $ccavenue_working_key = Configuration::where('attribute','ccavenue_working_key')->first();
        $ccavenue_access_code = Configuration::where('attribute','ccavenue_access_code')->first();
        $ccavenue_merchant_id = Configuration::where('attribute','ccavenue_merchant_id')->first();

        $accountname = Configuration::where('attribute','accountname')->first();
        $bankname = Configuration::where('attribute','bankname')->first();
        $bankaddress = Configuration::where('attribute','bankaddress')->first();
        $accountnumber = Configuration::where('attribute','accountnumber')->first();
        $typeofaccount = Configuration::where('attribute','typeofaccount')->first();
        $ifsccode = Configuration::where('attribute','ifsccode')->first();
        
        return view('nber.settings.index',compact('niname','logo','enrolment','offline','online','ccavenue_access_code','ccavenue_merchant_id','ccavenue_working_key','accountname','bankname','bankaddress','accountnumber','typeofaccount','ifsccode'));
    }
    public function updatesettings(Request $r){
        $niname = Configuration::find(1);
        $enrolment = Configuration::find(3);

        $offline = Configuration::where('attribute','offline')->first();
        $online = Configuration::where('attribute','online')->first();
        $ccavenue_working_key = Configuration::where('attribute','ccavenue_working_key')->first();
        $ccavenue_access_code = Configuration::where('attribute','ccavenue_access_code')->first();
        $ccavenue_merchant_id = Configuration::where('attribute','ccavenue_merchant_id')->first();
        $accountname = Configuration::where('attribute','accountname')->first();
        $bankname = Configuration::where('attribute','bankname')->first();
        $bankaddress = Configuration::where('attribute','bankaddress')->first();
        $accountnumber = Configuration::where('attribute','accountnumber')->first();
        $typeofaccount = Configuration::where('attribute','typeofaccount')->first();
        $ifsccode = Configuration::where('attribute','ifsccode')->first();
        
        $offline->value = $r->offline;
        $offline->save();
        $online->value = $r->online;
        $online->save();
        $ccavenue_working_key->value =$r->ccavenue_working_key;
        $ccavenue_working_key->save();
        $ccavenue_access_code->value = $r->ccavenue_access_code;
        $ccavenue_access_code->save();
        $ccavenue_merchant_id->value = $r->ccavenue_merchant_id;
        $ccavenue_merchant_id->save();
        $niname->value = $r->niname;        
        $niname->save();
        $enrolment->value = $r->enrolment;
        $enrolment->save();
        $accountname->value = $r->accountname;
        $bankname->value = $r->bankname;
        $bankaddress->value = $r->bankaddress;
        $accountnumber->value = $r->accountnumber;
        $typeofaccount->value = $r->typeofaccount;
        $ifsccode->value = $r->ifsccode;
        $accountname->save();
        $bankname->save();
        $bankaddress->save();
        $accountnumber->save();
        $typeofaccount->save();
        $ifsccode->save();
        return back();
    }
}
