<?php

namespace App\Http\Controllers\Expertpool;

use App\City;
use App\Expert;
use App\Gender;
use App\Relationtype;
use App\Salutation;
use App\State;
use Illuminate\Http\Request;

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
        if($stage_id == '2') {
            $cities = City::all();
            return view('expertpool.newapplication.stage2application', compact('cities'));
        }
        if($stage_id == '3') {
            $states = State::orderBy('state_name')->get();
            return view('expertpool.newapplication.stage3application', compact('states'));
        }
        if($stage_id == '4') {
            $states = State::orderBy('state_name')->get();
            return view('expertpool.newapplication.stage4application', compact('states'));
        }
        if($stage_id == '5') {
            $states = State::orderBy('state_name')->get();
            return view('expertpool.newapplication.stage5application', compact('states'));
        }
    }

    public function checkstage1(Request $request) {
        $rules = [
            'title' => 'required',
            'name' => 'required | alpha',
            'relationtype_id' => 'required',
            'relation_name' => 'required | alpha',
            'dob' => 'required',
            'gender_id' => 'required',
            'has_disability' => 'required',
            'contactnumber1' => 'required | numeric',
            'contactnumber2' => 'present | numeric',
            'email' => 'required',
            'aadhaarcard_no' => 'required | numeric',
            'password' => 'required | min: 8 | confirmed',
            'password_confirmation' => 'min: 8 |',
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

            //password
            'password.required' => 'Please enter the Password',
            'password.min' => 'Password should be a length of minimum 8 characters',

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
            "password" => $request->password,
            "stages_passed" => "1",
        ]);

        $application_no = 'EXPAPP'.date_format($expert->created_at, "Y")."C";

        for($i=strlen($expert->id); $i<4; $i++ ) {
            $application_no .= '0';
        }

        $expert->update([
            "application_no" => $application_no.$expert->id,
        ]);
    }

}


