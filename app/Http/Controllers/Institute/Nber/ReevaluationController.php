<?php

namespace App\Http\Controllers\Nber;

use App\Exam;
use App\Reevaluationapplication;
use App\Reevaluationapplicationfee;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Refund;
use Session;
use Auth;
use App\Order;
use App\Candidate;
use Illuminate\Support\Facades\DB;
use App\Supplimentaryapplicant;


class ReevaluationController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function generate(){
        //$job = (new \App\Jobs\GenerateReevaluationMarksheet())->onQueue('reevaluation');
      //  $job = (new \App\Jobs\ProcessGracemark())->onQueue('gracemarkjob');
       //$job = (new \App\Jobs\ReleaseMarksheet())->onQueue('releasemarksheetwithgmjob');
      //  $job = (new \App\Jobs\ProcessGracemarkforReevaluation())->onQueue('forragracemarkjob');
        
        $job = (new \App\Jobs\ReleaseMarksheetRevaluation())->onQueue('revaluationreleasemarksheetjob');
       // $job = (new \App\Jobs\CheckPaymentstatus())->onQueue('paymentstatus');
       $this->dispatch($job);
        
       //ProcessGracemark
      
        return 'Inititated';
    }

  

   
    public function stats(Request $r){
        $exam = Exam::find(22);
        $show = 1; 
        if($r->has('show')){
            $show =$r->show;
        }
        
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        
        if($r->has('admin')){
            $programmes = \App\Programme::where('active_status','>',0)->get(); 
        }else{
            $programmes = \App\Programme::where('nber_id',$nber_id)->where('active_status','>',0)->get();
        }
        $programme = null;
        $subjects  = null;
        $reevaluationapplicationsubjects = DB::table('reevaluationapplicationsubjects AS rs')
                                            ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                                            ->join('institutes AS i','i.id','=','rs.institute_id')
                                            ->join('kvttis as kv','kv.institute_id','=','i.id')
                                            ->join('externalexamcenters as ec','ec.id', '=', 'kv.externalexamcenter_id')
                                            ->join('evaluationcenterdetails as evd','evd.externalexamcenter_id', '=', 'kv.externalexamcenter_id')
                                            ->join('evaluationcenters as evc','evc.id', '=', 'evd.evaluationcenter_id')
                                            ->join('approvedprogrammes as ap','ap.id','=','ra.approvedprogramme_id')
                                            ->join('programmes as p','p.id','=','ap.programme_id')
                                            ->where('ra.orderstatus_id',1)
                                            ->where('ra.exam_id',22)
                                            ->groupBy('evc.id');
        if($r->has('programme_id') && $r->programme_id != 0){
            $programme = \App\Programme::find($r->programme_id);
            $subjects = \App\Subject::where('programme_id',$r->programme_id)->where('subjecttype_id',1)->get();
            $sql = '';
            foreach($subjects as $s){
                $sql .= 'sum(if(rs.subject_id=' . $s->id .' and rs.reevaluation_applystatus,1,0)) as "RE_'.$s->scode. '", ';
                $sql .= 'sum(if(rs.subject_id=' . $s->id .' and rs.retotalling_applystatus,1,0)) as "RT_'.$s->scode. '", ';
                $sql .= 'sum(if(rs.subject_id=' . $s->id .' and rs.photocopying_applystatus,1,0)) as "PH_'.$s->scode. '", ';
            }
            $reevaluationapplicationsubjects = $reevaluationapplicationsubjects->where('p.id',$r->programme_id)
            ->selectRaw('evc.code, evc.name,
            count(distinct ra.id) as reevaluation_applications, 
            sum(reevaluation_applystatus) as reevaluation_papers, 
            sum(retotalling_applystatus) as retotalling_papers, 
            sum(photocopying_applystatus) as photocopying_papers,' . $sql . '
            evc.id as evaluationcenter_id');
        }else{
            if(!$r->has('admin')){
                $reevaluationapplicationsubjects = $reevaluationapplicationsubjects->where('p.nber_id',$nber_id);
            }
            $reevaluationapplicationsubjects = $reevaluationapplicationsubjects
            ->selectRaw('evc.code, evc.name,
            count(distinct ra.id) as reevaluation_applications, 
            sum(reevaluation_applystatus) as reevaluation_papers, 
            sum(retotalling_applystatus) as retotalling_papers, 
            sum(photocopying_applystatus) as photocopying_papers,
            sum(if(rs.active_status= 1 and reevaluation_applystatus =1, 1,0)) as pending_reevaluation_papers,
            sum(if(rs.active_status= 1 and retotalling_applystatus =1, 1,0)) as pending_retotalling_papers,
            evc.id as evaluationcenter_id');
        }
        
        $total = DB::table('reevaluationapplicationsubjects AS rs')
                ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                ->join('approvedprogrammes as ap','ap.id','=','ra.approvedprogramme_id')
                ->join('programmes as p','p.id','=','ap.programme_id')
                ->where('ra.orderstatus_id',1)
                ->where('ra.exam_id',22);
                
        if($r->has('programme_id') && $r->programme_id != 0){
            $total = $total->where('p.id',$r->programme_id)
            ->selectRaw('count(distinct ra.id) as reevaluation_applications, ' . $sql . '
                sum(reevaluation_applystatus) as reevaluation_papers, 
                sum(retotalling_applystatus) as retotalling_papers, 
                sum(photocopying_applystatus) as photocopying_papers');
        }else{
            if(!$r->has('admin')){
                $total = $total->where('p.nber_id',$nber_id);
            }
            $total = $total->selectRaw('count(distinct ra.id) as reevaluation_applications, 
                sum(reevaluation_applystatus) as reevaluation_papers, 
                sum(if(rs.active_status= 1 and reevaluation_applystatus =1, 1,0)) as pending_reevaluation_papers,
                sum(retotalling_applystatus) as retotalling_papers, 
                sum(if(rs.active_status= 1 and retotalling_applystatus =1, 1,0)) as pending_retotalling_papers,
                sum(photocopying_applystatus) as photocopying_papers');
        }
        if($show == 2){
            $reevaluationapplicationsubjects = $reevaluationapplicationsubjects->where('rs.active_status',1);
            $total = $total->where('rs.active_status',1)->where('exam_id',22);
        }
        
        $reevaluationapplicationsubjects =$reevaluationapplicationsubjects->get();
        $total=$total->get();
        return view('nber.reevaluations.report',compact('reevaluationapplicationsubjects','total','programmes','programme','subjects','show'));

    }

    public function recheckStatusAll($rid){
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $reevaluationapplication = Reevaluationapplication::find($rid);
        $nber_id = $reevaluationapplication->nber_id;
        $amount = $reevaluationapplication->amount;
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        //$order=Order::find($oid);
        $candidate = Candidate::where('id',$reevaluationapplication->candidate_id)->first();
        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '01-12-2023',
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
        foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
            if($order->order_bank_response == 'SUCCESS' && $order->order_amt == $amount){
                $success = true;
                $ordernumber = $order->order_no;
                $reference_no = $order->reference_no;
                $order_amt = $order->order_amt;
                $order_date_time = $order->order_date_time;
                $order_notes = $order->order_notes;
                $order = Order::where('order_number',$ordernumber)->first();
                if($order->count() > 0){
                    $order->order_status = "Success";
                    $order->save();
                }else{
                    $order = Order::firstOrCreate([
                        "order_number" => $ordernumber,
                        "ccavenue_referencenumber" => $reference_no,
                        "bank_referencenumber" => null,
                        "order_status" => "Success",
                        "status_message" => null,
                        "total_amount" => $amount,
                        "actual_amount" => $amount,
                        "transaction_fee" => 0.00,
                        "service_fee" => 0.00,
                        "payment_date" => date($order_date_time),
                        "payment_remarks" => 'Throught Email and phone lookup',
                        "transaction_remarks" => $order_notes,
                        "reference_parameters" => '',
                        "billing_name" => $candidate->name,
                        "billing_designation" => 'Student',
                        "billing_tel" => $candidate->contactnumber,
                        "billing_email" => $candidate->email,
                    ]);
                }
                $reevaluationapplication->orders()->attach($order->id);
                $reevaluationapplication->orderstatus_id = 1;
                $reevaluationapplication->order_id=$order->id;
                $reevaluationapplication->save();
                    
            }
        }
        if($success == true){
            Session::put('messages','Payment is successful');
        }else{
            Session::put('messages','Fetched current status from payment gateway. Payment is not successful ');
        }
        return back();
    }
  
    public function addref(Request $r){
        $order=Order::find($r->id);
        $order->ccavenue_referencenumber= $r->ref_no;
        $order->save();
        return json_encode('success');
    }
    public function index(Request $r) {
        $exam = Exam::find(22);
        $show = 1; 
        if($r->has('show')){
            $show =$r->show;
        }
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $evaluation_center = null;
        $evaluationcenters = \App\Evaluationcenter::where('active_status',1)->get();
        if($r->has('search')){
            $reevaluationapplications = Reevaluationapplication::where('exam_id', $exam->id)
                                            ->where('application_number','like','%'.$r->search.'%')
                                            ->where('nber_id',$nber_id);
        }else{
            if($r->has('searchsubjectapplication')){
                $reevaluationapplications = Reevaluationapplication::where('exam_id', $exam->id)
                ->where('nber_id',$nber_id)
                ->where('orderstatus_id',1)
                ->whereHas('reevaluationapplicationsubjects',function($q) use($r){
                    $q->where('id',$r->searchsubjectapplication);
                });
            }else{
            $reevaluationapplications = Reevaluationapplication::where('exam_id', $exam->id)->where('orderstatus_id',1)->where('nber_id',$nber_id);
            }
        }
        if($r->has('evaluationcenter_id') && $r->evaluationcenter_id !=0 && !$r->has('search')){
            $evaluation_center = \App\Evaluationcenter::find($r->evaluationcenter_id);
            $reevaluationapplications = $reevaluationapplications->whereHas('institute',function($q) use($r){
                $q->where('evaluationcenter_id',$r->evaluationcenter_id);
            });
        }
        if($show == 2){
            $reevaluationapplications = $reevaluationapplications->where('active_status',1);
        }
        $reevaluationapplications = $reevaluationapplications->orderBy('application_number')->paginate(100);
        return view('nber.reevaluations.showstudentlist', compact('exam', 'reevaluationapplications','evaluationcenters','evaluation_center','show'));
    }
    public function showApplications($id){
        $reevaluationapplication = Reevaluationapplication::find($id);
        $reevaluationfee = Reevaluationapplicationfee::where('exam_id',22)->first();
        return view('nber.reevaluations.show_reevaluation_application', compact('reevaluationapplication','reevaluationfee'));
    }
    public function refund(Request $r){
        $rules = [
            "refno" => "required|string|min:4|max:255",
            "refunddate" => "required|date",
        ];

        $messages = [
            "refno.required" => "Please enter the Reference No"
        ];
        
        $this->validate($r, $rules, $messages);
        $refund = Refund::where('reevaluationapplication_id',$r->reevaluationapplication_id)->first();

         if(!is_null($refund)){
            $refund->refno = $r->refno;
            $refund->refunddate = $r->refunddate;
            $refund->save();
            Session::put('messages','Updated');
            return back();
         }
        
    }
}
