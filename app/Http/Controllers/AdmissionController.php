<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;
use App\EpariveshStudent;
use App\Epariveshacadmic;
use Validator;

class AdmissionController extends Controller
{
    public function admission(){
    // $institutes = \App\Institute::where('active_status',1)->whereNull('deleted_at')->get();
    // $courses = \App\Course::whereNull('status')->get();
    // $state_code = 6 ;
    // $state_name = DB::table('lgstates')->where('state_code', $state_code)->value('state_name');
    // $disticts = DB::table('districts')->where('state_code', $state_code)->orderBy('districtName')->get();
    $states_disticts = DB::table('lgstates')
    ->join('districts', 'lgstates.state_code', '=', 'districts.state_code')
    ->select(
        'lgstates.state_name',
        'lgstates.state_code',
        'lgstates.id as state_id',
        'districts.id as distict_id',
        'districts.districtName',
        'districts.districtCode'
    )
   
    ->orderBy('lgstates.state_name', 'asc')
    ->get();
    return view('admission.admission', compact('states_disticts'));
}

public function admission_save(Request $request)
{
    

    $registrationNo = 'RCI' . date('YmdHis') . rand(100, 999);
    $uploadDir = public_path('uploads/admission');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $photoPath = '';
    $marksheet10Path = '';
    $marksheet12Path = '';
    $pwdCertificatePath = '';

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoFileName = 'photo_' . time() . '_' . rand(1000, 9999) . '.' . $photo->getClientOriginalExtension();
        $photo->move($uploadDir, $photoFileName);
        $photoPath = 'uploads/admission/' . $photoFileName;
    }

    if ($request->hasFile('marksheet10')) {
        $marksheet10 = $request->file('marksheet10');
        $marksheet10FileName = 'marksheet10_' . time() . '_' . rand(1000, 9999) . '.' . $marksheet10->getClientOriginalExtension();
        $marksheet10->move($uploadDir, $marksheet10FileName);
        $marksheet10Path = 'uploads/admission/' . $marksheet10FileName;
    }

    if ($request->hasFile('marksheet12')) {
        $marksheet12 = $request->file('marksheet12');
        $marksheet12FileName = 'marksheet12_' . time() . '_' . rand(1000, 9999) . '.' . $marksheet12->getClientOriginalExtension();
        $marksheet12->move($uploadDir, $marksheet12FileName);
        $marksheet12Path = 'uploads/admission/' . $marksheet12FileName;
    }

    if ($request->hasFile('pwd_certificate')) {
        $pwdCertificate = $request->file('pwd_certificate');
        $pwdCertificateFileName = 'pwd_certificate_' . time() . '_' . rand(1000, 9999) . '.' . $pwdCertificate->getClientOriginalExtension();
        $pwdCertificate->move($uploadDir, $pwdCertificateFileName);
        $pwdCertificatePath = 'uploads/admission/' . $pwdCertificateFileName;
    }

    $student = new EpariveshStudent();
    $student->RegistrationNo = $registrationNo;
    $student->StudentSysCode = $registrationNo;
    $student->FirstName = $request->student_name;
    $student->LastName = '';
    $student->FatherName = $request->father_name;
    $student->MotherName = $request->mother_name;
    $student->email = $request->email;
    $student->mobile = $request->mobile;
    $student->DateofBirth = $request->dob;
    $student->IsEWS = $request->ews;
    $student->IsPWD = $request->pwd;
    $student->PermanentAddress = $request->perm_address;
    $student->PermanentAddressdistrict = $request->perm_district;
    $student->pstate_id = is_numeric($request->perm_state) ? $request->perm_state : null;
    $student->PermanentAddressstate = $request->perm_state;
    $student->CorrespondanceAddress = $request->corr_address;
    $student->CorrespondanceAddressDistrict = $request->corr_district;
    $student->cstate_id = is_numeric($request->corr_state) ? $request->corr_state : null;
    $student->CorrespondanceAddressState = $request->corr_state;
    $student->IPAddress = $request->ip();
    $student->CreatedOn = date('Y-m-d H:i:s');
    $student->nationality_id = $request->nationality;
    $student->nationalityname = $request->nationality === 'india' ? 'Indian' : 'Other';
    $student->gendername = $request->gender === 'male' ? 1 : ($request->gender === 'female' ? 2 : 3);
    $student->communities_id = null;
    $student->categoryname = $request->category;
    $student->countryname = $request->nationality === 'india' ? 'India' : 'Other';
    $student->status = 'pending';
    $student->institute_id = $request->institute_id;
    $student->course_id = $request->course_id;
    $student->addharNumber = $request->aadhar_number;
    $student->pwdCertificate = $pwdCertificatePath;
    $student->photo = $photoPath;
    $student->save();

    $tenth = new Epariveshacadmic();
    $tenth->eparivesh_student_id = $student->id;
    $tenth->registration_no = $registrationNo;
    $tenth->qulification_name = $request->board10;
    $tenth->board_name = $request->board10;
    $tenth->passing_year = $request->year10;
    $tenth->max_marks = $request->total10;
    $tenth->obtained_marks = $request->marks10;
    $tenth->percentage = $request->percent10;
    $tenth->subjects = $request->subject10;
    $tenth->marksheet = $marksheet10Path;
    $tenth->save();

    $twelveth = new Epariveshacadmic();
    $twelveth->eparivesh_student_id = $student->id;
    $twelveth->registration_no = $registrationNo;
    $twelveth->qulification_name = '10+2 OR EQUIVALENT';
    $twelveth->board_name = $request->board12;
    $twelveth->passing_year = $request->year12;
    $twelveth->max_marks = $request->total12;
    $twelveth->obtained_marks = $request->marks12;
    $twelveth->percentage = $request->percent12;
    $twelveth->subjects = $request->subject12;
    $twelveth->marksheet = $marksheet12Path;
    $twelveth->save();

    return redirect('/admission')->with('success', 'Admission submitted. Your Registration No is ' . $registrationNo);
}


public function registration(){
    $states = DB::table('lgstates')->get();
    return view('admission.registration', compact('states'));
}

public function registration_save(Request $request){
    //dd($request->all());
    $mobileExists = EpariveshStudent::select('mobile')->where('mobile', $request->mobile)->first();
    $emailExists = EpariveshStudent::select('email')->where('email', $request->email)->first();

    $errors = [];
    if (EpariveshStudent::where('mobile', $request->mobile)->exists()) {
        $errors['mobile'] = 'Mobile number already exists.';
    }
    if (EpariveshStudent::where('email', $request->email)->exists()) {
        $errors['email'] = 'Email address already exists.';
    }
    if (!empty($errors)) {
        return redirect()->back() ->withErrors($errors) ->withInput();
    }
    $student = new EpariveshStudent();
    $student->FirstName = $request->first_name;
    $student->email = $request->email;
    $student->addharNumber = $request->aadhar_number;
    $student->mobile = $request->mobile;
    $student->pstate_id = $request->state_id;
    $student->save();
    session::flash('success', 'Registration successful.' );
}

    // Show OTP login form
    public function showOtpLogin()
    {
        return view('auth.otp_login');
    }

    // Send OTP to selected mobile or email
    public function sendOtp(Request $request)
    {
        

        $target = $request->target;
        $mobile = $request->mobile;
        $email = $request->email;
        $errors = [];

        if ($target === 'mobile') {
            if (!$mobile) {
                $errors['mobile'] = 'Please enter your mobile number.';
            } elseif (!EpariveshStudent::where('mobile', $mobile)->exists()) {
                $errors['mobile'] = 'This mobile number does not exist.';
            }
        }

        if ($target === 'email') {
            if (!$email) {
                $errors['email'] = 'Please enter your email address.';
            } elseif (!EpariveshStudent::where('email', $email)->exists()) {
                $errors['email'] = 'This email address does not exist.';
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $otp = rand(100000, 999999);
        $expires = time() + 300; // 5 minutes

        Session::put('otp.code', $otp);
        Session::put('otp.expires', $expires);
        Session::put('otp.target', $target);
        Session::put('otp.value', $target === 'mobile' ? $mobile : $email);

        if ($target === 'email') {
            try {
                Mail::raw('Your login OTP is: ' . $otp, function ($message) use ($email) {
                    $message->to($email)->subject('Login OTP');
                });
            } catch (\Exception $e) {
                Log::error('OTP email send failed: ' . $e->getMessage());
            }
        }

        if ($target === 'mobile') {
            // TODO: Integrate SMS gateway here.
            Log::info('OTP for mobile ' . $mobile . ' => ' . $otp);
        }

        return redirect('/otp-verify')->with('status', 'OTP sent to your selected contact.');
    }

    // Show OTP verification form
    public function showOtpVerify()
    {
        return view('auth.otp_verify');
    }

    // Verify OTP and create session
    public function verifyOtp(Request $request)
    {
        

        $stored = Session::get('otp', []);
        if (empty($stored) || time() > ($stored['expires'] ?? 0)) {
            return redirect('/otp-login')->withErrors(['otp' => 'OTP expired. Please request a new one.']);
        }

        if ($request->otp != $stored['code']) {
            return redirect()->back()->withErrors(['otp' => 'Incorrect OTP.'])->withInput();
        }

        // OTP valid - create a session user identifier
        Session::put('user_logged_in', true);
        Session::put('user_contact', $stored['value']);
        // clear otp
        Session::forget('otp');

        return redirect('/')->with('success', 'Logged in successfully');
    }

    // Logout
    public function logout()
    {
        Session::forget('user_logged_in');
        Session::forget('user_contact');
        return redirect('/')->with('success', 'Logged out');
    }
}
