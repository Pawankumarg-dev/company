<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Approvedprogramme;
use App\Institute;
use Auth;
use App\Payment;
use App\Status;
use Session;


class PaymentController extends Controller
{
	public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(Request $request){
    	$payments = Payment::where('id','!=','0')->where('academicyear_id',Session::get('academicyear_id'));
		$status = '';
		$institute = '';	
    	if($request->has('transactionid')){
    		$payments = $payments->where('transactionid','like','%'.$request->transactionid.'%');
    	}
    	if($request->has('e')){
    		$payments = $payments->where('type',$request->e);
    	}
		if($request->has('i')){
    		$payments = $payments->where('institute_id',$request->i);
			$institute = Institute::find($request->i)->user->username;
    	}
		if($request->has('s')){
    		$payments = $payments->where('status_id',$request->s);
			$status = Status::find($request->s)->status;
    	}

    	$payments = $payments->paginate(5);
		
    	return view('nber.payments.index',compact('payments','status','institute'));
    }
	public function changestatus($status_id,$id){
		$p = Payment::find($id);
		$p->update(['status_id'=>$status_id]);
		$p->update(['updated_by'=>Auth::user()->id]);
		Session::put('message','updated');
		return back()->withInput();
	}

    public function payments() {
	    return view('nber.payments.newpayments');
    }
}
