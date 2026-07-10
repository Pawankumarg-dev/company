<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use App\EpariveshStudent;
use App\Epariveshacadmic;
use Validator;

class AdmissionController extends Controller
{


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
        Session::flash('messages','Registration successful');
        return redirect('otp-login');
    }


    public function admission(Request $request)
    {
    $mobile = '6307079220'; // Replace with the actual mobile number you want to search for
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
    $studentDetails = EpariveshStudent::where('mobile', $mobile)->first();
   
    return view('admission.admission', compact('states_disticts', 'studentDetails'));
}

public function admissionSave(Request $request)
{
    $step = (int) $request->input('step');
    switch ($step) {
        case 1:
            return $this->saveStep1($request);
        case 2:
            return $this->saveStep2($request);
        case 3:
            return $this->saveStep3($request);
        case 4:
            return $this->saveStep4($request);
        default:
            return response()->json(['errors' => ['step' => ['Invalid step.']]], 422);
    }
}

private function saveStep1(Request $request)
{
    $validator = Validator::make($request->all(), [
        'father_name'  => 'required|string|max:255',
        'mother_name'  => 'required|string|max:255',
        'gender'       => 'required|in:1,2,3',
        'pwd'          => 'required|in:yes,no',
        'dob'          => 'required|date',
        'nationality'  => 'required|in:86,0',
        'category'     => 'required|in:GENERAL,OBC,SCHEDULED CASTE (SC),SCHEDULED TRIBE (ST)',
        'ews'          => 'required|in:yes,no',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    if (!empty($request->student_id)) {
        $student = EpariveshStudent::find($request->student_id);
        $student->CreatedOn = date('Y-m-d H:i:s');
        $student->LastName = '';
        $student->FatherName = $request->father_name;
        $student->MotherName = $request->mother_name;
        $student->DateofBirth = $request->dob;
        $student->IsPWD = $request->pwd;
        $student->IsEWS = $request->ews;
        $student->nationality_id = $request->nationality;
        $student->nationalityname = $request->nationality === '86' ? 'Indian' : 'Other';
        $student->countryname = $request->nationality === '86' ? 'India' : 'Other';
        $student->categoryname = $request->category;
        $student->gendername = $request->gender;
        $student->save();
    } 
        // $student->RegistrationNo = 'RCI' . date('YmdHis') . rand(100, 999);
        // $student->StudentSysCode = $student->RegistrationNo;
        // $student->status = 'draft';
    return response()->json([
        'student_id'      => $student->id,
        'registration_no' => $student->RegistrationNo,
    ]);
}

    private function saveStep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'corr_address'      => 'required|string',
            'corr_state'        => 'required',
            'corr_district'     => 'required',
            'corr_subdistrict'  => 'required|string|max:255',
            'corr_block'        => 'required|string|max:255',
            'corr_pin'          => 'required|digits:6',
            'perm_address'      => 'required|string',
            'perm_state'        => 'required',
            'perm_district'     => 'required',
            'perm_subdistrict'  => 'required|string|max:255',
            'perm_block'        => 'required|string|max:255',
            'perm_pin'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $corr_disticts = DB::table('districts')->select('districtName')->where('districtCode', $request->corr_district)->first();
        $corr_states   = DB::table('lgstates')->select('state_name')->where('state_code', $request->corr_state)->first();
        $perm_disticts = DB::table('districts')->select('districtName')->where('districtCode', $request->perm_district)->first();
        $perm_states   = DB::table('lgstates')->select('state_name')->where('state_code', $request->perm_state)->first();

        if (!$corr_disticts || !$corr_states || !$perm_disticts || !$perm_states) {
            return response()->json(['errors' => ['state_district' => ['Invalid state or district selected']]], 422);
        }

        $student = EpariveshStudent::findOrFail($request->student_id);

        // Correspondence Address
        $student->CorrespondanceAddress        = $request->corr_address;
        $student->CorrespondanceAddressState   = $corr_states->state_name;
        $student->CorrespondanceAddressDistrict = $corr_disticts->districtName;
        $student->cstate_id                    = $request->corr_state;
        $student->cdistrict_id                 = $request->corr_district;
        $student->corrSubdistictTehsil         = $request->corr_subdistrict;
        $student->corrBlock                    = $request->corr_block;
        $student->corrPincode                  = $request->corr_pin;

        // Permanent Address
        $student->PermanentAddress        = $request->perm_address;
        $student->PermanentAddressstate  = $perm_states->state_name;
        $student->PermanentAddressdistrict = $perm_disticts->districtName;
        $student->pstate_id               = $request->perm_state;
        $student->pdistrict_id            = $request->perm_district;
        $student->perSubdistictTehsil     = $request->perm_subdistrict;
        $student->perBlock                = $request->perm_block;
        $student->perPincode              = $request->perm_pin;

        $student->save();

        return response()->json(['status' => 'success']);
    }

    private function saveStep3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'board10'    => 'required|string',
            'year10'     => 'required|integer|min:1950|max:2026',
            'total10'    => 'required|numeric|min:1',
            'marks10'    => 'required|numeric|min:0',
            'percent10'  => 'required|numeric|min:0|max:99.99',
            'subject10'  => 'required|string|max:255',

            'board12'    => 'required|string',
            'year12'     => 'required|integer|min:1950|max:2026',
            'total12'    => 'required|numeric|min:1',
            'marks12'    => 'required|numeric|min:0',
            'percent12'  => 'required|numeric|min:0|max:99.99',
            'subject12'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->marks10 > $request->total10) {
            return response()->json(['errors' => ['marks10' => ['Marks obtained cannot exceed total marks']]], 422);
        }
        if ($request->marks12 > $request->total12) {
            return response()->json(['errors' => ['marks12' => ['Marks obtained cannot exceed total marks']]], 422);
        }

        $student = EpariveshStudent::findOrFail($request->student_id);

        try {
        
            $tenth = new Epariveshacadmic();
            $tenth->eparivesh_student_id = $student->id;
            // $tenth->StudentSysCode       = $student->StudentSysCode;
            // $tenth->registration_no      = $student->RegistrationNo;
            $tenth->qulification_name    = '10 STANDARD OR EQUIVALENT';
            $tenth->board_name           = $request->board10;
            $tenth->passing_year         = $request->year10;
            $tenth->max_marks            = $request->total10;
            $tenth->obtained_marks       = $request->marks10;
            $tenth->percentage           = $request->percent10;
            $tenth->subjects             = 'NA'; // see note above — subject10 input is currently discarded
            $tenth->marksheet            = '';
            $tenth->save();

            $twelveth = new Epariveshacadmic();
            $twelveth->eparivesh_student_id = $student->id;
            // $twelveth->StudentSysCode       = $student->StudentSysCode;
            // $twelveth->registration_no      = $student->RegistrationNo;
            $twelveth->qulification_name    = '10+2 OR EQUIVALENT';
            $twelveth->board_name           = $request->board12;
            $twelveth->passing_year         = $request->year12;
            $twelveth->max_marks            = $request->total12;
            $twelveth->obtained_marks       = $request->marks12;
            $twelveth->percentage           = $request->percent12;
            $twelveth->subjects             = $request->subject12;
            $twelveth->marksheet            = '';
            $twelveth->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Could not save education details'], 500);
        }

        return response()->json(['status' => 'success']);
    }

private function saveStep4(Request $request)
{
    $rules = [
        'student_id'  => 'required|exists:eparivesh_students,id',
        'photo'       => 'required|image|mimes:jpeg,jpg,png|max:200',
        'marksheet10' => 'required|mimes:pdf|min:200|max:2048',
        'marksheet12' => 'required|mimes:pdf|min:200|max:2048',
    ];

    if ($request->input('pwd') === 'yes') {
        $rules['pwd_certificate'] = 'required|mimes:pdf|min:200|max:2048';
    }
    if (in_array($request->input('category'), ['obc', 'sc', 'st'])) {
        $rules['category_certificate'] = 'required|mimes:pdf|min:200|max:2048';
    }
    if ($request->input('ews') === 'yes') {
        $rules['ews_certificate'] = 'required|mimes:pdf|min:200|max:2048';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $student = EpariveshStudent::findOrFail($request->student_id);
    $uploadDir = public_path('uploads/admission');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoFileName = 'photo_' . time() . '_' . rand(1000, 9999) . '.' . $photo->getClientOriginalExtension();
        $photo->move($uploadDir, $photoFileName);
        $student->photo = 'uploads/admission/' . $photoFileName;
    }

    if ($request->hasFile('pwd_certificate')) {
        $pwdCertificate = $request->file('pwd_certificate');
        $pwdCertificateFileName = 'pwd_certificate_' . time() . '_' . rand(1000, 9999) . '.' . $pwdCertificate->getClientOriginalExtension();
        $pwdCertificate->move($uploadDir, $pwdCertificateFileName);
        $student->pwdCertificate = 'uploads/admission/' . $pwdCertificateFileName;
    }

    $student->status = 'pending';
    $student->save();

    if ($request->hasFile('marksheet10')) {
        $marksheet10 = $request->file('marksheet10');
        $marksheet10FileName = 'marksheet10_' . time() . '_' . rand(1000, 9999) . '.' . $marksheet10->getClientOriginalExtension();
        $marksheet10->move($uploadDir, $marksheet10FileName);
        Epariveshacadmic::where('eparivesh_student_id', $student->id)
            ->where('qulification_name', '!=', '10+2 OR EQUIVALENT')
            ->update(['marksheet' => 'uploads/admission/' . $marksheet10FileName]);
    }

    if ($request->hasFile('marksheet12')) {
        $marksheet12 = $request->file('marksheet12');
        $marksheet12FileName = 'marksheet12_' . time() . '_' . rand(1000, 9999) . '.' . $marksheet12->getClientOriginalExtension();
        $marksheet12->move($uploadDir, $marksheet12FileName);
        Epariveshacadmic::where('eparivesh_student_id', $student->id)
            ->where('qulification_name', '10+2 OR EQUIVALENT')
            ->update(['marksheet' => 'uploads/admission/' . $marksheet12FileName]);
    }

    return response()->json([
        'status'          => 'success',
        'registration_no' => $student->RegistrationNo,
    ]);
}




    // Show OTP login form
    public function showOtpLogin()
    {
        return view('admission.otp_login');
    }

    // Send OTP to selected mobile or email
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target' => 'required|in:mobile,email',
            'mobile' => 'required_if:target,mobile|digits:10',
            'email' => 'required_if:target,email|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
