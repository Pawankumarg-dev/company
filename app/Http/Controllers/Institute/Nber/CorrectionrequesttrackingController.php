<?php

namespace App\Http\Controllers\Nber;

use App\Candidate;
use App\Correctionrequest;
use App\Correctionrequestsmsupdate;
use App\Correctionrequestupdate;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CorrectionrequesttrackingController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $correctionrequests = Correctionrequest::orderBy('updated_at', 'desc')->get();
        return view('nber.trackings.index', compact('correctionrequests'));
    }

    public function add() {
        return view('nber.trackings.add');
    }

    public function getcandidatedetails(Request $request) {
        $candidate = Candidate::where("enrolmentno", $request->enrolmentnumber)->first();

        if(is_null($candidate)) {
            $data = 0;
        }
        else {
            $data = [
                "candidate_id" => $candidate->id,
                "candidate_enrolmentno" => $candidate->enrolmentno,
                "candidate_name" => $candidate->name,
                "candidate_fathername" => $candidate->fathername,
                "candidate_dob" => $candidate->dob->format("d-m-Y"),
                "candidate_email" => $candidate->email,
                "candidate_contactnumber" => $candidate->contactnumber,
                "candidate_course" => $candidate->approvedprogramme->programme->course_name,
                "candidate_institutecode" => $candidate->approvedprogramme->institute->code,
                "candidate_institutename" => $candidate->approvedprogramme->institute->name,
            ];
        }

        return response()->json($data);
    }

    public function adddetails(Request $request) {
        $count = Correctionrequest::where("reference_number", "like", "CRN".date('Y')."%")->count();
        $count++;

        $correctionrequest = Correctionrequest::create([
            "reference_number" => "CRN".date('Y').str_pad($count,4,"0",STR_PAD_LEFT),
            "candidate_id" => $request->candidate_id,
            "subject" => $request->subject,
            "status" => "Open",
        ]);

        $correctionrequest->candidate->update([
            "contactnumber" => $request->candidatecontactnumberdata
        ]);

        $api_key = '25FA4F48782DFA';
        $contacts = $correctionrequest->candidate->contactnumber;
        $from = 'CHNBER';
        $template_id= '1207161779628984832';
        $link = file_get_contents('http://tinyurl.com/api-create.php?url='.'http://examcell.niepmdexaminationsnber.com/tracking/correctionrequest/'.$correctionrequest->reference_number);
        $text = "Dear Student, Your correction request received. Click ".$link." to track the Ref. No.".$correctionrequest->reference_number." for future updates.";

        $sms_text = urlencode($text);

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id;

        //Submit to server

        $response = file_get_contents( $api_url);

        Correctionrequestupdate::create([
            "correctionrequest_id" => $correctionrequest->id,
            "update_remarks" => "Received your Correction Request (Ref. No.: ".$correctionrequest->reference_number.")",
            "user_id" => Auth::user()->id
        ]);

        Correctionrequestsmsupdate::create([
            "correctionrequest_id" => $correctionrequest->id,
            "contactnumber" => $contacts,
            "smstemplate_id" => $template_id,
            "sms_content" => $text,
            "response" => $response
        ]);

        return redirect('/nber/tracking/documentcorrection/viewstatus/'.$correctionrequest->id);
    }

    public function viewstatus($cr_id) {
        $correctionrequest = Correctionrequest::find($cr_id);

        $correctionrequestupdates = Correctionrequestupdate::where("correctionrequest_id", $correctionrequest->id)->get();

        return view('nber.trackings.viewstatus', compact('correctionrequest', 'correctionrequestupdates'));
    }

    public function updatedetails(Request $request) {
        Candidate::where("id", $request->candidate_id)->update([
            "name" => trim(strtoupper($request->candidate_name)),
            "fathername" => trim(strtoupper($request->candidate_fathername)),
            "dob" => $request->candidate_dob,
            "contactnumber" => $request->candidate_contactnumber,
            "email" => $request->candidate_email,
        ]);

        return redirect('/nber/tracking/documentcorrection/viewstatus/'.$request->correctionrequest_id);
    }

    public function updatestatus(Request $request) {
        $correctionrequest = Correctionrequest::find($request->correctionrequest_id);

        $correctionrequest->update([
            "updated_at" => date('Y-m-d H:i:s'),
        ]);

        Correctionrequestupdate::create([
            "correctionrequest_id" => $request->correctionrequest_id,
            "update_remarks" => $request->update_remarks,
            "user_id" => Auth::user()->id
        ]);

        $api_key = '25FA4F48782DFA';
        $contacts = $correctionrequest->candidate->contactnumber;
        $from = 'CHNBER';
        $template_id= '1207161805764222165';
        $link = file_get_contents('http://tinyurl.com/api-create.php?url='.'http://examcell.niepmdexaminationsnber.com/tracking/correctionrequest/'.$correctionrequest->reference_number);
        $text = "Dear Student, Your Correction Request (No.".$correctionrequest->reference_number.") status is updated. Click the ".$link." to track the status. Regards, NIEPMD-NBER, Chennai";

        $sms_text = urlencode($text);

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id;

        //Submit to server

        $response = file_get_contents( $api_url);

        Correctionrequestsmsupdate::create([
            "correctionrequest_id" => $correctionrequest->id,
            "contactnumber" => $contacts,
            "smstemplate_id" => $template_id,
            "sms_content" => $text,
            "response" => $response
        ]);

        return redirect('/nber/tracking/documentcorrection/');
    }
}
