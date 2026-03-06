<?php

namespace App\Http\Controllers\Nber;

use App\Candidate;
use App\Provisionalcertificate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class ProvisionalCertificateController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $title = 'Provisional Certificate';

        $provisionalCertifcates = Provisionalcertificate::orderBy('folio_number')->get();

        return view('nber.provisionalcertificate.index', compact('title', 'provisionalCertifcates'));
    }

    public function addCandidate(Request $request) {
        $rules = [

        ];

        $messages = [

        ];

        $validator = Validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            $candidate = Candidate::where('enrolmentno', $request->enrolmentno)->first();

            if(is_null($candidate)) {
                $validator->errors()->add('enrolmentno', 'Please enter the valid enrolmentno');
            }
            else {
                if(Provisionalcertificate::where('candidate_id', $candidate->id)->count() == '0') {
                    $validator->errors()->add('enrolmentno', 'The candidate has already applied for Provisional Certificate');
                }
            }
        });

        $this->validateWith($validator);

        return $this->index();

    }

    public function download($id) {
        $provisionalCertificate = Provisionalcertificate::where('id', $id)->first();

        return view('nber.provisionalcertificate.download', compact('title', 'provisionalCertificate'));
    }
}
