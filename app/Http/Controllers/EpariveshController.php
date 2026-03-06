<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\EpariveshStudent;
use App\Epariveshacadmic;
use App\Epariveshchoise;
use App\Programme;
use App\Approvedprogramme;
use Auth;
use App\City;
use App\Gender;
use App\Community;
use App\Nationality;
use App\Salutation;
use App\Lgstate;
use Session;
use Illuminate\Support\Facades\Validator;



class EpariveshController extends Controller
{

    

     public function __construct()
    {
        $this->middleware(['role:institute']);
    }



public function index(Request $request,$id,$p) {

    $id = base64_decode($id);
    $p = base64_decode($p);
 $programme = Programme::select('id','abbreviation','programmegroup_id')->find($p);

    $date = \Carbon\Carbon::now()->toDateString();

    $display = 1;

    $approve_program = Approvedprogramme::where('id', $id)->first();

$query = EpariveshStudent::whereNull('admitted');
    // ->where(function ($q) {
    //     $q->where('verify_by', Auth::user()->id)
    //       ->orWhereNull('verify_by');
    // });
    
    if (!empty($request->category)) {
        if ($request->category == 'PWD') {
            $query->where('IsPWD', '1');
        } else {
            $query->where('categoryname', $request->category);
        }
    }
if (!empty($request->registration_no)) {
        $query->where('RegistrationNo', $request->registration_no);
}

    

    if (!empty($request->gender)) {
        $query->where('gendername', $request->gender);
    }

    // Use paginate instead of get, e.g. 10 per page
    $students = $query->paginate(1000)->appends($request->except('page'));
    
    return view('institute.eparivesh.index', compact('students','programme', 'approve_program', 'display'));
}



  public function index2(Request $request){
        $date= \Carbon\Carbon::now()->toDateString();
$display=1;
        $request->programme_id;
        $request->institute_id;
$ids = Epariveshchoise::where('institute_id', $request->institute_id)->where('choiceorder','>',1)->where('programme_id', $request->programme_id)->pluck('eparivesh_student_id');
 $programme = Programme::select('id','abbreviation','programmegroup_id')->find($request->programme_id);


 $approve_program = Approvedprogramme::where('programme_id', $request->programme_id)
    ->where('academicyear_id', 14)->where('institute_id', $request->institute_id)
    ->first();

$query = EpariveshStudent::whereIn('id', $ids)->whereNull('admitted');
if (!empty($request->category)) {
    if ($request->category == 'PWD') {
        $query->where('IsPWD', '1');
    } else {
        $query->where('categoryname', $request->category);
    }
}

if (!empty($request->gender)) {
    $query->where('gendername', $request->gender);
}

$students = $query->get();


        return view('institute.eparivesh.index2',compact('students','programme','approve_program','display'));



    }


public function verify($id)
{
    $student = EpariveshStudent::findOrFail($id);
    $student->verify_by =Auth::user()->id;
    $student->status = 'verified'; // or whatever your field is
    $student->save();
    return response()->json(['message' => 'Student verified successfully.']);
}

public function cancel(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'reason' => 'required|string|max:1000',
    ]);

    if ($validator->fails()) {
        // Return validation errors as JSON (or customize as needed)
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $student = EpariveshStudent::findOrFail($id);
    
    // Option 1: Save reason directly in students table (make sure column exists)
    $student->status = 'canceled';
    $student->cancellation_reason = $request->reason;
    $student->save();
    return response()->json(['message' => 'Student canceled successfully.']);
}
  



     public function addcandidate($id,$apid,$candidate=null){


$student = EpariveshStudent::find($id);


        $now = \Carbon\Carbon::now();
        $ap = Approvedprogramme::find($apid);
                    $admitted=\App\Candidate::where('approvedprogramme_id',$apid)->count();

                
        if($ap->maxintake <= $admitted)
        {
            Session::put('error','No sheet Avilable');
        return redirect('/eparivesh');
        }
  
        if($ap->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($ap->enable_admission_till)->toDateString() ){
                if($ap->institute->user_id==Auth::user()->id){
                    $cities=City::all();
                    $genders=Gender::all();
                    $communities = Community::all();
                    $nationalities = Nationality::all();
                    $programme = $ap->programme;
                // $disabilities = Disability::all();
                //  $disabilities = Disabilitytype::all();
                    $salutations = Salutation::all();
                    $states = Lgstate::all();
                    $academicsession = $ap->academicyear->accademicsession;
                    $minage = $ap->programme->programmegroup->minage;
                    $mindate = strtotime($academicsession .' -'.$minage.' year');
                    $mindate = date('Y-m-d', $mindate);
                    $yesno = collect([
                        (object) [
                            'id' => 0,
                            'value' => 'No'
                        ],
                        (object) [
                            'id' => 1,
                            'value' => 'Yes'
                        ]
                    ]);

                    $institute = \App\Institute::find($ap->institute_id);

                    $tenth = \App\Epariveshacadmic::where('eparivesh_student_id',$id)->where('qulification_name','10 STANDARD OR EQUIVALENT')->first();
                    $twelveth = \App\Epariveshacadmic::where('eparivesh_student_id',$id)->where('qulification_name','10+2 OR EQUIVALENT')->first();

                        if($ap->maxintake > $ap->candidates()->count()){
                            return view('institute.eparivesh.create',compact('tenth','twelveth','student','mindate','nationalities','yesno','apid','states', 'salutations','cities','genders','communities','institute','programme','ap'));
                        }
                
                }
        }
        return redirect('/');
    }




 public function http_response($mobile, $otp)

    {
                $ch = curl_init();

		$baseURL= "https://smsgw.sms.gov.in/failsafe/HttpLink?username=depwd.sms&pin=De%40Pw%23789&";
		$replyTo ="RCIGOV";
		$messageBody = "Your one time password is ".$otp.". Rehabilitation Council of India";
		$messageBody = urlencode($messageBody);
    		$dlt_entity_id = '1401370180000040261';
    		$dlt_template_id = '1407165908962485291';
		$URI= $baseURL;
		$URI.="signature=".$replyTo;
		$URI .= "&mnumber=".$mobile;
   		$URI .= "&message=".$messageBody;
		$URI .= "&dlt_entity_id=".$dlt_entity_id;
		$URI .= "&dlt_template_id=".$dlt_template_id;
 
                curl_setopt($ch, CURLOPT_URL, $URI);
    
                curl_setopt($ch, CURLOPT_HEADER, 0);
    
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		$httpCode = curl_exec($ch);
    
    
                curl_close($ch);

                return $httpCode;
    
        }


public function eotp(Request $request)
{
    $otp = rand(100000, 999999); 
    $mobile = $request->phone;
    $registrationNo = $request->RegistrationNo;
    try {
        $student = EpariveshStudent::where('RegistrationNo', $registrationNo)->first();
        if (!$student) {

            return response()->json([
                'success' => false,
                'message' => 'Student not found with this registration number.',
            ], 404);
        }
        $this->http_response($mobile, $otp);


    Session::put('studentverification_otp', $otp);




        $student->otp = $otp;
        $student->save();
        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Could not send OTP. Try again later.',
        ], 500);
    }
}















}