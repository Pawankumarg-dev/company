<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Approvedprogramme;

use App\Institute;

use App\Nber;

use Auth;

use Session;

use App\Enrolmentfeepayment;

use App\Services\EnrolmentFee\RecheckService;


class EnrolmentfeeController extends Controller
{
    private $recheckService;

    public function __construct(RecheckService $recheck)
    {
        $this->middleware(['role:institute']);
        $this->recheckService = $recheck;
    }

    public function index() {
        $academicyear_id = Session::get('academicyear_id');
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $approvedprogrammes = Approvedprogramme::where('institute_id',$institute_id)->where('academicyear_id',$academicyear_id)->with('programme')->get();
        $nbers = Nber::all();
        $enrolmentfees  = Enrolmentfeepayment::where('institute_id',$institute_id)->where('academicyear_id',$academicyear_id)->get();
       // $order_ids = \App\Enrolmentfeepayment::where('institute_id',$institute_id)->where('academicyear_id',$academicyear_id)->where('nber_id',$n->id)->pluck('order_id')->toArray(); 
        //$paid = \App\Order::whereIn('id',$order_ids)->sum('actual_amount');
        return view('institute.enrolmentfee.index',compact('approvedprogrammes','nbers','institute_id','enrolmentfees'));
    }

    public function recheck($id,$fid){
        return $this->recheckService->recheck($id,$fid);
    }
}
