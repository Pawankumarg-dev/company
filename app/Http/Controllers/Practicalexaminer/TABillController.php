<?php

namespace App\Http\Controllers\Practicalexaminer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Clo;
use App\Tabill;
use App\Paymentbank;
use App\Exam;
use App\Http\Requests;


class TABillController extends Controller
{
	public function __construct()
    {
		$this->middleware(['role:faculty']);
		$this->exam_id = Session::get('exam_id');
    }
	public function index() {
        $bill = Tabill::where('user_id',Auth::id())->where('exam_id',27)->get(); 
        return view('practicalexaminer.Tabill.index', compact('bill'));
    }

	public function create() {
		$banks = Paymentbank::get();
                $nbers = \App\Nber::all();
        return view('practicalexaminer.Tabill.create',compact('banks','nbers'));
    }
    public function store(Request $request)
    {
        try{
        $exam_id =27;
        $randomString1 = $request->nber_id.$request->payment_for.Auth::id().'ta'.$exam_id;
        if ($request->hasFile('ta_form')) {
            $image = $request->file('ta_form');
            $ta_form = $randomString1 . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files/examcenter/TABILL'), $ta_form);
        }
        $randomString2 =$request->nber_id.$request->payment_for.Auth::id().'report'.$exam_id;
        if ($request->hasFile('clo_report')) {
            $image = $request->file('clo_report');
            $clo_report = $randomString2 . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files/examcenter/Clo-report'), $clo_report);
        }
        Tabill::create([
            'user_id' => Auth::user()->id,
            'payment_status' => 'Under Processing',
            'ta_form' => $ta_form, 
            'clo_report' => $clo_report, 
            'exam_id'=>$exam_id,
            'nber_id'=>$request->nber_id,
            'payment_for'=>$request->payment_for

        ]);
        Session::flash('messages','Bill Details added successfully');
        return redirect('/faculty/tabill')->with('success', 'TAbill added successfully!');          
    }
    catch (\Exception $e) {
        Session::flash('error','An error occurred while adding the TAbill. Please try again.');    
        return redirect('/faculty/tabill');
    }
    }
    public function show($id)
    {
        $nbers = \App\Nber::all();
        $banks = Paymentbank::get();
        $tabill = Tabill::where('payment_status','reject')->where('id',$id)->first(); 
        return view('practicalexaminer.Tabill.edit', compact('tabill','banks','nbers'));
    }

    public function update(Request $request)
{
    $exam_id =27;
    $id=$request->id;
    $tabill = Tabill::findOrFail($id);
        $randomString1 = $request->nber_id.$request->payment_for.Auth::id().'ta'.$exam_id;
    if ($request->hasFile('ta_form')) {
        $image = $request->file('ta_form');
        $ta_form = $randomString1 . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('files/examcenter/TABILL'), $ta_form);
        $tabill->ta_form = $ta_form;
    }
        $randomString2 =$request->nber_id.$request->payment_for.Auth::id().'report'.$exam_id;
    if ($request->hasFile('clo_report')) {
        $image = $request->file('clo_report');
        $clo_report = $randomString2 . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('files/examcenter/Clo-report'), $clo_report);
        $tabill->clo_report = $clo_report;
    }
    $tabill->reason = '';
    // $tabill->demand_amount = $request->demand_amount;
    // $tabill->bank_name = $request->bank_name;
    // $tabill->account_holder_name = $request->account_holder_name;
    // $tabill->account_number = $request->account_number;
     $tabill->nber_id = $request->nber_id;
     $tabill->payment_for = $request->payment_for;
    $tabill->payment_status = 'Under Processing';
    $tabill->save();
    Session::flash('messages','T.A Bill detail updated successfully!');
    return redirect('/faculty/tabill')->with('success', 'clo detail updated successfully!');
}



}

