<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Institute;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Reportedissue;
use App\Affiliationfee;
use App\Enrolmentfeepayment;
use App\Institutehead;
use App\Institutefacility;
use App\Lgstate;
use App\City;
use DB;
class InstituteController extends Controller
{
      public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function sendotp(Request $r){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $apiKey = urlencode('NGU1MDM1NzY3ODc0MzM2NjRlNzQ2NDQ0NWEzMTczNGY=');
        $numbers='91'.$institute->contatnumber1;
        $numbers = array($numbers);
        $sender = urlencode('DLNBER');
        $otp = rand(100000, 999999);
        // $message = "Regards from DEPWD, Your OTP is " . $otp;
        $message = rawurlencode("Your One Time Password ".$otp.". Log in to RCI NBER account. Rehabilitation Council of India");
        $numbers = implode(',', $numbers);
        try{
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            // dd($response);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Could not send OTP']);
        }
        $user = \App\User::where('id',Auth::user()->id)->first();
        $user->confirmation_code = Hash::make($otp);
        $user->save();
        return response()->json('success');
    }
    public function validateotp(Request $r){
        if(Hash::check($r->otp,$user->confirmation_code)){
            return response()->json('success');
        }else{
            return response()->json(['error'=>'Could not veriy OTP']);
        }
    }
    public function changeinstitutepassword(){
        return view('institute.change_password');
    }
    public function profile(){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $institutehead = Institutehead::where('institute_id',$institute->id)->first();
        $facilities = Institutefacility::where('institute_id',$institute->id)->first();
         if(is_null($institutehead)){
            $institutehead = Institutehead::create([
                'institute_id' => $institute->id,
            ]);
        }
        if(is_null($facilities)){
            $facilities = Institutefacility::create([
                'institute_id' => $institute->id,
                'biometric_facility' => 'No',
                'cctv_facility' => 'No'
            ]);
        }
        return view('institute.profile',compact('institute','institutehead','facilities'));
    }

    public function edit(){
        return "Not available";
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $institutehead = Institutehead::where('institute_id',$institute->id)->first();
        if(is_null($institutehead)){
            Institutehead::create([
                'institute_id' => $institute->id,
            ]);
        }
        $institutehead = Institutehead::where('institute_id',$institute->id)->first();
        $facilities = Institutefacility::where('institute_id',$institute->id)->first();
        if(is_null($facilities)){
            Institutefacility::create([
                'institute_id' => $institute->id,
                'biometric_facility' => 'No',
                'cctv_facility' => 'No'
            ]);
        }
        $facilities = Institutefacility::where('institute_id',$institute->id)->first();

        $cities = City::all();
        $states = Lgstate::all();
        return view('institute.edit_profile',compact('institute','institutehead','facilities','cities','states'));
    }
    public function update(Request $r){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $institute->update($r->all());
        $institute->is_data_verified = 1;
        $institute->save();
        Session::put('messages','Updated');
        return back();
    }

    public function updateinstitutehead(Request $r){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $institutehead = Institutehead::where('institute_id',$institute->id)->first();
        $institutehead->update($r->all());
        $institute->is_institute_head_verified = 1;
        $institute->save();
        Session::put('messages','Updated');
        return back();
    }

    public function updatefacilities(Request $r){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $facilities = Institutefacility::where('institute_id',$institute->id)->first();
        $facilities->update($r->all());
        $institute->is_facilities_verified = 1;
        $institute->save();
        Session::put('messages','Updated');
        return back();
    }

	public function notice(){
        $af_paid = 0;
        $enf_paid = 0;
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        
        $affiliationfee  = Affiliationfee::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->first();

        $enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id',1)->count();
        if($enrolmentfee>0){$enf_paid=1;}
        if(!is_null($affiliationfee)){
            if($affiliationfee->orderstatus_id == 1){
                $af_paid = 1;
            }
        }

        $apids = \App\Approvedprogramme::where('institute_id',$institute->id)->where('academicyear_id',14)->get();
        
        // $paractical = DB::table('practicalexams')
        //     ->join('faculties', 'practicalexams.faculty_id', '=', 'faculties.id')
        //     ->join('courses', 'practicalexams.course_id', '=', 'courses.id')
        //     ->join('practicalexam_subject', 'practicalexams.id', '=', 'practicalexam_subject.practicalexam_id')
        //     ->leftjoin('subjects', function ($join) {
        //         $join->on('practicalexam_subject.subject_id', '=', 'subjects.id')
        //             ->where('subjects.subjecttype_id', '=', 2);
        //     })
        //     ->select(
        //                         'courses.id as course_id',
        //         'courses.name as course_name',
        //         DB::raw('GROUP_CONCAT(DISTINCT subjects.scode) as subjects'),
        //         'faculties.name',
        //         'faculties.mobileno',
        //         'faculties.address',
        //         'faculties.email',
        //         'practicalexams.start_date',
        //         'practicalexams.end_date',
        //                         'practicalexams.id'

        //     )
        //     ->where('practicalexams.exam_id', 27)
        //     ->where('practicalexams.institute_id', $institute->id)
        //     ->groupBy('faculties.id','practicalexams.course_id')
        //     ->get();




        

$paractical=[];


        return view('institute.notice',compact('af_paid','enf_paid','institute','paractical','apids'));
    }
    public function verifyotp(Request $r){
        //$institute = Institute::where('user_id',Auth::user()->id)->first();
        $declaration = \App\Admissiondeclaration::where('approvedprogramme_id',$r->approvedprogramme_id)->first();
        if($r->otp  == $declaration->otp){
            $declaration->opt_verified_on = \Carbon\Carbon::now();
            $declaration->save();
            return response()->json('success');
        }
        return response()->json('failed');
    }

    public function declarationotp(Request $r){
//        return $r->email;
        //$institute = Institute::where('user_id',Auth::user()->id)->first();
        $declaration = \App\Admissiondeclaration::where('approvedprogramme_id',$r->approvedprogramme_id)->first();
        $count = \App\Candidate::where('approvedprogramme_id',$r->approvedprogramme_id)->where('deleted_at',null)->count();
        if(!is_null($declaration->opt_verified_on)){
            $declaration->previous_candidates = $declaration->previous_candidates . ','. $declaration->no_of_candidates;
            $declaration->previous_verified_on = $declaration->previous_verified_on . ','. $declaration->opt_verified_on;
            
            $declaration->previous_name = $declaration->previous_name . ','. $declaration->name;
            
            $declaration->previous_email = $declaration->previous_email . ','. $declaration->email;
            
            $declaration->previous_mobile = $declaration->previous_mobile . ','. $declaration->mobile;
        }

        $declaration->name = $r->name;
        $declaration->email = $r->email;
        $declaration->mobile = $r->mobile;




        if ($r->hasFile('file')) {
            $image = $r->file('file');
            $imageName = $r->approvedprogramme_id . 'metit.' . $image->getClientOriginalExtension();
            $image->move(public_path('files/merit'), $imageName);
                $declaration->merit = $imageName; // Save path to database
        }


        $declaration->save();
        //$url = "https://rciregistration.nic.in/rehabcouncil/api/email_send_nber.jsp?email=".$r->email."&name=".urlencode($r->name)."&password=".$declaration->otp."&type=institute";
        //$is_ok = $this->http_response($url);
        try{
        $is_ok = $this->http_response_mobile($r->mobile,$declaration->otp);
        return response()->json(['result'=>'success']);
        }catch(Exception $e){
            return response()->json(['result'=>'failed','message'=>"Please try again later"]);
        }
    }

    public function http_response_mobile($mobile, $otp)

    {
    
         
    
    
    
            // we fork the process so we don't have to wait for a timeout
    
    
                // we are the parent
    
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
    
    public function datacorrections(){
        $prgms = \App\Programme::where('active_status',1)->orderby('abbreviation')->get();
        $nbers = \App\Nber::all();
        return view('institute.datacorrection',compact('prgms','nbers'));
    }
    public function showreportissue(){
        return view('institute.reportissue');
    }

    public function reportissue(Request $r){
        $rules = [
            'issuetype' => 'required||not_in:0',
            'comment' => 'required',
            'contactperson' => 'required',
            'contactnumber' => 'required',
            'nber_id' => 'required',
        ];
        $messages = [
            'issuetype.required' => 'Please select the Issue Type',
            'issuetype.not_in' => 'Please select the Issue Type',
            'comment.required' => 'Please describe the issue in detail',
            'contactperson.required' => 'Please enter your name',
            'contactnumber.required' => 'Please enter your Contact Number',
            'nber.required'=>'Please choose the NBER'
        ];
        $this->validate($r, $rules,$messages);
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;

        $timestamp = round(microtime(true));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $tracking_id=$randomString.$timestamp;

        $ri = Reportedissue::create(
            ['institute_id'=>$institute_id,
            'tracking_id'=>$tracking_id,
            'issuetype' => $r->issuetype,
            'comment' => $r->comment,
            'contactperson' => $r->contactperson,
            'contactnumber' => $r->contactnumber,
            'academicyear_id' => $r->academicyear_id,
            'programme_id' => $r->programme_id,
            'nber_id' => $r->nber_id
        ]);
      /*   $filestart = $ri->id.'-'.$institute_id;
       if($request->has('attachment')){
            $file = public_path().'/files/temp/'. $request->attachment;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/institute/issues/'.$filename;
            File::move($file,$destination);
            $ri->update(['attachement'=> $filename]);
        } */
        
        Session::put('messages',"Thank you for your feedback.");
        return redirect('/notice');

    }

    public function index() {
        //$institute = Institute::where('user_id',Auth::user()->id)->first();

        echo 'Hi';
    }

    public function check() {
          echo 'Hi';
    }
    public function changepassword(){
        $user = Auth::user();
        $user->save();
        return view('institute.changepassword',compact('user'));
    }

    public function updatepassword(Request $r){
        $rules = [
            'oldpwd' => 'required',
            'password' =>  'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'oldpwd.required' => "Current Password cannot be empty",
            'password.regex' => "Please enter a strong password. Password must be min 8 charater including upper case and lower case alphabets, number, and charaters",
        ];
        
        $this->validate($r, $rules,$messages);

        $user = Auth::user();
        if(Hash::check($r->oldpwd,$user->password)){
            $user->password=Hash::make($r->password);
            $user->confirmed = 1;
            $user->save();
            $institute = Institute::where('user_id',Auth::user()->id)->first();
            $institute->is_password_updated = 1;
            $institute->save();
        }else{
            
            Session::put('error','Current password you have entered is wrong.');
            return back();
        }
        Session::put('messages','Password Updated');
        return redirect('.');
    }
    public function update_location(Request $request)
    {


        // Handle file upload if an image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->id . 'PH.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/institutes'), $imageName);
        }
    
        $updateData = [];
        if ($request->latitude && $request->longitude) {
            $updateData['coordinate'] = DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')");
        }
        if ($request->state_id) {
            $updateData['state_id'] = $request->state_id;
        }
        if ($request->district_id) {
            $updateData['district_id'] = $request->district_id;
        }
        if ($request->subdistrict_id) {
            $updateData['subdistrict_id'] = $request->subdistrict_id;
        }
        if ($request->newaddress) {
            $updateData['newaddress'] = $request->newaddress;
        }
            Institute::where('rci_code', $request->id)
            ->update($updateData);
    
            $institute_location = Institute::where('user_id', Auth::user()->id)->first(); 
         
            Session::put('institute_location',$institute_location);
        return back();
    }
    public function update_nsp(Request $request){
        if ($request->national_nsp) {
            $updateData['national_nsp'] = $request->national_nsp;
        }
        if ($request->state_nsp) {
            $updateData['state_nsp'] = $request->state_nsp;
        }
            Institute::where('rci_code', $request->id)
            ->update($updateData);
    
        return back();

    }
}
