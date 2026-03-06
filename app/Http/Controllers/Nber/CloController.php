<?php

namespace App\Http\Controllers\Nber;

use App\Externalexamcenter;
use App\Nbercloupdate;
use App\Nodalofficer;
use App\Title;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Institute;
use App\Lgstate;
use App\District;
use App\Clo;
use App\User;
use Auth;
use Session;
use Illuminate\Support\Str;
use App\Exam;
use Illuminate\Support\Facades\Mail;
use App\Tabill;
               use DB;

class CloController extends Controller
{
    private $exam_id;
    public function __construct()
    {
       $this->middleware(['role:nber']);
       $this->exam_id = Session::get('exam_id');
    }
  

     public function tabill() {
        //         $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        // $tabills = Tabill::where('nber_id',$nber_id)->get();


$tabills = DB::table('tabills')
    ->join('faculties', 'tabills.user_id', '=', 'faculties.user_id')
    ->join('exams', 'tabills.exam_id', '=', 'exams.id')
    ->leftjoin('nbers', 'tabills.nber_id', '=', 'nbers.id')

    ->select(
        'faculties.name',
        'faculties.crr_no',
        'faculties.mobileno',
        'faculties.email',
        'exams.name as exam_name',
        'tabills.clo_report',
        'tabills.ta_form',
        'tabills.created_at',
        'tabills.id',
                'tabills.payment_status',

        'nbers.name_code'
    )->where('payment_status', '!=', 'Success')->where('tabills.exam_id',27)

    ->get();
        return view('nber.clo.tabill', compact('tabills'));
    }
public function accept(Request $request, $id)
{
    // $request->validate([
    //     'amount' => 'required|integer|min:1',
    //     'transaction_details' => 'required|string|max:255',
    // ]);

    Tabill::where('id', $id)->update([
        'payment_status' => 'Success',
        'amount' => $request->amount,
        'transaction_details' => $request->transaction_details,
    ]);

    return back()->with('messages', 'TA Bill accepted with amount and transaction details.');
}


public function rejectRequest(Request $request, $id)
{
   
    $tabill = Tabill::findOrFail($id);
    $tabill->payment_status = 'reject';
    $tabill->reason = $request->reason;
    $tabill->save();
    return back()->with('messages', 'TA Bill Rejected.');
}

    public function index() {
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        $clos = Clo::where("exam_id", $this->exam_id)->where('nber_id',$nber_id)->get();
        return view('nber.clo.index', compact('exam', 'clos'));
    }

    public function create(Request $r){
        $states = Lgstate::get();
        $institutes  = Institute::get();
        $districts = \App\District::all();

        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        return view('nber.clo.create',compact('states','institutes','nber_id','districts'));
    }
    public function store(Request $request)
    {
        $clo = new clo();
        $clo->name = $request->name;
        $clo->crr_no = $request->crr_no;
        $clo->designation = $request->designation;
        $clo->institute_id = $request->institute_id;
        $clo->email = $request->email;
        $clo->mobile = $request->mobile;
        $clo->lgstate_id = $request->lgstate_id;
        $clo->district = $request->district;
        $clo->exam_id = $this->exam_id;
        $clo->nber_id = $request->nber_id;
        
        $clo->save();

        Session::flash('messages','clo added successfully');

        return redirect('nber/clo')->with('success', 'clo added successfully!');


  
    }
    public function show($id)
{
    $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
    $clo = clo::findOrFail($id);
    $institutes = Institute::all(); 
    $states = Lgstate::all();  
    $districts = District::get();  

    return view('nber.clo.edit', compact('clo', 'institutes', 'states', 'districts','nber_id'));
}

public function update(Request $request)
{
    $id=$request->id;
    $clo = clo::findOrFail($id);
    $clo->name = $request->name;
    $clo->crr_no = $request->crr_no;
    $clo->designation = $request->designation;
    $clo->institute_id = $request->institute_id;
    $clo->email = $request->email;
    $clo->mobile = $request->mobile;
    $clo->lgstate_id = $request->lgstate_id;
    $clo->district = $request->district;
    $clo->save();
    Session::flash('messages','clo detail updated successfully!');

    return redirect('nber/clo')->with('success', 'clo detail updated successfully!');
}
public function clo_verify(Request $request){
    $clo = clo::findOrFail($request->item_id);
 
    $clo->is_verified = 1;
    $clo->save();
    return response()->json(['message' => 'Verification successfully done']);
}

public function details($id){
    $clo = clo::findOrFail($id);
    $bill = Tabill::where('user_id',$clo->user_id)->get(); 
    return view('nber.clo.details', compact('clo', 'bill'));
}
public function approve_payment(Request $request){
    $payment = Tabill::find($request->id);
    if($request->payment_type=='success'){
        $payment->amount = $request->amount;
        $payment->transaction_details = $request->transaction_details;
        $payment->payment_status = $request->payment_type;
        $payment->reason = '';
        $payment->save();
        return response()->json(['success' => true]);

    }
    else {
        $payment->amount = $request->amount;
        $payment->transaction_details = $request->transaction_details;
        $payment->payment_status = $request->payment_type;
        $payment->reason = $request->reason;
        $payment->save();
        return response()->json(['success' => true]);
    
    }

    return response()->json(['success' => false, 'message' => 'Payment not found']);
}

public function sendPassword(Request $request)
{
    $password='CLO'.str_random(3).'@'.$request->item_id;
    $clo = clo::find($request->item_id);
    if ($clo) {
        if (empty($clo->user_id)|| is_null($clo->user_id)) {
            $user = new User();
            $user->username = $clo->crr_no.$clo->email;
            $user->email = $clo->email;
            $user->usertype_id = 4; 
            $user->password = Hash::make($password);  
            $user->save();
            $clo->user_id = $user->id;
            $clo->save();


            $url = "https://rciregistration.nic.in/rehabcouncil/api/exam_email_send_nber.jsp?email=" . urlencode($clo->email) . "&name=CLO&password=" . urlencode($password) . "&user_id=" . urlencode($clo->crr_no.$clo->email);
            $is_ok = $this->http_response($url);
            return response()->json(['message' => 'mail sent']);
        } else {
            $user = User::where('user_id', $clo->user_id)->where('usertype_id', 4)->first();
            if ($user) {
                $user->password = Hash::make($password);
                $user->save();
                $email='sk306842@gmail.com';
                $url = "https://rciregistration.nic.in/rehabcouncil/api/exam_email_send_nber.jsp?email=" . urlencode($clo->email) . "&name=CLO&password=" . urlencode($password) . "&user_id=" . urlencode($clo->crr_no.$clo->email);
                $is_ok = $this->http_response($url);
                return response()->json(['message' => 'mail sent']);
            } else {
                return response()->json(['message' => 'User associated with this clo not found.'], 404);
            }
        }
    }
    return response()->json(['message' => 'clo not found.'], 404);
}

public function http_response($url, $status = null, $wait = 3)

    {
    
         
    
    
    
            // we fork the process so we don't have to wait for a timeout
    
    
                // we are the parent
    
                $ch = curl_init();
    
                curl_setopt($ch, CURLOPT_URL, $url);
    
                curl_setopt($ch, CURLOPT_HEADER, TRUE);
    
                curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
    
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
                $head = curl_exec($ch);
    
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
                curl_close($ch);

                return $httpCode;
    
                
    
    
    
          
        }
}
