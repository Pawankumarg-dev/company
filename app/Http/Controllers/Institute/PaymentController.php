<?php

namespace App\Http\Controllers\Institute;

use App\Application;
use App\Enrolmentfee;
use App\Exam;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Approvedprogramme;
use App\Institute;
use Auth;
use App\Payment;
use PDF;
use App\Configuration;

class PaymentController extends Controller
{
	public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function index(){
    	$instituteid = Institute::where('user_id',Auth::user()->id)->first()->id;
    	$payments = Payment::where('institute_id',$instituteid)->get();
    	$exam = Exam::all();

        $accountname = Configuration::where('attribute','accountname')->first();
        $bankname = Configuration::where('attribute','bankname')->first();
        $bankaddress = Configuration::where('attribute','bankaddress')->first();
        $accountnumber = Configuration::where('attribute','accountnumber')->first();
        $typeofaccount = Configuration::where('attribute','typeofaccount')->first();
        $ifsccode = Configuration::where('attribute','ifsccode')->first();
    	return view('institute.payments.index',compact('payments','accountname','bankname','bankaddress','accountnumber','typeofaccount','ifsccode'));
    }
	public function create(Request $r){
		$instituteid = Institute::where('user_id',Auth::user()->id)->first()->id;

        //$ap = Approvedprogramme::where('institute_id',$instituteid)->orderBy('academicyear_id')->get();

		if($r->form == 'exam')
        {
            $exam = Exam::find($r->exam_id);
            $ap = Approvedprogramme::where('institute_id',$instituteid)->orderBy('academicyear_id')->pluck('id')->toArray();
            $collections = Application::where('exam_id', $exam->id)->get();
            $collections = $collections->whereIn('approvedprogramme_id', $ap);

            $apid = $collections->pluck('approvedprogramme_id')->toArray();

            $ap = Approvedprogramme::find($apid);

            return view('institute.payments.create',compact('ap','instituteid', 'exam'));
        }
		else
        {
            $ap = Approvedprogramme::where('institute_id',$instituteid)->orderBy('academicyear_id')->get();
            return view('institute.payments.create',compact('ap','instituteid'));
        }
    }

    public function create2(Request $r){
        $instituteid = Institute::where('user_id',Auth::user()->id)->first()->id;
        //return $instituteid;
        $ap = Approvedprogramme::where('institute_id',$instituteid)->orderBy('academicyear_id')->get();

        if($r->form == 'exam')
        {
            $exam = Exam::find($r->exam_id);
            return view('institute.payments.create',compact('ap','instituteid', 'exam'));
        }
        else
        {
            return view('institute.payments.create',compact('ap','instituteid'));
        }

    }

	public function store(Request $request){
		Payment::create($request->all());
		$i = Institute::find($request->institute_id);
		foreach($i->approvedprogrammes as $ap){
			$ap->update(['paid_for'=>$ap->candidates()->count()]);
		}
    	return redirect('payment');
    }
	public function pdf($id){
		//Payment::create($request->all());
		$p = Payment::find($id);
		$pdf = PDF::loadView('institute.pdf.paymentack',compact('p'));
		
    	return $pdf->download('paymentack.pdf');
    }
}
