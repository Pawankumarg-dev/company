<?php

namespace App\Http\Controllers\Institute;

use App\Academicyear;
use App\Candidate;
use App\Enrolmentfee;
use App\Enrolmentpayment;
use App\Institute;
use App\Paymentbank;
use App\Paymenttype;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class EnrolmentPaymentsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $currentyear = Academicyear::where('current', '1')->orderBy('year')->first();

        $enrolmentfees = Enrolmentfee::where('academicyear_id', $currentyear->id)->get();
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();
        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)
            ->groupBy('payment_number')->get();
        $order_ids = \App\Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',Session::get('academicyear_id'))->where('nber_id',$n->id)->pluck('order_id')->toArray(); 
        $paid = \App\Order::whereIn('id',$order_ids)->sum('actual_amount');
        return view('institute.enrolmentpayments.index', compact('institute', 'currentyear', 'enrolmentpayments', 'enrolmentfees','paid'));
    }

    public function check1(Request $request) {
        $rules = [
            "filename" => "required | max: 1024"
        ];

        $messages = [
            "filename.required" => "Please upload the Scanned copy of Payment Slip",
            "filename.max" => "The uploaded file should be less than 1 MB"
        ];

        $validator = validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            $file = $request->file('filename');

            if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                $validator->errors()->add('filename', "The uploaded file should in .jpg format");
            }
        });

        $this->validateWith($validator);

        $file = $request->file('filename');
        $filename = "ENP".$request->currentyear.$request->institute_code.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/enrolment/";

        $file->move($destination, $filename);
    }

    public function selectstudents() {
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentyear = Academicyear::where('current', '1')->orderBy('year')->first();
        $enrolmentfees = Enrolmentfee::where('academicyear_id', $currentyear->id)->get();
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();
        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->get();

        return view('institute.enrolmentpayments.selectstudents', compact('institute', 'currentyear', 'enrolmentpayments'));
    }

    public function checkselectedstudents(Request $request) {

        $rules = [
            "payment_date" => "required",
        ];

        $messages = [
            "payment_date.required" => "Please select the Date of Enrolment Payment made"
        ];

        $validator = validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            if(!$request->has('candidate_id')) {
                $validator->errors()->add('', 'Please select student(s) for enrolment payment');
            }
        });

        $this->validateWith($validator);

        //$candidate_ids = Candidate::whereIn('id', $request->candidate_id)->pluck('id')->toArray();
        $candidate_ids = serialize($request->candidate_id);

        return redirect('/institute/enrolmentpayments/addpayment/'.$request->payment_date.'/'.$candidate_ids);

    }

    public function addpayment($payment_date, $cids) {
        $candidate_ids = unserialize($cids);
        $candidates = Candidate::whereIn('id', $candidate_ids)->get();

        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentyear = Academicyear::where('current', '1')->orderBy('year')->first();

        $enrolmentfees = Enrolmentfee::where('academicyear_id', $currentyear->id)->get();


        /*
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();
        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->get();
        */

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('institute.enrolmentpayments.create', compact('institute', 'currentyear', 'payment_date',
           'candidates', 'enrolmentfees', 'paymenttypes', 'paymentbanks'));
    }

    public function checkpayment(Request $request){
        $rules = [
            "paymenttype_id" => "required",
            "paymentbank_id" => "required",
            "payment_number" => "required | alpha_num",
            "amount_paid" => "required",
            "filename" => "required | max: 1024"
        ];

        $messages = [
            "paymenttype_id.min" => "Please select a Payment Mode from the given option",
            "paymentbank_id.min" => "Please select a Payment Bank from the given option" ,
            "payment_number.required" => "Please enter the Transaction Id / Number",
            "amount_paid.required" => "Please enter the Amount Paid",
            "filename.required" => "Please upload the Scanned copy of Payment Slip",
            "filename.max" => "The uploaded file should be less than 1 MB"
        ];

        $validator = validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            if($request->has('paymenttype_id')) {
                if($request->paymenttype_id == '0') {
                    $validator->errors()->add('paymenttype_id', "Please select a Payment Mode from the given option");
                }
            }

            if($request->has('paymentbank_id')) {
                if($request->paymenttype_id == '0') {
                    $validator->errors()->add('paymentbank_id', "Please select a Payment Bank from the given option");
                }
            }

            if($request->has('filename')) {
                $file = $request->file('filename');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('filename', "The uploaded file should in .jpg  or .pdf format");
                }
            }
        });

        $this->validateWith($validator);
        /*
        $candidates = Candidate::whereIn('id', $request->candidate_id)->get();
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentyear = Academicyear::where('current', '1')->orderBy('year')->first();

        $count = Enrolmentpayment::distinct('payment_number')->count('payment_number');
        $count++;

        $file = $request->file('filename');
        $reference_number = "ENP".$currentyear->year.$institute->code."C".$count;
        $filename = $reference_number.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/enrolment/";

        $file->move($destination, $filename);

        foreach ($candidates as $c) {
            $enrolmentfee = Enrolmentfee::where('academicyear_id', $c->approvedprogramme->academicyear_id)
                ->where('programme_id', $c->approvedprogramme->programme_id)->first();
            $latefee_remark = "No";

            if(!is_null($enrolmentfee)) {
                if($request->payment_date <= $enrolmentfee->ontimepayment_enddate) {
                    $latefee_remark = "Yes";
                }

                Enrolmentpayment::create([
                    "enrolmentfee_id" => $enrolmentfee->id,
                    "candidate_id" => $c->id,
                    "latefee_remark" => $latefee_remark,
                    "paymenttype_id" => $request->paymenttype_id,
                    "paymentbank_id" => $request->paymentbank_id,
                    "payment_date" => $request->payment_date,
                    "payment_number" => $request->payment_number,
                    "status_id" => 5,
                    "filename" => $filename,
                    "payment_remark" => $request->payment_remark,
                    "amount_paid" => $request->amount_paid,
                    "reference_number" => $reference_number,
                ]);
            }
        }

        return redirect('/institute/enrolmentpayments/');
        */
    }

    public function downloadreceipt($reference_number) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $enrolmentpayments = Enrolmentpayment::where('reference_number', $reference_number)->get();
        $common = $enrolmentpayments->where('reference_number', $reference_number)->first();

        return view('institute.enrolmentpayments.download', compact('institute', 'enrolmentpayments', 'common'));
    }
}
