<?php

namespace App\Http\Controllers\Nber;

use App\Exam;
use App\Incidentalpayment;
use App\Reevaluation;
use App\Reevaluationapplication;
use App\Reevaluationapplicationfee;
use App\Reevaluationapplicationpayment;
use App\Status;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReevaluationPaymentController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $reevaluations = Reevaluation::orderBy('id', 'desc')->get();
        return view('nber.reevaluationpayments.index', compact('reevaluations'));
    }

    public function showApplications($eid) {
        $reevaluation = Reevaluation::where('exam_id', $eid)->first();

        if($reevaluation) {
            $reevaluationapplications = Reevaluationapplication::where('reevaluation_id', $reevaluation->id)->orderBy('application_number')->get();

            return view('nber.reevaluationpayments.show_applications', compact('reevaluation', 'reevaluationapplications'));
        }
        else {
            return redirect('/nber/payments/reevaluation');
        }
    }

    public function showReevaluationApplication($eid, $rappid) {
        $reevaluation = Reevaluation::where('exam_id', $eid)->first();

        if($reevaluation) {
            $reevaluationapplication = Reevaluationapplication::find($rappid);

            $reevaluationapplicationfee = Reevaluationapplicationfee::where('exam_id', $reevaluation->exam_id)->first();

            return view('nber.reevaluationpayments.show_reevaluation_application', compact('reevaluation', 'reevaluationapplication', 'reevaluationapplicationfee'));
        }
        else {
            return redirect('/nber/payments/reevaluation');
        }
    }

    public function updatestatus(Request $request) {
        $reevaluationpayment = Reevaluationapplicationpayment::find($request->reevaluationpayment_id);

        if(!is_null($reevaluationpayment)) {
            $reevaluationpayment->update([
                "user_id" => $request->user_id,
                "status_id" => $request->status_id,
                "verify_remarks" => $request->verify_remarks,
                "verified_on" => date_format(date_create_from_format("d-m-Y", $request->verified_on), "Y-m-d"),
            ]);

            unset($reevaluationpayment);

            $data = Status::find($request->status_id)->status;
        }

        return response()->json($data);
    }
}
