<?php

namespace App\Http\Controllers\Expert;

use App\City;
use App\Expert;
use App\Expertlanguage;
use App\Expertnonteachingexperience;
use App\Expertqualification;
use App\Expertteachingexperience;
use App\Expertrciqualification;
use App\Gender;
use App\Language;
use App\Paymentbank;
use App\Rcicourse;
use App\Relationtype;
use App\Salutation;
use App\State;
use Illuminate\Http\Request;
use DateTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewApplicationController extends Controller
{
    //
    public function index() {
        return view('expert.newapplication.index');
    }

    public function applystage($stage_id) {
        if($stage_id == '1') {
            $salutations = Salutation::all();
            $relationtypes = Relationtype::all();
            $genders = Gender::all();
            return view('expert.newapplication.stage1.form', compact('relationtypes', 'genders', 'salutations'));
        }
        else {
            return view('expert.newapplication.stage'.$stage_id.'.login');
        }
    }

    public function checkstage1(Request $request) {
        $rules = [
            'title' => 'required',
            'name' => 'required',
            'relationtype_id' => 'required',
            'relation_name' => 'required',
            'dob' => 'required',
            'gender_id' => 'required',
            'has_disability' => 'required',
            'contactnumber1' => 'required | numeric',
            'contactnumber2' => 'present | numeric',
            'email' => 'required',
            'aadhaarcard_no' => 'required | numeric',
        ];

        $messages = [
            //title
            'title.required' => 'Please select the Title option',

            //name
            'name.required' => 'Please enter the name',

            //relationtype_id
            'relationtype_id.required' => 'Please select the Relation Type option',

            //relation_name
            'relation_name.required' => 'Please enter the Relation Name',

            //dob
            'dob.required' => 'Please select the Date of Birth',

            //gender_id
            'gender_id.required' => 'Please select the Gender option',

            //has_disability
            'has_disability.required' => 'Please select the Differently-Abled Person option',

            //contactnumber1
            'contactnumber1.required' => 'Please enter the Mobile Number',

            //email
            'email.required' => 'Please enter the Email ID',

            //aadhaarcard_no
            'aadhaarcard_no.required' => 'Please enter the Aadhaar Card Number',

            //confirm_password
            'confirm_password.required' => 'Please enter the Confirm Password',
        ];

        $validator = validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->title == '0') {
                $validator->errors()->add('title', 'Please select the valid Title option');
            }

            if($request->relationtype_id == '0') {
                $validator->errors()->add('relationtype_id', 'Please select the valid Relation type option');
            }

            if($request->gender_id == '0') {
                $validator->errors()->add('gender_id', 'Please select the valid Gender option');
            }

            if(Expert::where('email', $request->email)->count() > '0') {
                $validator->errors()->add('email', 'The Email ID that you have entered is already taken. Please try with another one');
            }

            if(Expert::where('contactnumber1', $request->contactnumber1)->count() > '0') {
                $validator->errors()->add('contactnumber1', 'The Mobile Number that you have entered is already taken. Please try with another one');
            }
            if(strlen($request->contactnumber1) != '10') {
                $validator->errors()->add('contactnumber1', 'Please enter the valid Mobile Number');
            }

            if(Expert::where('aadhaarcard_no', $request->aadhaarcard_no)->count() > '0') {
                $validator->errors()->add('aadhaarcard_no', 'The Aadhaar Card Number that you have entered is already entered.');
            }
            if(strlen($request->aadhaarcard_no) != '12') {
                $validator->errors()->add('aadhaarcard_no', 'Please enter the valid Aadhaar Card Number');
            }
        });

        $this->validateWith($validator);

        return $this->addstage1($request);
    }

    public function addstage1($request) {
        $expert = Expert::create([
            "title" => $request->title,
            "name" => $request->name,
            "relationtype_id" => $request->relationtype_id,
            "relation_name" => $request->relation_name,
            "dob" => date("Y-m-d", strtotime($request->dob)),
            "gender_id" => $request->gender_id,
            "has_disability" => $request->has_disability,
            "contactnumber1" => $request->contactnumber1,
            "contactnumber2" => $request->contactnumber2,
            "email" => $request->email,
            "aadhaarcard_no" => $request->aadhaarcard_no,
            "stages_passed" => "1",
        ]);

        $application_no = 'EXPAPP'.date_format($expert->created_at, "Y")."C";

        for($i=strlen($expert->id); $i<4; $i++ ) {
            $application_no .= '0';
        }

        $expert->update([
            "application_no" => $application_no.$expert->id,
        ]);

        return redirect()->route('/expert/application/stage1message', ["expert_id" => $expert->id]);
    }

    public function messagestage1($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage1.message', compact('expert'));
        }
    }

    public function checkstage2login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage2', ["expert_id" => $expert->id]);
    }

    public function displaystage2($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '1') {
                $cities = City::all();
                return view('expert.newapplication.stage2.form', compact('cities', 'expert'));
            }
            else {
                return view('expert.newapplication.stage2.message', compact('expert'));
            }
        }
    }

    public function checkstage2(Request $request) {
        $rules = [
            "door_no" => "present",
            "building_name" => "present",
            "street1" => "required",
            "street2" => "required",
            "landmark" => "present",
            "postoffice" => "required",
            "talukoffice" => "required",
            "city_id" => "required",
            "pincode" => "required"
        ];

        $messages = [
            "street1.required" => "Please enter the Street name",
            "street2.required" => "Please enter the name of the Area / Town / Village",
            "postoffice.required" => "Please enter the Post office name",
            "talukoffice.required" => "Please enter the Taluk office name",
            "city_id.required" => "Please select the District and State option",
            "pincode" => "Please enter the Pincode",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->city_id == '0') {
                $validator->errors()->add('city_id', 'Please select the valid District and State option');
            }
        });

        $this->validateWith($validator);

        return $this->addstage2($request);
    }

    public function addstage2($request) {
        $expert = Expert::find($request->expert_id);

        $expert->update([
            "door_no" => $request->door_no,
            "building_name" => $request->building_name,
            "street1" => $request->street1,
            "street2" => $request->street2,
            "landmark" => $request->landmark,
            "postoffice" => $request->postoffice,
            "talukoffice" => $request->talukoffice,
            "city_id" => $request->city_id,
            "pincode" => $request->pincode,
            "stages_passed" => "2",
        ]);

        return redirect()->route('/expert/application/stage2message', ["expert_id" => $expert->id]);
    }

    public function messagestage2($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage2.message', compact('expert'));
        }
    }

    public function checkstage3login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage3', ["expert_id" => $expert->id]);
    }

    public function displaystage3($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '2') {
                $expertqualifications = Expertqualification::where('expert_id', $expert->id)->get();
                return view('expert.newapplication.stage3.index', compact('expert', 'expertqualifications'));
            }
            else if($expert->stages_passed < '2') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage3message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function displaystage3form($expert_id){
        $states = State::orderBy('state_name')->get();
        $expert = Expert::find($expert_id);
        return view('expert.newapplication.stage3.form', compact('expert', 'states'));
    }

    public function checkstage3qualifications(Request $request) {
        $rules = [
            "course_type" => "required",
            "course_name" => "required",
            "course_mode" => "required",
            "institute_name" => "required",
            "state_id" => "required",
            "exambody_name" => "required",
            "course_complete_year" => "required",
            "certificate_no" => "required",
        ];

        $messages = [
            "course_type.required" => "Please select the Course Type option",
            "course_name.required" => "Please enter the Course Name",
            "course_mode.required" => "Please select the Course Mode option",
            "institute_name.required" => "Please enter the Institute Name",
            "state_id.required" => "Please select the State option",
            "exambody_name.required" => "Please enter the Exam body Name",
            "course_complete_year.required" => "Please enter the Course Complete Year",
            "certificate_no.required" => "Please enter the Certificate Number",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->course_type == '0') {
                $validator->errors()->add('course_type', 'Please select the valid Course Type option');
            }
            if($request->course_mode == '0') {
                $validator->errors()->add('course_mode', 'Please select the valid Course Mode option');
            }
            if($request->state_id == '0') {
                $validator->errors()->add('state_id', 'Please select the valid State / UT option');
            }
        });

        $this->validateWith($validator);

        return $this->addstage3qualifications($request);
    }

    public function addstage3qualifications($request) {
        $expert = Expert::find($request->expert_id);

        Expertqualification::create([
            "expert_id" => $request->expert_id,
            "course_type" => $request->course_type,
            "course_name" => $request->course_name,
            "course_mode" => $request->course_mode,
            "institute_name" => $request->institute_name,
            "state_id" => $request->state_id,
            "exambody_name" => $request->exambody_name,
            "course_complete_year" => $request->course_complete_year,
            "certificate_no" => $request->certificate_no,
        ]);

        return redirect()->route('/expert/application/applystage3', ["expert_id" => $request->expert_id]);
    }

    public function addstage3(Request $request) {
        $expert = Expert::find($request->expert_id);

        $expert->update([
            "stages_passed" => "3",
        ]);

        return redirect()->route('/expert/application/stage3message', ["expert_id" => $expert->id]);
    }

    public function messagestage3($expert_id) {
        $expert = Expert::find($expert_id);
        $expertqualifications = Expertqualification::where('expert_id', $expert->id)->get();

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage3.message', compact('expert', 'expertqualifications'));
        }
    }

    public function checkstage4login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",
            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage4', ["expert_id" => $expert->id]);
    }

    public function displaystage4($expert_id) {
        $expert = Expert::where('id', $expert_id)->first();

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '3') {
                return view('expert.newapplication.stage4.index', compact('expert'));
            }
            else if($expert->stages_passed < '3') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage4message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function displaystage4form($expert_id){
        $states = State::orderBy('state_name')->get();
        $rcicourses = Rcicourse::all();
        $expert = Expert::find($expert_id);
        return view('expert.newapplication.stage4.form', compact('expert', 'states', 'rcicourses'));
    }

    public function checkstage4qualifications(Request $request) {
        $rules = [
            "rcicourse_id" => "required",
            "institute_name" => "required",
            "state_id" => "required",
            "exambody_name" => "required",
            "course_complete_year" => "required",
            "certificate_no" => "required",
        ];

        $messages = [
            "rcicourse_id.required" => "Please select the RCI Course",
            "institute_name.required" => "Please enter the Institute Name",
            "state_id.required" => "Please select the State option",
            "exambody_name.required" => "Please enter the Exam body Name",
            "course_complete_year.required" => "Please enter the Course Complete Year",
            "certificate_no.required" => "Please enter the Certificate Number",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->rcicourse_id == '0') {
                $validator->errors()->add('rcicourse_id', 'Please select the valid RCI Course option');
            }
            if($request->state_id == '0') {
                $validator->errors()->add('state_id', 'Please select the valid State / UT option');
            }
        });

        $this->validateWith($validator);

        return $this->addstage4qualifications($request);
    }

    public function addstage4qualifications($request) {
        $expert = Expert::find($request->expert_id);

        Expertrciqualification::create([
            "expert_id" => $request->expert_id,
            "rcicourse_id" => $request->rcicourse_id,
            "institute_name" => $request->institute_name,
            "state_id" => $request->state_id,
            "exambody_name" => $request->exambody_name,
            "course_complete_year" => $request->course_complete_year,
            "certificate_no" => $request->certificate_no,
        ]);

        return redirect()->route('/expert/application/applystage4', ["expert_id" => $request->expert_id]);
    }

    public function addstage4(Request $request) {
        $expert = Expert::find($request->expert_id);

        $expert->update([
            "stages_passed" => "4",
        ]);

        return redirect()->route('/expert/application/stage4message', ["expert_id" => $expert->id]);
    }

    public function messagestage4($expert_id) {
        $expert = Expert::find($expert_id);
        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage4.message', compact('expert', 'expertqualifications'));
        }
    }

    public function checkstage5login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage5', ["expert_id" => $expert->id]);
    }

    public function displaystage5($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '4') {
                $states = State::orderBy('state_name')->get();
                return view('expert.newapplication.stage5.form', compact('expert', 'states'));
            }
            else if($expert->stages_passed < '4') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage5message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function addstage5(Request $request) {
        $rules = [
            "has_crr_no" => "required",
        ];

        if($request->has_crr_no == 'Yes') {
            $rules["crr_no"] = "required | alpha_num";
            $rules["crr_no_issued_year"] = "required";
            $rules["file_crr_no"] = "required | max: 1024 | mimes:jpeg,bmp,png,gif,svg,pdf";
        }

        $messages = [
            "has_crr_no.required" => "Please select the valid option",
            "crr_no.alpha_num" => "Please enter the valid CRR No",
            "file_crr_no.required" => "Please upload the Scanned copy of CRR No",
            "file_crr_no.max" => "The uploaded file should be less than 1 MB",
            "file_crr_no.mimes" => "The upload file should be in the format of jpeg, png, jpg, pdf only",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            if($request->has('file_crr_no')) {
                $file = $request->file('file_crr_no');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('file_crr_no', "The uploaded file should in .jpg  or .pdf format");
                }
            }
        });

        $this->validateWith($validator);

        $expert = Expert::find($request->expert_id);

        if($request->has_crr_no == 'Yes') {
            $file = $request->file('file_crr_no');
            $filename = $request->crr_no.'.'.$file->getClientOriginalExtension();
            $destination = public_path()."/files/experts/crrno/";
            $file->move($destination, $filename);

            $expert->update([
                "crr_no" => $request->crr_no,
                "crr_no_issued_year" => date("Y", strtotime($request->crr_no_issued_year)),
                "file_crr_no" => $filename,
            ]);
        }

        $expert->update([
            "has_crr_no" => $request->has_crr_no,
            "stages_passed" => "5",
        ]);

        return $this->messagestage5($request->expert_id);
    }

    public function messagestage5($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage5.message', compact('expert'));
        }
    }

    public function checkstage6login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage6', ["expert_id" => $expert->id]);
    }

    public function displaystage6($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '5') {
                $expertteachingexperiences = Expertteachingexperience::where('expert_id', $expert->id)->get();
                return view('expert.newapplication.stage6.index', compact('expert', 'expertteachingexperiences'));
            }
            else if($expert->stages_passed < '5') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage6message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function displaystage6form($expert_id){
        $expert = Expert::find($expert_id);
        $states = State::all();
        $expertteachingexperiences = Expertteachingexperience::where('expert_id', $expert->id)->get();
        return view('expert.newapplication.stage6.form', compact('expert', 'expertteachingexperiences', 'states'));
    }

    public function addstage6(Request $request) {
        $rules = [
            "is_presently_working" => "required",
            "organization_category" => "required",
            "organization_type" => "required",
            "designation" => "required",
            "department" => "required",
            "organization_name" => "required",
            "organization_address" => "required",
            "state_id" => "required",
            "from_date" => "required",
        ];

        if($request->is_presently_working == "No") {
            $rules = [
                "to_date" => "required",
                "file_experience" => "required | max: 1024 | mimes:jpeg,bmp,png,gif,svg,pdf",
            ];
        }

        $messages = [
            "is_presently_working.required" => "Please select the valid option",
            "file_experience.required" => "Please upload the Scanned copy of Experience Certificate",
            "file_experience.max" => "The uploaded file should be less than 1 MB",
            "file_experience.mimes" => "The upload file should be in the format of jpeg, png, jpg, pdf only",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->organization_type == '0') {
                $validator->errors()->add('organization_type', 'Please select the valid Organization Type option');
            }
            if($request->organization_category == '0') {
                $validator->errors()->add('organization_category', 'Please select the valid Organization Category option');
            }
            if($request->state_id == '0') {
                $validator->errors()->add('state_id', 'Please select the valid State / UT option');
            }
            if($request->has('file_experience')) {
                $file = $request->file('file_experience');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('file_experience', "The uploaded file should in .jpg  or .pdf format");
                }
            }
        });

        $this->validateWith($validator);

        $expert = Expert::find($request->expert_id);

        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d");
        $date_1 = new DateTime($from_date);
        $date_2 = new DateTime($to_date);

        if($request->is_presently_working == "No") {
            $to_date = date("Y-m-d", strtotime($request->to_date));
            $date_2 = new DateTime($to_date);

        }
        $experience = date_diff($date_1, $date_2)->format('%y.0%m');

        $expertteachingexperience = Expertteachingexperience::create([
            "expert_id" => $expert->id,
            "is_presently_working" => $request->is_presently_working,
            "organization_category" => $request->organization_category,
            "organization_type" => $request->organization_type,
            "designation" => $request->designation,
            "department" => $request->department,
            "organization_name" => $request->organization_name,
            "organization_address" => $request->organization_address,
            "state_id" => $request->state_id,
            "from_date" => $from_date,
            "to_date" => $to_date,
            "experience" => $experience,
        ]);

        if($request->is_presently_working == 'No') {
            $file = $request->file('file_experience');
            $filename = "TEXPC";
            for($i=strlen($expertteachingexperience->id); $i<4; $i++ ) {
                $filename .= '0';
            }
            $filename .= $expertteachingexperience->id.'.'.$file->getClientOriginalExtension();
            $destination = public_path()."/files/experts/experience/";
            $file->move($destination, $filename);
        }

        if($request->is_presently_working == 'No') {
            $expertteachingexperience->update([
                "file_experience" => $filename,
            ]);
        }

        return redirect()->route('/expert/application/applystage6', ["expert_id" => $expert->id]);
    }

    public function addstage6experiences(Request $request) {
        $expert = Expert::find($request->expert_id);

        $expert->update([
            "stages_passed" => "6",
        ]);

        return redirect()->route('/expert/application/stage6message', ["expert_id" => $expert->id]);
    }

    public function messagestage6($expert_id) {
        $expert = Expert::find($expert_id);
        $expertteachingexperiences = Expertteachingexperience::where('expert_id', $expert->id)->get();

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage6.message', compact('expert', 'expertteachingexperiences'));
        }
    }

    public function checkstage7login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage7', ["expert_id" => $expert->id]);
    }

    public function displaystage7($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '6') {
                $expertnonteachingexperiences = Expertnonteachingexperience::where('expert_id', $expert->id)->get();
                return view('expert.newapplication.stage7.index', compact('expert', 'expertnonteachingexperiences'));
            }
            else if($expert->stages_passed < '6') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage7message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function displaystage7form($expert_id){
        $expert = Expert::where('id', $expert_id)->first();
        $states = State::all();

        return view('expert.newapplication.stage7.form', compact('expert', 'expertnonteachingexperiences', 'states'));

    }

    public function addstage7(Request $request) {
        $rules = [
            "is_presently_working" => "required",
            "organization_category" => "required",
            "designation" => "required",
            "department" => "required",
            "organization_name" => "required",
            "organization_address" => "required",
            "state_id" => "required",
            "from_date" => "required",
        ];

        if($request->is_presently_working == "No") {
            $rules = [
                "to_date" => "required",
                "file_experience" => "required | max: 1024 | mimes:jpeg,bmp,png,gif,svg,pdf",
            ];
        }

        $messages = [
            "is_presently_working.required" => "Please select the valid option",
            "file_experience.required" => "Please upload the Scanned copy of Experience Certificate",
            "file_experience.max" => "The uploaded file should be less than 1 MB",
            "file_experience.mimes" => "The upload file should be in the format of jpeg, png, jpg, pdf only",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->organization_type == '0') {
                $validator->errors()->add('organization_type', 'Please select the valid Organization Type option');
            }
            if($request->organization_category == '0') {
                $validator->errors()->add('organization_category', 'Please select the valid Organization Category option');
            }
            if($request->state_id == '0') {
                $validator->errors()->add('state_id', 'Please select the valid State / UT option');
            }
            if($request->has('file_experience')) {
                $file = $request->file('file_experience');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('file_experience', "The uploaded file should in .jpg  or .pdf format");
                }
            }
        });

        $this->validateWith($validator);

        $expert = Expert::find($request->expert_id);

        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d");
        $date_1 = new DateTime($from_date);
        $date_2 = new DateTime($to_date);

        if($request->is_presently_working == "No") {
            $to_date = date("Y-m-d", strtotime($request->to_date));
            $date_2 = new DateTime($to_date);

        }
        $experience = date_diff($date_1, $date_2)->format('%y.0%m');

        $expertnonteachingexperience = Expertnonteachingexperience::create([
            "expert_id" => $expert->id,
            "is_presently_working" => $request->is_presently_working,
            "organization_category" => $request->organization_category,
            "designation" => $request->designation,
            "department" => $request->department,
            "organization_name" => $request->organization_name,
            "organization_address" => $request->organization_address,
            "state_id" => $request->state_id,
            "from_date" => $from_date,
            "to_date" => $to_date,
            "experience" => $experience,
        ]);

        if($request->is_presently_working == 'No') {
            $file = $request->file('file_experience');
            $filename = "NTEXPC";
            for($i=strlen($expertnonteachingexperience->id); $i<4; $i++ ) {
                $filename .= '0';
            }
            $filename .= $expertnonteachingexperience->id.'.'.$file->getClientOriginalExtension();
            $destination = public_path()."/files/experts/experience/";
            $file->move($destination, $filename);
        }

        if($request->is_presently_working == 'No') {
            $expertnonteachingexperience->update([
                "file_experience" => $filename,
            ]);
        }

        return redirect()->route('/expert/application/applystage7', ["expert_id" => $expert->id]);
    }

    public function addstage7experiences(Request $request) {
        $expert = Expert::find($request->expert_id);

        $expert->update([
            "stages_passed" => "7",
        ]);

        return redirect()->route('/expert/application/stage7message', ["expert_id" => $expert->id]);
    }

    public function messagestage7($expert_id) {
        $expert = Expert::find($expert_id);
        $expertnonteachingexperiences = Expertnonteachingexperience::where('expert_id', $expert->id)->get();

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage7.message', compact('expert', 'expertnonteachingexperiences'));
        }
    }

    public function checkstage8login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage8', ["expert_id" => $expert->id]);
    }

    public function displaystage8($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '7') {
                return view('expert.newapplication.stage8.index', compact('expert'));
            }
            else if($expert->stages_passed < '7') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage8message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function displaystage8form($expert_id){
        $expert = Expert::where('id', $expert_id)->first();
        $languages = Language::all();

        return view('expert.newapplication.stage8.form', compact('expert', 'languages'));
    }

    public function addstage8languages(Request $request) {
        $rules = [
            "language_id" => "required",
            "speak_status" => "present",
            "read_status" => "present",
            "write_status" => "present",
        ];

        $messages = [
            "language_id" => "Please select the language option",
            "speak_status.required" => "Please select the Speak Status",
            "read_status.required" => "Please select the Read Status",
            "write_status.required" => "Please select the Write Status",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->language_id == '0') {
                $validator->errors()->add('language_id', 'Please select the valid Language option');
            }
        });

        $this->validateWith($validator);

        $expert = Expert::where('id', $request->expert_id)->first();
        if(!is_null($expert)) {
            $expertlanguage = Expertlanguage::where('expert_id', $expert->id)->where('language_id', $request->language_id)->first();

            if(is_null($expertlanguage)) {
                Expertlanguage::create([
                    "expert_id" => $expert->id,
                    "language_id" => $request->language_id,
                    "speak_status" => $request->speak_status,
                    "read_status" => $request->read_status,
                    "write_status" => $request->write_status,
                ]);
            }
        }

        return redirect()->route('/expert/application/applystage8', ["expert_id" => $expert->id]);
    }

    public function addstage8(Request $request) {
        $expert = Expert::find($request->expert_id);

        $expert->update([
            "stages_passed" => "8",
        ]);

        return redirect()->route('/expert/application/stage8message', ["expert_id" => $expert->id]);
    }

    public function messagestage8($expert_id) {
        $expert = Expert::where('id', $expert_id)->first();

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage8.message', compact('expert'));
        }
    }

    public function checkstage9login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage9', ["expert_id" => $expert->id]);
    }

    public function displaystage9($expert_id){
        $expert = Expert::where('id', $expert_id)->first();
        $states = State::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '8') {
                return view('expert.newapplication.stage9.form', compact('expert', 'states', 'paymentbanks'));
            }
            else if($expert->stages_passed < '8') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage9message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function addstage9(Request $request) {
        $rules = [
            "pancard_no" => "required | alpha_num",
            "bank_account_no" => "required | numeric",
            "bank_ifsc_code" => "required | alpha_num",
            "bank_branch_name" => "required",
            "paymentbank_id" => "required",
            "state_id" => "required",
            "file_bank_passbook" => "required | max: 1024 | mimes:jpeg,bmp,png,gif,svg,pdf",
        ];

        $messages = [
            "pancard_no.required" => "Please enter the PAN Card Number",
            "pancard_no.alpha_num" => "Please enter the valid PAN Card Number",
            "bank_account_no.required" => "Please enter the Bank Account Number",
            "bank_account_no.numeric" => "Please enter the valid Bank Account Number",
            "bank_ifsc_code.required" => "Please enter the Bank IFSC Code",
            "bank_ifsc_code.alpha_num" => "Please enter the valid Bank IFSC Code",
            "bank_branch_name.required" => "Please enter the Bank's Branch Name",
            "paymentbank_id.required" => "Please select the Bank's Name",
            "state_id.required" => "Please select the State option",
            "file_bank_passbook.required" => "Please upload the scanned copy of the Bank's Passbook",
            "file_bank_passbook.max" => "The uploaded file should be less than 1 MB",
            "file_bank_passbook.mimes" => "The upload file should be in the format of jpeg, png, jpg, pdf only",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request) {
            if($request->state_id == '0') {
                $validator->errors()->add('state_id', 'Please select the valid State option');
            }
            if($request->paymentbank_id == '0') {
                $validator->errors()->add('paymentbank_id', 'Please select the valid Bank option');
            }
        });

        $this->validateWith($validator);

        $expert = Expert::where('id', $request->expert_id)->first();

        if(!is_null($expert)) {
            $file = $request->file('file_bank_passbook');
            $filename = "PassbookC";
            for($i=strlen($expert->id); $i<4; $i++ ) {
                $filename .= '0';
            }
            $filename .= $expert->id.'.'.$file->getClientOriginalExtension();
            $destination = public_path()."/files/experts/passbook/";
            $file->move($destination, $filename);

            $expert->update([
                "pancard_no" => $request->pancard_no,
                "bank_account_no" => $request->bank_account_no,
                "bank_ifsc_code" => $request->bank_ifsc_code,
                "bank_branch_name" => $request->bank_branch_name,
                "paymentbank_id" => $request->paymentbank_id,
                "state_id" => $request->state_id,
                "file_bank_passbook" => $filename,
                "stages_passed" => "9",
            ]);

            return redirect()->route('/expert/application/stage9message', ["expert_id" => $expert->id]);
        }

        return redirect('/expert/application/new/');

    }

    public function messagestage9($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage9.message', compact('expert'));
        }
    }

    public function checkstage10login(Request $request) {
        $rules = [
            "application_no" => "required | alpha_num",
            "dob" => "required"
        ];

        $messages = [
            "application_no.required" => "Please enter the Application No.",

            "dob.required" => "Please choose the Date of Birth",
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $expert = Expert::where('application_no', $request->application_no)->where('dob', date("Y-m-d", strtotime($request->dob)))->first();

        $validator->after(function ($validator) use($request, $expert) {
            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/expert/application/applystage10', ["expert_id" => $expert->id]);
    }

    public function displaystage10($expert_id){
        $expert = Expert::where('id', $expert_id)->first();

        if(is_null($expert)) {
            return view('expert.newapplication.index');
        }
        else {
            if($expert->stages_passed == '9') {
                return view('expert.newapplication.stage10.form', compact('expert'));
            }
            else if($expert->stages_passed < '9') {
                return redirect()->route('/expert/application/stage'.$expert->stages_passed.'message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect()->route('/expert/application/stage10message', ["expert_id" => $expert->id]);
            }
        }
    }

    public function addstage10(Request $request) {
            $rules = [
                "file_photo" => "required | max: 1024 | mimes:jpeg,bmp,png",
            ];

            $messages = [
                "file_photo.required" => "Please upload the scanned copy of the Photo",
                "file_photo.max" => "The uploaded file should be less than 1 MB",
                "file_photo.mimes" => "The upload file should be in the format of jpeg, png, jpg, pdf only",
            ];

            $validator = Validator($request->all(), $rules, $messages);

            $this->validateWith($validator);

            $expert = Expert::where('id', $request->expert_id)->first();

            if(!is_null($expert)){
                $file = $request->file('file_photo');
                $filename = "photo_";
                for($i=strlen($expert->id); $i<4; $i++ ) {
                    $filename .= '0';
                }
                $filename .= $expert->id.'.'.$file->getClientOriginalExtension();
                $destination = public_path()."/files/experts/photo/";
                $file->move($destination, $filename);

                $expert->update([
                    "file_photo" => $filename,
                    "stages_passed" => "10",
                ]);
                return redirect()->route('/expert/application/stage10message', ["expert_id" => $expert->id]);
            }
            else {
                return redirect('/expert/application/new/');
            }
    }

    public function messagestage10($expert_id) {
        $expert = Expert::find($expert_id);

        if(is_null($expert)) {
            return redirect('/expert/application/new/');
        }
        else {
            return view('expert.newapplication.stage10.message', compact('expert'));
        }
    }
}
