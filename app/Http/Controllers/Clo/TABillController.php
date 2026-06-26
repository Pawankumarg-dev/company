<?php

namespace App\Http\Controllers\Clo;

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
use App\Models\CloReport;


class TABillController extends Controller
{
	public function __construct()
    {
		$this->middleware(['role:clo']);
		$this->exam_id = Session::get('exam_id');
        
    }
	public function index() {
       
        $bill = Tabill::where('user_id',Auth::id())->get(); 

        return view('clo.Tabill.index', compact('bill'));
    }

	public function create() {
		$banks = Paymentbank::get();

        return view('clo.Tabill.create',compact('banks'));
    }
    public function store(Request $request)
    {
        try{
 
        $exam_id = Exam::where('scheduled_exam',1)->first()->id;
        $randomString1 = Auth::id().'ta'.$exam_id;
        if ($request->hasFile('ta_form')) {
            $image = $request->file('ta_form');
            $ta_form = $randomString1 . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files/examcenter/TABILL'), $ta_form);
        }
        $randomString2 = Auth::id().'clo_report'.$exam_id;
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
            'exam_id'=>$exam_id
        ]);

        Session::flash('messages','Bill Details added successfully');

        return redirect('/clo/tabill')->with('success', 'clo added successfully!');
                   
    }
    catch (\Exception $e) {
        Session::flash('error','An error occurred while adding the bill. Please try again.');    
        return redirect('/clo/tabill');
    }
    }
    public function show($id)
    {
        $banks = Paymentbank::get();
        $tabill = Tabill::where('payment_status','reject')->where('id',$id)->first(); 
    
        return view('clo.Tabill.edit', compact('tabill','banks'));
    }

    public function update(Request $request)
    {
        $exam_id = Exam::where('scheduled_exam',1)->first()->id;
        $id=$request->id;
        $tabill = Tabill::findOrFail($id);

        $randomString1 = 'ta'.uniqid(time(), true).Auth::id();
        if ($request->hasFile('ta_form')) {
            $image = $request->file('ta_form');
            $ta_form = $randomString1 . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files/examcenter/TABILL'), $ta_form);
            $tabill->ta_form = $ta_form;

        }
        $randomString2 = 'ta'.$exam_id;
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
        // $tabill->branch = $request->branch;
        // $tabill->ifsc_code = $request->ifsc_code;
        $tabill->payment_status = 'Under Processing';
        $tabill->save();
        Session::flash('messages','T.A Bill detail updated successfully!');
        return redirect('/clo/tabill')->with('success', 'clo detail updated successfully!');
    }

 public function dailyReport(){
    $user_id = Auth::user()->id;
    $cloreports = CloReport::where('user_id',$user_id )->get();
    //dd( $cloreports );
    return view('clo.cloreport' ,compact('cloreports'));
 }

 public function insert_clo(){
    //dd('test');
    return view('clo.cloinsert');
 }

 public function store_clo(Request $request){
        $exam_id = 29;
        $user_id = Auth::user()->id;
        $nber_id = Clo::select('nber_id')->where('user_id', $user_id)->first();
//dd( $nber_id->nber_id);
            $fileName = '';
            if ($request->hasFile('malpractice_report')) {
                $file = $request->file('malpractice_report');
                $fileName = $user_id . '_clo_' . $exam_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files/examcenter/Clo-report'), $fileName);
            }

            $videoName = '';
            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $videoName = $user_id . '_clo_vid_' . $exam_id . '_' . time() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('files/examcenter/Clo-videos'), $videoName);
            }

            CloReport::create([
                'user_id' => $user_id,
                'exam_id' => $exam_id ,
                'nber_id' => $nber_id->nber_id,
                'day' => $request->input('day'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'file' => $fileName,
                'vidio' => $videoName,
            ]);
            Session::flash('messages', 'CLO report added successfully');
            return redirect('/clo/dailyreport')->with('success', 'CLO report added successfully!');
    }


}

