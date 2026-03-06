<?php

namespace App\Http\Controllers\Nber;

use App\Candidate;
use App\Correctionquerycandidate;
use App\Paymentbank;
use App\Paymenttype;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CorrectionQueryController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $correctionquerycandidates = Correctionquerycandidate::all();

        return view('nber.correctionqueries.index', compact('correctionquerycandidates'));
    }

    public function select_candidate() {
        return view('nber.correctionqueries.selectcandidate', compact('correctionquerycandidates'));
    }

    public function check_candidate(Request $request) {
        $rules = [

        ];

        $messages = [

        ];

        $validator = Validator($request->all(), $rules, $messages);

        $candidate = Candidate::where('enrolmentno', $request->enrolmentno)->first();

        $validator->after(function ($validator) use ($request, $candidate) {
            if(is_null($candidate)) {
                $validator->errors()->add('enrolmentno', 'Invalid Enrolment Number entered.');
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/nber/correction-query/confirm-candidate/', ["type" => $request->correctionquery_type, "candidate_id" => $candidate->id]);
    }

    public function confirm_candidate($correctionquery_type, $cid) {

        $title = "Correction Query - Confirm Candidate";
        $candidate = Candidate::where('id', $cid)->first();

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('nber.correctionqueries.confirmcandidate', compact('correctionquery_type','title','candidate', 'paymenttypes', 'paymentbanks'));
    }

    public function check_confirm_candidate(Request $request) {
        $candidate = Candidate::find($request->candidate_id)->first();

        $application_count = Correctionquerycandidate::where('application_code', 'like', date("Y")."CQ".date("m").'%')->count() + 1;
        $application_code = date("Y")."CQ".date("m").str_pad($application_count, 3, '0', STR_PAD_LEFT);

        $correctionquerycandidate = Correctionquerycandidate::create([
            'application_code' => $application_code,
            'candidate_id' => $candidate->id,
            'correctionquery_type' => $request->correctionquery_type,
            'payment_required' => $request->payment_required,
            'proofdocument_required' => $request->proofdocument_required,
            'originaldocument_required' => $request->originaldocument_required,
            'created_on' => date('Y-m-d'),
            'created_by' => Auth::user()->id,
        ]);

        if($request->has('namecorrection_status')) {
            $correctionquerycandidate->update([
                'namecorrection_status' => '1',
                'namecorrection_value' => $request->namecorrection_value,
            ]);
        }
        else {
            $correctionquerycandidate->update([
                'namecorrection_status' => '1',
                'namecorrection_value' => '',
            ]);
        }

        if($request->has('fathernamecorrection_status')) {
            $correctionquerycandidate->update([
                'fathernamecorrection_status' => '1',
                'fathernamecorrection_value' => $request->fathernamecorrection_value,
            ]);
        }
        else {
            $correctionquerycandidate->update([
                'fathernamecorrection_status' => '0',
                'fathernamecorrection_value' => '',
            ]);
        }

        if($request->has('dobcorrection_status')) {
            $correctionquerycandidate->update([
                'dobcorrection_status' => '1',
                'dobcorrection_value' => $request->dobcorrection_value,
            ]);
        }
        else {
            $correctionquerycandidate->update([
                'dobcorrection_status' => '0',
                'dobcorrection_value' => '',
            ]);
        }

        return redirect()->route('/correction-query/show-correction-page/', ["code" => $correctionquerycandidate->application_code]);
    }

    public function showCorrectionPage($application_code) {
        $title = "Correction Query - Candidate Page";
        $correctionquerycandidate = Correctionquerycandidate::where('application_code', $application_code)->first();

        return view('nber.correctionqueries.correction_page', compact('title', 'correctionquerycandidate'));
    }

    public function add_new_form($cid) {
        $title = "Correction Query - Confirm Candidate";
        $candidate = Candidate::find($cid);

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('nber.correctionqueries.addnewform', compact( 'title','candidate', 'paymenttypes', 'paymentbanks'));
    }


}
