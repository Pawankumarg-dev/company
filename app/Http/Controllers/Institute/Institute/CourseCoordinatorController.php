<?php

namespace App\Http\Controllers\Institute;

use App\Approvedcoursecoordinator;
use App\City;
use App\Coursecoordinator;
use App\Coursecoordinatorcourse;
use App\Coursecoordinatorcoursetype;
use App\Coursecoordinatoreducationalqualification;
use App\Coursecoordinatorknownlanguage;
use App\Coursecoordinatorpastteachingexperience;
use App\Exam;
use App\Language;
use App\Programme;
use App\Rcicourse;
use App\Relationtype;
use App\Salutation;
use App\State;
use App\Title;
use Illuminate\Http\Request;
use App\Institute;
use Auth;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CourseCoordinatorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $coursecoordinators = Coursecoordinator::where('institute_id', Institute::where('user_id',Auth::user()->id)->first()->id)->get();

        return view('institute.coursecoordinators.index', compact('coursecoordinators'));
    }

    public function create() {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        $titles = Title::all();
        //$relationtypes = Relationtype::all();
        $states = State::orderBy('state_name')->get();
        $cities = City::orderBy('name')->get();

        $courses_handling = array('D.Ed.Spl.Ed.(ID)', 'D.Ed.Spl.Ed.(IDD)', 'D.Ed.Spl.Ed.(ASD)', 'D.Ed.Spl.Ed.(CP)', 'D.Ed.Spl.Ed.(MD)', 'D.R.T.', 'D.P.O.', 'D.V.R.(ID)', 'D.E.C.S.E(ID)', 'D.C.B.R.', 'C.C.C.G.', 'C.C.R.T.');
        //$rcicourses = Rcicourse::orderBy('name')->get();
        //$coursecoordinatorcoursetypes = Coursecoordinatorcoursetype::all();
        //$languages = Language::all();
        //$programmes = Programme::where('recognised_by', 'RCI')->where('active_status', '1')->orderBy('sortorder')->get();

        return view('institute.coursecoordinators.create', compact('institute', 'states', 'cities', 'titles', 'courses_handling'));
    }

    public function checkaadhaarcardnumber(Request $request){
        $datafound = Coursecoordinator::where('aadhaarcard_number', $request->aadhaarcard_number)->exists();

        return response()->json($datafound);
    }

    public function checkmobilenumber(Request $request){
        $datafound = Coursecoordinator::where('mobile_number1', $request->mobile_number1)->exists();

        return response()->json($datafound);
    }

    public function checkwhatsappnumber(Request $request){
        $datafound = Coursecoordinator::where('whatsapp_number', $request->whatsapp_number)->exists();

        return response()->json($datafound);
    }

    public function checkemailaddress(Request $request){
        $datafound = Coursecoordinator::where('email_address1', $request->email_address1)->exists();

        return response()->json($datafound);
    }

    public function getcityid(Request $request){
        $data = City::where('state_id', $request->state_id)->orderBy('name')->get(['id', 'name']);

        return response()->json($data);
    }

    public function checkregistrationnumber(Request $request){
        $datafound = Coursecoordinator::where('registration_number', $request->registration_number)->exists();

        return response()->json($datafound);
    }

    public function getcoursecoordinatorcoursemode(Request $request){
        $data = Coursecoordinatorcourse::where('coursecoordinatorcoursetype_id', $request->coursecoordinatorcoursetype_id)->groupBy('course_mode')->get(['course_mode']);

        return response()->json($data);
    }

    public function getcoursecoordinatorcourseid(Request $request){
        $data = Coursecoordinatorcourse::where('coursecoordinatorcoursetype_id', $request->coursecoordinatorcoursetype_id)->where('course_mode', $request->course_mode)->get(['id', 'course_name']);

        return response()->json($data);
    }

    public function save(Request $request) {
        $coursecoordinator = Coursecoordinator::create([
            "title_id" => $request->title_id,
            "name" => strtoupper($request->name),
            "salutation_id" => $request->salutation_id,
            "relationtype_id" => $request->relationtype_id,
            "relationname" => strtoupper($request->relationname),
            "dob" => date("Y-m-d", strtotime($request->dob)),
            "gender_id" => $request->gender_id,
            "disability_status" => $request->disability_status,
            "aadhaarcard_number" => $request->aadhaarcard_number,
            "mobile_number1" => $request->mobile_number1,
            "whatsapp_number" => $request->whatsapp_number,
            "email_address1" => $request->email_address1,
            "address" => $request->address,
            "city_id" => $request->city_id,
            "pincode" => $request->pincode,
            "coursecoordinatorcoursetype_id" => $request->coursecoordinatorcoursetype_id,
            "registration_number" => $request->registration_number,
            "registration_year" => $request->registration_year,
            "expiration_year" => $request->expiration_year,
            "active_status" => "1"
        ]);

        if($request->disability_status == 'Yes') {
            $coursecoordinator->update([
                "disability_type" => strtoupper($request->disability_type),
                "disabilitycertificate_number" => strtoupper($request->disabilitycertificate_number),
            ]);
        }

        if($request->confirm_mobile_number2 == 'Yes') {
            $coursecoordinator->update(["mobile_number2" => $request->mobile_number2]);
        }

        if($request->confirm_email_address2 == 'Yes') {
            $coursecoordinator->update(["email_address2" => $request->email_address2]);
        }

        foreach ($request->coursecoordinatorcourse_count as $c) {
            Coursecoordinatoreducationalqualification::create([
                "coursecoordinator_id" => $coursecoordinator->id,
                "coursecoordinatorcourse_id" => $request->coursecoordinatorcourse_id[$c],
                "institute_name" => $request->course_institute_name[$c],
                "state_id" => $request->course_institute_stateid[$c],
                "completion_year" => $request->course_completion_year[$c]
            ]);
        }

        Approvedcoursecoordinator::create([
            "coursecoordinator_id" => $coursecoordinator->id,
            "institute_id" => $request->institute_id,
            "programme_id" => $request->present_programme_id,
            "joining_date" => date("Y-m-d", strtotime($request->present_joining_date)),
            "active_status" => "1"
        ]);

        if($request->confirm_pastexperience == 'Yes') {
            foreach ($request->past_count as $c) {
                Coursecoordinatorpastteachingexperience::create([
                    "coursecoordinator_id" => $coursecoordinator->id,
                    "designation" => $request->past_designation[$c],
                    "institute_name" => $request->past_institute_name[$c],
                    "state_id" => $request->past_institute_state[$c],
                    "joining_date" => date("Y-m-d", strtotime($request->past_joining_date[$c])),
                    "relieving_date" => date("Y-m-d", strtotime($request->past_relieving_date[$c])),
                ]);
            }
        }

        foreach ($request->language_count as $c){
            Coursecoordinatorknownlanguage::create([
                "coursecoordinator_id" => $coursecoordinator->id,
                "language_id" => $request->language_id[$c],
                "read_status" => $request->read_status[$c],
                "write_status" => $request->write_status[$c],
                "speak_status" => $request->speak_status[$c],
                "active_status" => '1'
            ]);
        }

        return redirect('/institute/coursecoordinators')->with('message', 'Course Coordinator detail added successfully.');
    }

    function download($id) {
        $coursecoordinator = Coursecoordinator::find($id);
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        $approvedcoursecoordinator = Approvedcoursecoordinator::where('institute_id', $institute->id)
            ->where('coursecoordinator_id', $coursecoordinator->id)->where('active_status', '1')->first();

        if(is_null($approvedcoursecoordinator)) {
            echo 'No Record found';
        }
        else {
            return view('institute.coursecoordinators.download', compact('approvedcoursecoordinator'));
        }
    }

    public function sendMobileNumberVerificationCode(Request $request) {
        $api_key = '25FA4F48782DFA';
        $contacts = trim($request->mobileNumber);
        $from = 'CHNBER';
        $template_id = '1207165062739786623';
        $verificationCode = trim($request->verificationCode);
        $sms_text = urlencode('Dear Official, '.$verificationCode.' is the mobile verification code. Regards, NIEPMD-NBER, Chennai.');

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=" . $api_key . "&campaign=0&routeid=13&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id;

        $responseData = file_get_contents($api_url);

        return response()->json($responseData);
    }

    public function sendEmailAddressVerificationCode(Request $request) {
        $responseData = "";
        try {
            $verificationCode = trim($request->verificationCode);
            $to_name = "Applicant";
            $to_email = trim($request->emailAddress);

            Mail::send('institute.coursecoordinators.send_email_address_verification_code', ['verificationCode' => $verificationCode], function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Course Coordinator Email Verification Code');
                $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
            });

            $responseData = 1;
        }
        catch (\Exception $ex){
            $responseData = $ex->getMessage();
        }

        return response()->json($responseData);
    }

    public function addDetails(Request $request) {
        $sno = -1;

        $courses = null;

        foreach ($request->coursesHandlingAppliedStatus as $status){
            $sno++;

            if($status == 1) {
                if(!is_null($courses)) {
                    $courses .= ", ";
                }
                $courses .= $request->courses_handling[$sno];
            }
        }

        Coursecoordinator::create([
            "institute_id" => $request->institute_id,
            "title_id" => $request->title,
            "name" => trim($request->name),
            "dob" => date("Y-m-d", strtotime($request->dob)),
            "gender_id" => $request->gender,
            "disability_status" => $request->disability_status,
            "mobile_number" => trim($request->mobile_number),
            "email_address" => trim($request->email_address),
            "whatsapp_number" => trim($request->whatsapp_number),
            "address" => trim($request->address),
            "city_id" => $request->city_id,
            "pincode" => trim($request->pincode),
            "registration_number" => trim($request->registration_number),
            "rci_qualifications" =>trim($request->rci_qualifications),
            "other_qualifications" => trim($request->other_qualifications),
            "courses_handling" => $courses,
            "present_working_status" => "Yes",
            "teaching_experience" => trim($request->teaching_experience),
            "active_status" => 1
        ]);

        return redirect('/institute/coursecoordinators')->with(['message' => 'Course Coordinator details added Successfully']);
    }
}
