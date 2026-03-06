<?php

namespace App\Http\Controllers\Expert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Expert;

class PrintApplicationController extends Controller
{
    //
    public function index() {
        return view('expert.printapplication.login');
    }

    public function checklogin(Request $request) {
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
            if(is_null($expert))

            if($request->application_no != "" && $request->dob != "") {
                if(is_null($expert)) {
                    $validator->errors()->add('application_no', 'Invalid Credentials entered');
                }
            }
            if($expert->stages_passed != "10") {
                $validator->errors()->add('application_no', 'Please complete all the stages');
            }
        });

        $this->validateWith($validator);

        //return redirect()->route('/expert/application/print', ["expert_id" => $expert->id]);
    }

    public function printapplication($expert_id) {
        $expert = Expert::where('id', $expert_id)->first();

        if($expert->stages_passed == "10") {
            return view('expert.printapplication.print', compact('expert'));
        }
        else {
            echo 'Hi';
        }
    }
}
