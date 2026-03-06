<?php

namespace App\Http\Controllers\Tracking;

use App\Application;
use App\Candidate;
use App\Correctionrequest;
use App\Correctionrequestupdate;
use App\Examresultdate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CorrectionrequestController extends Controller
{
    //
    public function index() {
        $title = "Online Correction Request Tracking";
        return view("tracking.correctionrequest.index", compact('title'));
    }

    public function checkdetails(Request $request) {
        $rules = [
            'reference_number' => 'required|exists:correctionrequests,reference_number'
        ];

        $messages = [
            'reference_number.required' => 'Please enter the Correction Request Ref. No.',
            'reference_number.exists' => 'Please enter the valid Correction Request Ref. No.'
        ];

        $validator = validator($request->all(), $rules, $messages);

        $this->validateWith($validator);

        $correctionrequest = Correctionrequest::where("reference_number", $request->reference_number)->first();

        return redirect('/tracking/correctionrequest/'.$correctionrequest->reference_number);
    }

    public function showdetails($ref_no) {
        $title = $ref_no." - Online Correction Request Tracking";

        $correctionrequest = Correctionrequest::where("reference_number", $ref_no)->first();

        $correctionrequestupdates = Correctionrequestupdate::where("correctionrequest_id", $correctionrequest->id)->get();

        return view('tracking.correctionrequest.showdetails', compact('title','correctionrequest', 'correctionrequestupdates'));
    }
}
