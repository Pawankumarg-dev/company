<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Institute;

use Session;

class AffiliationfeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:reports']);
    }
    public function index(){
        $acdemicyear_id = Session::get('academicyear_id');
        $acdemicyear_id = 11;
        $institutes_all_ids = Institute::whereHas('approvedprogrammes',function($q) use($acdemicyear_id){
            $q->whereIn('academicyear_id',[$acdemicyear_id,$acdemicyear_id-1]);
        })->where('id','!=',1004)->pluck('id')->toArray();

        $institutes_paid_ids = Institute::whereHas('affiliationfees',function($q) use($acdemicyear_id){
            $q->where('academicyear_id',$acdemicyear_id)->where('orderstatus_id',1);
        })->where('id','!=',1004)->pluck('id')->toArray();

        $institutes_paid = Institute::whereIn('id',$institutes_paid_ids)->with('affiliationfees')->get();
        $institutes_not_paid = Institute::whereIn('id',array_diff($institutes_all_ids,$institutes_paid_ids))->get();
        return view('reports.affiliationfee.index',compact('institutes_paid','institutes_not_paid'));
    }
}
