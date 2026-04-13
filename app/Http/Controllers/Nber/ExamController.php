<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Exam;
use App\Examtype;
use App\Academicyear;
use App\Programme;
use App\Approvedprogramme;
use App\Institute;
use App\Application;
use App\Currentapplicant;
use App\Subject;
use App\Subjecttype;
use App\Candidate;
use App\Mark;
use App\Programmegroup;
use App\Nberstaff;
use App\Language;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Supplimentaryapplicant;
use App\Order;
use App\Nber;
use Session;
use PDF;
use App\Utils\CustomPDF;


class ExamController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function recheckSupplimentaryPayment($rid){
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $supplimentaryapplicant = Supplimentaryapplicant::find($rid);
        $nber_id = $supplimentaryapplicant->candidate->approvedprogramme->programme->nber_id;
        $amount = $supplimentaryapplicant->amount;
        
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        //$order=Order::find($oid);
        $candidate = Candidate::where('id',$supplimentaryapplicant->candidate_id)->first();
        if(is_null($candidate->email)){
            $supplimentaryapplicant->orders()->detach();
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id = null;
            $supplimentaryapplicant->save();
            Session::put('error','Kindly Update your email Address to continue.');
            return back();
        }
        if($candidate->duplicate_mobile_no == 1){
            /*$supplimentaryapplicant->orders()->detach();
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id = null;
            $supplimentaryapplicant->save();*/
            Session::put('error','Please ensure the mobile number is unique.');
            return back();
        }
        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '03-03-2024',
            'order_bill_tel' => $candidate->contactnumber
        );
        
        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
        // Get server response ...
        $result = curl_exec($ch);
        curl_close($ch);
        $status = '';
        $information = explode('&', $result);
        
        $dataSize = sizeof($information);
        for ($i = 0; $i < $dataSize; $i++) {
            $info_value = explode('=', $information[$i]);
            if ($info_value[0] == 'enc_response') {
                $status = payment_decrypt(trim($info_value[1]), $working_key);
                
            }
        }
        
        $obj = json_decode($status);
        return $obj;
	$success = false;
        $count  = 0;
        if(!is_null($obj->Order_Lookup_Result->error_desc)){
            $supplimentaryapplicant->orders()->detach();
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id = null;
            $supplimentaryapplicant->save();
            Session::flash('error',$obj->Order_Lookup_Result->error_desc);
            return back();
        }
        $supplimentaryapplicant->orders()->detach();
       
       if($obj->Order_Lookup_Result->total_records > 1){
            foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
                $count ++;
                $ordernumber = $order->order_no;
                $reference_no = $order->reference_no;
                $order_amt = $order->order_amt;
                $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
                $order_notes = $order->order_notes;
                $sorder = Order::where('order_number',$ordernumber)->first();
                $order_status = $sorder->order_status;
                if($order->order_status == 'Shipped' && $order->order_amt == $amount){
                    $order_status = "Success";
                    $success = true;
                    $supplimentaryapplicant->order_id=$sorder->id;
                }
                if(!is_null($sorder)){
                    $sorder->order_status = $order_status;
                    $sorder->payment_date = $order_date_time;
                    $sorder->save();
                }else{
                    $sorder = Order::firstOrCreate([
                        "order_number" => $ordernumber,
                        "ccavenue_referencenumber" => $reference_no,
                        "bank_referencenumber" => null,
                        "order_status" => $order_status,
                        "status_message" => null,
                        "total_amount" => $amount,
                        "actual_amount" => $amount,
                        "transaction_fee" => 0.00,
                        "service_fee" => 0.00,
                        "payment_date" => $order_date_time,
                        "payment_remarks" => 'Throught Email and phone lookup',
                        "transaction_remarks" => $order_notes,
                        "reference_parameters" => '',
                        "billing_name" => $candidate->name,
                        "billing_designation" => 'Student',
                        "billing_tel" => $candidate->contactnumber,
                        "billing_email" => $candidate->email,
                    ]);
                }
                $supplimentaryapplicant->orders()->attach($sorder->id); 
            }
        }else{
            $order = $obj->Order_Lookup_Result->order_Status_List->order;
            $count++;
            $ordernumber = $order->order_no;
            $reference_no = $order->reference_no;
            $order_amt = $order->order_amt;
            $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
            $order_notes = $order->order_notes;
            $sorder = Order::where('order_number',$ordernumber)->first();
            $order_status = $sorder->order_status;
            if($order->order_status == 'Shipped' && $order->order_amt == $amount){
                $order_status = "Success";
                $success = true;
                $supplimentaryapplicant->order_id=$sorder->id;
            }
            if(!is_null($sorder)){
                $sorder->order_status = $order_status;
                $sorder->payment_date = $order_date_time;
                $sorder->save();
            }else{
                $sorder = Order::firstOrCreate([
                    "order_number" => $ordernumber,
                    "ccavenue_referencenumber" => $reference_no,
                    "bank_referencenumber" => null,
                    "order_status" => $order_status,
                    "status_message" => null,
                    "total_amount" => $amount,
                    "actual_amount" => $amount,
                    "transaction_fee" => 0.00,
                    "service_fee" => 0.00,
                    "payment_date" => $order_date_time,
                    "payment_remarks" => 'Throught Email and phone lookup',
                    "transaction_remarks" => $order_notes,
                    "reference_parameters" => '',
                    "billing_name" => $candidate->name,
                    "billing_designation" => 'Student',
                    "billing_tel" => $candidate->contactnumber,
                    "billing_email" => $candidate->email,
                ]);
            }
            $supplimentaryapplicant->orders()->attach($sorder->id); 
        }
        if($success == true){
            $supplimentaryapplicant->payment_status = 1;
            
            $supplimentaryapplicant->save();
            Session::put('messages','Payment is successful');
        }else{
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id= null;
            $supplimentaryapplicant->save();
            Session::put('messages','Fetched current status from payment gateway. Payment is not successful ');
        }
        Session::flash('log',$status);
        return back();
    }

    public function recheckpaymentstatus($batch){
        $completed = Supplimentaryapplicant::where('lookup',1)->count();
        $pending = Supplimentaryapplicant::where('lookup',0)->count();


        $supplimentaryapplicants = Supplimentaryapplicant::where('payment_status',0)
                                    //->where('process_batch', $batch)
                                    ->get();
        $rval = 'BEGIN'. PHP_EOL;

        $nochange = 0;
        $failtosuccess = 0;
        $successtofail = 0;
        foreach($supplimentaryapplicants as $sa){
            $rval .= $sa->id . ')'. PHP_EOL;
            $status = $sa->payment_status;
            $return = $this->recheckPayment($sa->id);
            if($status==1){
                if($return == 'Failed'){
                    $successtofail++;
                }else{
                    $nochange++;
                }
            } 
            if($status==0){
                if($return == 'Success'){
                    $failtosuccess++;
                }
                else{
                    $nochange++;
                }
            } 
            $rval .= $return;

        }
        return view('nber.examinations.paymentstatus',compact('rval','completed','pending','failtosuccess','successtofail','nochange')) ;
    }
   
    private function recheckPayment($rid){
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $supplimentaryapplicant = Supplimentaryapplicant::find($rid);
        $nber_id = $supplimentaryapplicant->candidate->approvedprogramme->programme->nber_id;
        $amount = $supplimentaryapplicant->amount;
        
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        //$order=Order::find($oid);
        $candidate = Candidate::where('id',$supplimentaryapplicant->candidate_id)->first();
        if(is_null($candidate->email)){
            $supplimentaryapplicant->orders()->detach();
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id = null;
            $supplimentaryapplicant->save();
            return 'Invalid Email';
        }
        if($candidate->duplicate_mobile_no == 1){
            return ('Duplicate Mobile');
        }
        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '03-03-2024',
            'order_bill_tel' => $candidate->contactnumber
        );
        
        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
        // Get server response ...
        $result = curl_exec($ch);
        curl_close($ch);
        $status = '';
        $information = explode('&', $result);
        
        $dataSize = sizeof($information);
        for ($i = 0; $i < $dataSize; $i++) {
            $info_value = explode('=', $information[$i]);
            if ($info_value[0] == 'enc_response') {
                $status = payment_decrypt(trim($info_value[1]), $working_key);
            }
        }
        
        $obj = json_decode($status);
        $success = false;
        $count  = 0;
        if(!is_null($obj->Order_Lookup_Result->error_desc)){
            $supplimentaryapplicant->orders()->detach();
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id = null;
            $supplimentaryapplicant->save();
            
            return ($obj->Order_Lookup_Result->error_desc);
        }
        $supplimentaryapplicant->orders()->detach();
       
       if($obj->Order_Lookup_Result->total_records > 1){
            foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
                $count ++;
                $ordernumber = $order->order_no;
                $reference_no = $order->reference_no;
                $order_amt = $order->order_amt;
                $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
                $order_notes = $order->order_notes;
                $sorder = Order::where('order_number',$ordernumber)->first();
                $order_status = $sorder->order_status;
                if($order->order_status == 'Shipped' && $order->order_amt == $amount){
                    $order_status = "Success";
                    $success = true;
                    $supplimentaryapplicant->order_id=$sorder->id;
                }
                if(!is_null($sorder)){
                    $sorder->order_status = $order_status;
                    $sorder->payment_date = $order_date_time;
                    $sorder->save();
                }else{
                    $sorder = Order::firstOrCreate([
                        "order_number" => $ordernumber,
                        "ccavenue_referencenumber" => $reference_no,
                        "bank_referencenumber" => null,
                        "order_status" => $order_status,
                        "status_message" => null,
                        "total_amount" => $amount,
                        "actual_amount" => $amount,
                        "transaction_fee" => 0.00,
                        "service_fee" => 0.00,
                        "payment_date" => $order_date_time,
                        "payment_remarks" => 'Throught Email and phone lookup',
                        "transaction_remarks" => $order_notes,
                        "reference_parameters" => '',
                        "billing_name" => $candidate->name,
                        "billing_designation" => 'Student',
                        "billing_tel" => $candidate->contactnumber,
                        "billing_email" => $candidate->email,
                    ]);
                }
                $supplimentaryapplicant->orders()->attach($sorder->id); 
            }
        }else{
            $order = $obj->Order_Lookup_Result->order_Status_List->order;
            $count++;
            $ordernumber = $order->order_no;
            $reference_no = $order->reference_no;
            $order_amt = $order->order_amt;
            $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
            $order_notes = $order->order_notes;
            $sorder = Order::where('order_number',$ordernumber)->first();
            $order_status = $sorder->order_status;
            if($order->order_status == 'Shipped' && $order->order_amt == $amount){
                $order_status = "Success";
                $success = true;
                $supplimentaryapplicant->order_id=$sorder->id;
            }
            if(!is_null($sorder)){
                $sorder->order_status = $order_status;
                $sorder->payment_date = $order_date_time;
                $sorder->save();
            }else{
                $sorder = Order::firstOrCreate([
                    "order_number" => $ordernumber,
                    "ccavenue_referencenumber" => $reference_no,
                    "bank_referencenumber" => null,
                    "order_status" => $order_status,
                    "status_message" => null,
                    "total_amount" => $amount,
                    "actual_amount" => $amount,
                    "transaction_fee" => 0.00,
                    "service_fee" => 0.00,
                    "payment_date" => $order_date_time,
                    "payment_remarks" => 'Throught Email and phone lookup',
                    "transaction_remarks" => $order_notes,
                    "reference_parameters" => '',
                    "billing_name" => $candidate->name,
                    "billing_designation" => 'Student',
                    "billing_tel" => $candidate->contactnumber,
                    "billing_email" => $candidate->email,
                ]);
            }
            $supplimentaryapplicant->orders()->attach($sorder->id); 
        }
        if($success == true){
            $supplimentaryapplicant->payment_status = 1;
            $supplimentaryapplicant->save();
            return 'Success';
        }else{
            $supplimentaryapplicant->payment_status = 0;
            $supplimentaryapplicant->order_id= null;
            $supplimentaryapplicant->save();
            return 'Failed';
        }
        
    }
    
    public function consolidated(){
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $result = DB::table('currentapplicants as ca')
                    ->join('approvedprogrammes as ap','ap.id','=','ca.approvedprogramme_id')
                    ->join('programmes as p','p.id','=','ap.programme_id')
                    ->join('institutes as i','i.id','=','ap.institute_id')
                    ->join('academicyears as y','y.id','=','ap.academicyear_id')
                    ->where('p.nber_id',$nber_id)
                    ->selectRaw('
                        i.rci_code, 
                        i.name, 
                        p.abbreviation, 
                        case when p.numberofterms = 1  then `term_one_name` else display_year end as batch, 
                        count(*) as no_of_students,
                        sum(if(ca.`attendance`=1,1,0)) as with_classroom_attendance,
                        case when 
                            (ap.`academicyear_id` < 10 and p.numberofterms = 2 ) or (ap.`academicyear_id` <= 10 and p.`numberofterms` =1)
                        then 
                            sum(if(ca.`final_result`  is not null and ca.`incomplete` !=1 ,1,0))
                        else
                            sum(if(ca.`term_one_result_id` is not null  and ca.`incomplete` !=1 ,1,0)) 
                        end as result_declared,
                        case when 
                            (ap.`academicyear_id` < 10 and p.numberofterms = 2 ) or (ap.`academicyear_id` <= 10 and p.`numberofterms` =1)
                        then 
                            sum(if(ca.`final_result` =1,1,0))
                        else
                            sum(if(ca.`term_one_result_id` =1,1,0)) 
                        end as passed,
                        p.numberofterms,
                        sum(
                            if(
                                (
                                    (ap.`academicyear_id` < 10 and p.numberofterms = 2 ) 
                                    or 
                                    (ap.`academicyear_id` <= 10 and p.`numberofterms` =1)
                                ) 
                                and 
                                (ca.`final_result` =1)
                                ,1,0
                            )
                        ) as course_completed
                    ')
                    ->groupBy('i.id','ap.id')
                    ->get();
        return view('nber.exams.result',compact('result'));
    }

    public function fullreport(){
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $result = DB::table('currentapplicants as ca')
                    ->join('approvedprogrammes as ap','ap.id','=','ca.approvedprogramme_id')
                    ->join('programmes as p','p.id','=','ap.programme_id')
                    ->join('institutes as i','i.id','=','ap.institute_id')
                    ->join('academicyears as y','y.id','=','ap.academicyear_id')
                    ->join('candidates as c','c.id','=','ca.candidate_id')
                    ->join('currentapplications as cas')
                    ->where('p.nber_id',$nber_id)
                    ->selectRaw('
                        i.rci_code, 
                        i.name, 
                        p.abbreviation, 
                        p.numberofterms,
                        ca.attendacne as class_room_attendance,
                        case when 
                            (ap.`academicyear_id` < 10 and p.numberofterms = 2 ) or (ap.`academicyear_id` <= 10 and p.`numberofterms` =1)
                        then 
                            if(ca.`final_result`  is not null and ca.`incomplete` !=1 ,1,0)
                        else
                            if(ca.`term_one_result_id` is not null  and ca.`incomplete` !=1 ,1,0)
                        end as result_declared,
                        case when 
                            (ap.`academicyear_id` < 10 and p.numberofterms = 2 ) or (ap.`academicyear_id` <= 10 and p.`numberofterms` =1)
                        then 
                            if(ca.`final_result` =1,1,0)
                        else
                            if(ca.`term_one_result_id` =1,1,0))
                        end as passed,
                        
                        if(
                            (
                                (ap.`academicyear_id` < 10 and p.numberofterms = 2 ) 
                                or 
                                (ap.`academicyear_id` <= 10 and p.`numberofterms` =1)
                            ) 
                            and 
                            (ca.`final_result` =1)
                            ,1,0
                        )
                         as course_completed
                    ')
                    ->get();
        return view('nber.exams.result',compact('result'));
    }
    
    public function controls(Request $r){
        if($r->has('academicyear')){
            $academicyear_id = $r->academicyear;
        }else{
            $academicyear_id = Academicyear::where('current',1)->first()->id;
        }
        $collections = Exam::where('academicyear_id',$academicyear_id)->paginate(10);
        $link = 'batches';
        $text = "Batches";
        
        return view('nber.exam.batches',compact('collections','link','text','academicyear_id'));

    }
    public function updateexamname(Request $r){
        $exam = Exam::find($r->id);
        $exam->name = $r->name;
        $exam->save();
        Session::flash('message','Updated');
        return back();
    }
    public function batchsettings(Request $r){
        $batch = Exam::find($r->id);
        return view('nber.exam.batchsettings',compact('batch'));
    }
     
    public function updatebatchsettings(Request $r){
        if(Nberstaff::where('user_id',Auth()->user()->id)->first()->admin == 1){
            $batch = Exam::find($r->id);
            $batch->update($r->except('_token'));
            $batch->save();
            Session::flash('message','Updated');
        }
        return back();
    }
     

    public function index(){
        $exams = Exam::where('id','!=','0')->whereHas('academicyear',function($q) {
            $q->where('academicyear_id', Session::get('academicyear_id'));
        });
        $collections = $exams->paginate(10);
        $link = 'exams';
        $text = 'Exams';
        $examtypes = Examtype::all();
        $academicyears = Academicyear::all();
        $programmegroups = Programmegroup::all();
        return view('nber.exams.index',compact('collections','link','text','examtypes','academicyears','programmegroups'));
    }
    public function create(Request $request){
        
       // return json_encode($request->all());
        $exam = Exam::create($request->all());
        //$exam->programmegroups()->sync($request->programmegroups);
        return back();
    }
    public function update(Request $request){
        $exam = Exam::find($request->id);
        $exam->update($request->except('id'));
        $exam->programmegroups()->sync($request->programmegroups);
        return redirect('/exams');
    }
    public function show($id){
        $exam = Exam::find($id);
        if($exam->id == '3') {
            $collections = Programme::whereIn('id', ['9', '11', '12', '13', '20'])->paginate(5);
        }
        else {
            $collections = Programme::paginate(20);
        }
        $text = " Marks Entry - Select Programme (" . $exam->name . " Exam)";
        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';

        $applications =  Application::where('exam_id',$exam->id);
        //$progress = $this->getProgress($applications);

        return view('nber.exams.evaluation',compact('exam','collections','text','breadcrumblinkto','breadcrumblinktext','id'));
    }
    public function showinstitutes($exam,$programme){
        $exam = Exam::find($exam);
        $institues = Approvedprogramme::where('programme_id',$programme)->pluck('institute_id')->toArray();
        $collections = Institute::whereIn('id',$institues)->paginate(400);
        $programmename = Programme::find($programme)->course_name;
        $text = " Marks Entry - Select Institutes (" . $exam->name . " Exam > ".$programmename.")";

        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';
        $breadcrumblinkto1 = 'evaluation/'.$exam->id;
        $breadcrumblinktext1 = 'Programmes';

        $exam_id = $exam->id;
        $programme_id = $programme;

        $applications =  Application::where('exam_id',$exam->id);
        //return $applications->count();

        $applications =  $applications->whereHas('candidate',function($r) use($programme_id){
            $r->whereHas('approvedprogramme',function($q) use($programme_id){
                $q->where('programme_id',$programme_id);
            });
        });
        //return $applications->count();
        // $progress = $this->getProgress($applications);
        return view('nber.exams.institutes',compact('exam','collections','text','breadcrumblinkto','breadcrumblinktext','breadcrumblinkto1','breadcrumblinktext1','exam_id','programme_id'));
    }

    public function showExamApplications($apid,$eid) {
        $exam = Exam::find($eid);
        $approvedprogramme = Approvedprogramme::with('candidates')->find($apid);
        return view('nber.examapplications.show_candidate_lists', compact('approvedprogramme','exam'));
    
    }

    public function applyCandidateExamApplication(Request $request) {
         $sno = -1;
         $candidate = Candidate::find($request->candidateId);
        $applications = array();
        $currentapplicant = Currentapplicant::where('candidate_id',$candidate->id)->first();
        if(is_null($currentapplicant)){
            $currentapplicant = Currentapplicant::create([
                'approvedprogramme_id' => $candidate->approvedprogramme_id,
                'candidate_id' => $candidate->id,
                'exam_id' => 22,
                'nber_id' => $candidate->approvedprogramme->programme->nber_id,
                'modify_mark'=>1
            ]);
        }
        
        if($request->languageId == 0){
            $request->languageId = 1;
        }
         foreach ($request->subjectAppliedStatus as $subjectIdCheckbox){
             $sno++;
             if($subjectIdCheckbox == '1') {
                    $internal = 'internal_'. $request->subjectId[$sno];
                    $external = 'external_'. $request->subjectId[$sno];
                 $applications[$request->subjectId[$sno]] =[
                     "exam_id" => $request->examId,
                     "approvedprogramme_id" => $request->approvedprogrammeId,
                     "term" => $request->term[$sno],
                     "language_id" => $request->languageId,
                     "payment_status" => "Not Entered",
                     "active_status" => 1,
                     "status_id" => 6,
                     "linkopen_number" => 1,
                     "penalty" => "No",
                     "externalexamcenter_id" => 1,
                     'currentapplicant_id' => $currentapplicant->id,
                     'internalattendance_id' => 1,
                     'externalattendance_id' => 1,
                     'internal_mark' => $request->$internal,
                     'external_mark' => $request->$external
                 ];
             }
         }
         

         $attendance = \App\Attendance::where('exam_id',22)->where('candidate_id',$candidate->id)->first();
         if(!empty($candidate)){
            $currentapplicant->attendance = 0;
         }
         if($attendance->attendance_t > 74.99 && $attendance->attendance_p > 74.99){
            $currentapplicant->attendance = 1;
        }else{
            $currentapplicant->attendance = 0;
        }
        $currentapplicant->save();
        $candidate->subjects()->attach($applications);
        
        $first_year_count = DB::select(
            'select count(*) as fyc from currentapplications ca
            left join subjects s on s.id = ca.subject_id
            where exam_id = 22 and candidate_id = ' . $candidate->id .' and s.syear = 1');
        
        $currentapplicant->first_year_pappers = $first_year_count[0]->fyc;
        $second_year_count = DB::select(
            'select count(*) as syc from currentapplications ca
            left join subjects s on s.id = ca.subject_id
            where exam_id = 22 and candidate_id = ' . $candidate->id .' and s.syear = 2');
        $currentapplicant->second_year_pappers = $second_year_count[0]->syc;

        $first_year_subjects = Subject::where('programme_id',$candidate->approvedprogramme->programme_id)->where('syear',1)->count();
        $second_year_subjects = Subject::where('programme_id',$candidate->approvedprogramme->programme_id)->where('syear',2)->count();
        $noofterms = $candidate->approvedprogramme->programme->numberofterms;
        $ayid = $candidate->approvedprogramme->academicyear_id;
        if($ayid == 10){
            if($noofterms==1){
                $currentapplicant->papers_required_to_pass_this_year = $first_year_subjects;
                $currentapplicant->papers_required_to_pass_previous_year = 0;
            }else{
                $currentapplicant->papers_required_to_pass_this_year = $first_year_subjects;
                $currentapplicant->papers_required_to_pass_previous_year = 0;
            }
        }
        if($ayid < 10){
            if($noofterms==1){
                $currentapplicant->papers_required_to_pass_this_year = $first_year_subjects;
                $currentapplicant->papers_required_to_pass_previous_year = $first_year_subjects;
            }else{
                $currentapplicant->papers_required_to_pass_this_year = $second_year_subjects;
                $currentapplicant->papers_required_to_pass_previous_year = $first_year_subjects;
            }
        }
        $currentapplicant->save();
        //$candidate->subjects()->attach($applications);
        return redirect('nber/publishresult/'.$candidate->approvedprogramme->programme_id . '/'. $candidate->approvedprogramme->institute_id .'/studentlist');
     }
        public function candidateapplication($apid, $eid, $cid){
            $exam = Exam::find($eid);
            if($exam->id != 22){
                return back();
            }
            
            $approvedprogramme = Approvedprogramme::find($apid);
        
           if(!is_null($approvedprogramme)) {
                $candidate = Candidate::find($cid);
                if(!is_null($candidate) && $candidate->coursecompleted_status != 1) {
                    $sql = '                        select s.id, s.scode, s.sname, st.type, s.syear, s.imax_marks, s.emax_marks from subjects s
                    left join subjecttypes st on st.id = s.subjecttype_id
                    where programme_id = '.$approvedprogramme->programme_id.' and 
                    s.id not in (select subject_id from currentapplications where candidate_id = '. $cid .' ) and
                    s.id not in (
                        select subject_id from (
                        select subject_id, sum(result_id) as result_id from applications where  candidate_id = '.$cid.' group by subject_id having result_id > 0 ) as t1
                    )';
                    $subjects = DB::select($sql);
                        $languages = Language::where('language', '!=', 'NOT APPLICABLE')->get(['id', 'language']);
                        return view('nber.examapplications.candidate_exam_application_form', compact('exam', 'approvedprogramme', 'candidate', 'subjects', 'languages'));
                }
                else {
                    return 'Candidate already completed course / No missing applications found';
                    Session::put('message','Please check the eligibility / The student has already completed the course.');
                    return redirect('/nber/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id);
                }
            }
            else {
                return 'Course not found';
                return redirect('/institute/examinations/applications/'.$exam->id);
            }
        }
    private function getProgress($collections){
        $allids = $collections->pluck('id')->toArray();
        $count = 0;
        $marks = Mark::whereIn('application_id',$allids)->get();
        foreach($marks as $c){
            if($c->internal != null){
                if($c->external != null){
                    $count += 1;
                }
            }
        }
        //   $markscount = Mark::whereIn('application_id',$allids)->whereNotNull('internal')->whereNotNull('external')->count();
        /*($markscount = Mark::whereIn('application_id',$allids)->where(function ($q){
            $q->whereNotNull('internal');
        })->where(function($q){
            $q->whereNotNull('external');
        })->count();*/
        if($collections->count()>0){
            //$progress = ($markscount / $collections->count()) * 100;
            $progress  = ($count / $collections->count()) * 100;
        }else{
            $progress = 0;
        }

        return round($progress,1);
    }
    public function showmarks($exam_id,$programme_id,$institute_id,Request $request){

        $collections =  Application::with(['candidate' => function ($q) {
            $q->orderBy('enrolmentno');
        }])->where('exam_id',$exam_id);

        $collections =  $collections->whereHas('candidate',function($r) use($institute_id,$programme_id){
            $r->whereHas('approvedprogramme',function($q) use($institute_id,$programme_id){
                $q->where('institute_id',$institute_id)->where('programme_id',$programme_id);
            });
        });

        $progress = $this->getProgress($collections);

        $enrolmentnumbers_ids = $collections->groupBy('candidate_id')->pluck('candidate_id')->toArray();
        $enrolmentnumbers = Candidate::whereIn('id',$enrolmentnumbers_ids)->get();


        $subject_ids = $collections->groupBy('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id',$subject_ids)->get();
        $terms = Subject::whereIn('id',$subject_ids)->groupBy('syear')->pluck('syear')->toArray();
        $types_ids = Subject::whereIn('id',$subject_ids)->groupBy('subjecttype_id')->pluck('subjecttype_id')->toArray();
        $types = Subjecttype::whereIn('id',$types_ids)->get();


        $candidate_ids = $collections->groupBy('candidate_id')->pluck('candidate_id')->toArray();
        $ap_ids = Candidate::whereIn('id',$candidate_ids)->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();
        $ay_ids = Approvedprogramme::whereIn('id',$ap_ids)->groupBy('academicyear_id')->pluck('academicyear_id')->toArray();
        $academicyears = Academicyear::whereIn('id',$ay_ids)->get();

        if($request->has('cid')){
            $collections = $collections->where('candidate_id',$request->cid);

        }
        if($request->has('ay')){
            $collections =  $collections->whereHas('candidate',function($r) use($institute_id,$programme_id,$request){

                $r->whereHas('approvedprogramme',function($q) use($institute_id,$programme_id,$request){
                    $q->where('academicyear_id',$request->ay);
                });

            });
        }

        if($request->has('sid')){
            $collections =  $collections->where('subject_id',$request->sid);
        }
        if($request->has('stid')){
            $collections =  $collections->whereHas('subject',function($r) use($request){
                $r->where('subjecttype_id',$request->stid);
            });
        }
        if($request->has('tid')){
            $collections =  $collections->whereHas('subject',function($r) use($request){
                $r->where('syear',$request->tid);
            });
        }

        //$collections = $collections->orderBy('candidates.enrolmentno');
        //$collections = $collections->whereHas('candidate',function($r){
        //   $r->orderBy('enrolmentno');
        //});



        $collections = $collections->paginate(40);

        $institute = Institute::find($institute_id)->user->username;
        $programmename = Programme::find($programme_id)->course_name;
        $exam = Exam::find($exam_id);

        $text = " Marks Entry (" . $exam->name . ' Exam > ' . $programmename . ' > '. $institute  .')';

        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';
        $breadcrumblinkto1 = 'evaluation/'.$exam_id;
        $breadcrumblinktext1 = 'Programmes';
        $breadcrumblinkto2 = 'evaluation/'.$exam_id.'/'.$programme_id;
        $breadcrumblinktext2 = 'Institutes';

        return view('nber.exams.marks',compact('collections','text','breadcrumblinkto','breadcrumblinktext','breadcrumblinkto1','breadcrumblinktext1','breadcrumblinkto2','breadcrumblinktext2','enrolmentnumbers','subjects','terms','types','academicyears','progress'));
    }
    public function publish($exam_id){
        $exam = Exam::find($exam_id);
        if($exam->status_id==1)
            $exam->update(['status_id'=>null]);
        else
            $exam->update(['status_id'=>1]);

        return redirect('/exams');
    }
    public function selectcourse($exam_id){
        set_time_limit(0);
        $exam = Exam::find($exam_id);
        if($exam->id == '3') {
            $collections = Programme::whereIn('id', ['9', '11', '12', '13', '20'])->paginate(20);
        }
        else {
            $collections = Programme::paginate(20);
        }
        $text = " Marks Verify - Select Programme (" . $exam->name . " Exam)";
        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';

        $applications =  Application::where('exam_id',$exam->id);
        //$progress = $this->getProgress($applications);

        return view('nber.marksverify.course',compact('exam','collections','text','breadcrumblinkto','breadcrumblinktext'));
    }

    public function selectinstitute($exam_id, $programme_id){
        $exam = Exam::find($exam_id);
        $institues = Approvedprogramme::where('programme_id',$programme_id)->pluck('institute_id')->toArray();

        $collections = Institute::select('institutes.*')
            ->join('users', 'users.id', '=', 'institutes.user_id')
            ->whereIn('institutes.id',$institues)
            ->orderBy('users.username');

        $collections = $collections->paginate(400);
        $programmename = Programme::find($programme_id)->course_name;

        $text = " Marks Verify - Select Institutes (" . $exam->name . " Exam > ".$programmename.")";

        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';
        $breadcrumblinkto1 = 'marksverify/'.$exam->id;
        $breadcrumblinktext1 = 'Programmes';

        $exam_id = $exam->id;

        return view('nber.marksverify.institute',compact('exam','collections','text','breadcrumblinkto','breadcrumblinktext','breadcrumblinkto1','breadcrumblinktext1','exam_id','programme_id'));
    }

    public function selectyear($exam_id, $programme_id, $institute_id){
        $exam = Exam::find($exam_id);

        $approvedprogrammes = Approvedprogramme::where('approvedprogrammes.programme_id', $programme_id)
            ->where('approvedprogrammes.institute_id', $institute_id)->get();

        $approvedprogrammes_id = $approvedprogrammes->pluck('id')->toArray();

        $collections = Application::select('applications.*')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'applications.approvedprogramme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)->whereIn('applications.approvedprogramme_id', $approvedprogrammes_id)
            ->groupBy('applications.approvedprogramme_id')->orderBy('academicyears.year')->get();

        //$collections = $collections->paginate(400);
        $programmename = Programme::find($programme_id)->course_name;

        $text = " Marks Verify - Select Institutes (" . $exam->name . " Exam > ".$programmename.")";

        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';
        $breadcrumblinkto1 = 'marksverify/'.$exam->id;
        $breadcrumblinktext1 = 'Programmes';

        $exam_id = $exam->id;

        return view('nber.marksverify.year',compact('exam','collections','text','breadcrumblinkto','breadcrumblinktext','breadcrumblinkto1','breadcrumblinktext1','exam_id','programme_id','institute_id'));
    }

    public function selectyear1($exam_id, $programme_id, $institute_id){
        $exam = Exam::find($exam_id);
        $approvedprogrammes = Approvedprogramme::where('approvedprogrammes.programme_id', $programme_id)
            ->where('approvedprogrammes.institute_id', $institute_id)->get();

        $approvedprogrammes_id = $approvedprogrammes->pluck('id')->toArray();

        $collections = Application::select('applications.*')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'applications.approvedprogramme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)->whereIn('applications.approvedprogramme_id', $approvedprogrammes_id)
            ->groupBy('applications.approvedprogramme_id')->orderBy('academicyears.year')->get();

        $programmename = Programme::find($programme_id)->course_name;

        $text = " Marks Verify - Select Institutes (" . $exam->name . " Exam > ".$programmename.")";

        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = 'Exams';
        $breadcrumblinkto1 = 'marksverify/'.$exam->id;
        $breadcrumblinktext1 = 'Programmes';

        return view('nber.marksverify.year',compact('exam','collections','text','breadcrumblinkto','breadcrumblinktext','breadcrumblinkto1','breadcrumblinktext1','exam_id','programme_id'));
    }

    public function markspdf($exam_id, $programme_id, $institute_id, $approvedprogramme_id){
        $exam = Exam::find($exam_id);

        /*
        $approvedprogramme = Approvedprogramme::where('institute_id', $institute_id)->where('programme_id', $programme_id)
            ->orderBy('academicyear_id')->get();
        $approvedprogramme_id = $approvedprogramme->pluck('id')->toArray();
        */
        $institute = Institute::find($institute_id);
        $programme = Programme::find($programme_id);

        $subjects = Subject::where('programme_id', $programme_id)->orderBy('syear')->orderBy('subjecttype_id')
            ->orderBy('sortorder')->get();
        //$subject_id = $subjects->pluck('id')->toArray();

        $collections = Application::select('applications.*')
            ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
            ->where('applications.exam_id', $exam_id)->where('applications.approvedprogramme_id', $approvedprogramme_id)
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')->get();

        $candidate_id = $collections->unique('candidate_id')->pluck('candidate_id')->toArray();
        //$ap_id = $collections->pluck('approvedprogramme_id')->toArray();

        $candidates = Candidate::whereIn('id', $candidate_id)->orderBy('enrolmentno')->get();

        //$approvedprogramme = Approvedprogramme::whereIn('id', $ap_id)->get();

        $html = '
                <html>
                    <head>
                        <style>
                            .page-break {
                                page-break-after: always;
                            }
                            .blue-text {
                                color: blue;
                            }
                            .red-text {
                                color: red;
                            }
                            .green-text {
                                color: green;
                            }
                            .lightgrey-background {
                                background-color: lightgrey !important;
                            }
                            .h4-text {
                                font-size: 20px;
                                font-weight: bold;
                            }
                            .h3-text {
                                font-size: 12px;
                            }
                            .left-text{
                                float: left;
                            }
                            .center-text{
                                text-align: center !important;
                            }
                            .right-text{
                                float: right;
                                margin-right: 100px;
                            }
                            thead{
                                display: table-header-group;   
                                }
                        </style>
                        
                        <script>
                        function printPage() {
                            window.print();
                        }
                        </script>
                    </head>
                    <body>  
                ';
        $html .= '<p><button onclick="printPage()">Print Marks</button> </p>';

        for($i=$programme->numberofterms;$i>0;$i--) {
            $html .= '<p>';
            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" class="h3-text">';
            $html .= '<tr>';
            $html .= '<td><span class="h3-text">Institute Code :</span></td>';
            $html .= '<td><span class="h3-text">'.$institute->user->username.'</span></td>';
            $html .= '</tr>';
            $html .= '<td><span class="h3-text">Institute Name :</span></td>';
            $html .= '<td><span class="h3-text">'.$institute->name.'</span></td>';
            $html .= '</tr>';
            $html .= '<td><span class="h3-text">Programme :</span></td>';
            $html .= '<td><span class="h3-text">'.$programme->course_name.'</span></td>';
            $html .= '</tr>';
            $html .= '</table>';
            $html .= '</p>';

            $html .= '<p>';
            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" class="h3-text">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<td rowspan="2">Enrolment No</td>';
            $html .= '<td rowspan="2">Name</td>';
            foreach ($subjects as $s) {
                if ($s->syear == $i) {
                    if ($collections->where('subject_id', $s->id)->count() > 0) {
                        $html .= '<td colspan="5">' . $s->scode . '</br>(' . $s->subjecttype->type . ')<br>';
                        $html .= 'IN_MIN:' . $s->imin_marks . '<br>';
                        $html .= 'IN_MAX:' . $s->imax_marks . '<br>';
                        $html .= 'EX_MIN:' . $s->emin_marks . '<br>';
                        $html .= 'EX_MAX:' . $s->emax_marks . '<br>';
                        $html .= '</td>';
                    }
                }
            }
            $html .= '<td rowspan="2">Grand Total</td>';
            $html .= '<td rowspan="2">Result</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            foreach ($subjects as $s) {
                if ($s->syear == $i) {
                    if ($collections->where('subject_id', $s->id)->count() > 0) {
                        $html .= '<td>IN</td>';
                        $html .= '<td>EX</td>';
                        $html .= '<td>GR</td>';
                        $html .= '<td>TO</td>';
                        $html .= '<td>P/F</td>';
                    }
                }
            }
            $html .= '</tr>';
            $html .= '</thead>';


            foreach($candidates as $c) {
                $set = 0; //for displaying candidate's enrolmentno and name for one time
                $grand_total = 0;

                foreach($subjects as $s) {
                    if($s->syear == $i){

                        if($collections->where('candidate_id', $c->id)->where('subject_id', $s->id)->count() > 0){
                            $set ++;;
                        }
                    }
                }

                if($set > 0) {
                    $html .= '<tr>';
                    $html .= '<td>'.$c->enrolmentno.'</td>';
                    $html .= '<td>'.$c->name.'</td>';

                    $subcount = 0;
                    $failcount = 0;

                    foreach($subjects as $s) {
                        if($s->syear == $i){

                            if ($collections->where('subject_id', $s->id)->count() > 0) {
                                //foreach ($collections->where('candidate_id', $c->id)->where('subject_id', $s->id) as $co) {

                                foreach ($collections->where('candidate_id', $c->id) as $co) {
                                    if($co->subject_id == $s->id) {
                                        $fail = 0;
                                        $mark = Mark::where('application_id', $co->id)->first();

                                        if(is_null($mark)){
                                            $html .= '<td><b>NIL</b></td>';
                                            $html .= '<td><b>NIL</b></td>';
                                            $html .= '<td><b>0</b></td>';
                                            $html .= '<td><b>0</b></td>';
                                            $html .= '<td><b>F</b></td>';

                                            $fail++;
                                            $failcount ++;
                                        }
                                        else{
                                            $in = $mark->internal;
                                            $ex = $mark->external;
                                            $gr = $mark->grace;

                                            /* --------- Obtained Marks --------- */
                                            if($in == 'Abs')
                                                $html .= '<td><b>'.$in.'</b></td>';
                                            else
                                                $html .= '<td>'.$in.'</td>';

                                            if($ex == 'Abs')
                                                $html .= '<td><b>'.$ex.'</b></td>';
                                            else
                                                $html .= '<td>'.$ex.'</td>';
                                            /* --------- ./Obtained Marks --------- */

                                            /* --------- Grace Marks --------- */
                                            $html .= '<td>'.$gr.'</td>';
                                            /* --------- ./Grace Marks --------- */

                                            /* --------- Total --------- */
                                            //Absent
                                            if($in == 'Abs' || $ex == 'Abs') {


                                                if($in == 'Abs' && $ex == 'Abs') {
                                                    $total = 0;
                                                }
                                                elseif ($ex == 'Abs' && $in != 'Abs'){
                                                    $total = $in;
                                                }
                                                else {
                                                    $total = $ex;
                                                }

                                                $fail++;
                                                $failcount ++;
                                                $grand_total += (int) $total + $gr;
                                                $html .= '<td><b>'.$total.'</b></td>';
                                            }
                                            //Present
                                            else {
                                                if(is_null($in) || is_null($ex)){
                                                    $failcount++;
                                                    $fail++;
                                                }
                                                if($in == '') {
                                                    $total = $ex;
                                                    $failcount++;
                                                    $fail++;
                                                }
                                                elseif ($ex == ''){
                                                    $fail++;
                                                    $failcount++;
                                                    $total = $in;
                                                }

                                                else {
                                                    $total = (int) $in + (int) $ex + $gr;
                                                }

                                                $grand_total += (int) $total;
                                                $html .= '<td><b>'.$total.'</b></td>';

                                            }
                                            /* --------- ./Total --------- */


                                            /* --------- Pass/Fail remarks --------- */

                                            if($in < $s->imin_marks) {
                                                $fail++;
                                                $failcount++;
                                            }
                                            if((int) $ex + $gr < $s->emin_marks) {
                                                $fail++;
                                                $failcount++;
                                            }
                                            if($fail++ > 0) {
                                                $html .= '<td class="lightgrey-background">F</td>';
                                            }
                                            else{
                                                $html .= '<td>PS</td>';
                                            }


                                            /* --------- ./Pass/Fail remarks --------- */
                                        }
                                    }
                                }
                            }

                        }
                    }

                    /* --------- Grand Total --------- */
                    $html .= '<td>'.$grand_total.'</td>';
                    /* --------- ./Grand Total --------- */

                    /* --------- Result --------- */
                    if($failcount > 0) {
                        $html .= '<td class="lightgrey-background">F</td>';
                    }
                    else{
                        $html .= '<td>PS</td>';
                    }

                    /* --------- Result --------- */
                    $html .= '</tr>';
                }
            }

            $html .= '</table>';

            $html .= '<div class="h3-text">';
            $html .= 'Sd/-<br><b>DIRECTOR</b><br>NIEPMD';
            $html .= '</div>';

            $html .= '</p>';

            $html .= '<p>';

            $html .= '</p>';
        }

        echo '<p></p>';

        echo $html;
    }

    public function verifymarks($exam_id, $approvedprogramme_id){
        $exam = Exam::find($exam_id);

        $approvedprogramme = Approvedprogramme::find($approvedprogramme_id);

        $applications = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
            ->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('subjecttype_id')
            ->orderBy('sortorder')->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        return view('nber.marksverify.verifymarks', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'marks'));
    }

    public function show_exam_list() {
        $exams = Exam::orderBy('date', 'desc')->get();

        return view('nber.exams.show_exam_list', compact('exams'));
    }

    public function downloadSupplimentaryApplication(Request $r){       
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $nber = \App\Nber::find($nber_id)->short_code;     
        return view('nber.supplimentary.show_supplimentary_application',compact('nber'));
    }




    public function generatePDF()
    {
        // Create an instance of the custom PDF class
        $pdf = new CustomPDF();
        $pdf->SetCreator('TCPDF');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('PDF with Watermark');
        
        // Set paper size and orientation (A4, landscape)
        $pdf->setPaper('A4', 'landscape');
    
        // Add a page to the PDF
        $pdf->AddPage();
    
        // Set the content for your PDF
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'This is a test PDF with a watermark.', 0, 1, 'C');
        
        // Output the PDF to the browser
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="watermarked_pdf.pdf"',
        ]);
    }











}
