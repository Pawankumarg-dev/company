<?php

namespace App\Http\Controllers\Certification;

use App\Candidate;
use App\Provisionalcertificate;
use App\Withheld;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CertificationController extends Controller
{
    //

    public function index() {
        return view('certification.provisionalcertificate.index');
    }

    public function checkcredentials(Request $request)
    {
        $rules = [
            'enrolmentno' => 'required|numeric|exists:candidates,enrolmentno',
            'dob' => 'required'
        ];

        $messages = [
            'enrolmentno.required' => 'Enrolment Number is required',
            'enrolmentno.numeric' => 'Invalid Enrolment Number is entered',
            'enrolmentno.exists' => 'Enrolment Number does not exists',
            'dob.required' => 'Date of Birth is required'
        ];

        $validator = validator($request->all(), $rules, $messages);

        $c = Candidate::where('enrolmentno', $request->enrolmentno)->first();

        $validator->after(function ($validator) use ($request, $c) {
            if ($c) {
                $withheld = Withheld::where('candidate_id', $c->id)->where('exam_id', '7')->where('status', '1')->first();

                if($withheld) {
                    $validator->errors()->add('enrolmentno', 'Sorry you are not allowed to download the Provisional Certificate');
                }
                else {
                    $provisional = Provisionalcertificate::where('candidate_id', $c->id)->where("publish_status", 1)->first();
                    if (($c->dob->format('Y-m-d') != $request->dob)) {
                        $validator->errors()->add('enrolmentno', 'Invalid Login Details');
                    }
                    elseif (is_null($provisional)) {
                        $validator->errors()->add('enrolmentno', 'Sorry you are not allowed to download the Provisional Certificate');
                    }
                }
            }

        });

        $this->validateWith($validator);

        $provisional = Provisionalcertificate::where('candidate_id', $c->id)->first();

        return redirect('/online-provisional-certificate/' . $c->id . '/' . $provisional->folio_number);
    }

    /*
    public function downloadprovisional($cand_id, $folio_number) {
        $provisionalCertificate = Provisionalcertificate::where('candidate_id', $cand_id)
            ->where('folio_number', $folio_number)
            ->first();


        if(!is_null($provisionalCertificate)) {
            return view('certification.provisionalcertificate.download', compact('provisionalCertificate'));
        }
    }
    */

    public function download($cand_id, $folio_number) {
        $provisionalCertificate = Provisionalcertificate::where('candidate_id', $cand_id)
            ->where('folio_number', $folio_number)
            ->first();


        if(!is_null($provisionalCertificate)) {
            return view('certification.provisionalcertificate.download', compact('provisionalCertificate'));
        }
    }
}
