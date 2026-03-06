<?php

namespace App\Http\Controllers\Nber;

use App\Candidate;
use App\Exam;
use App\Http\Controllers\Auth\AuthController;
use App\Academicyear;
use App\Approvedprogramme;
use App\Enrolmentfee;
use App\Enrolmentpayment;
use App\Institute;
use App\Paymentstatus;
use App\Status;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class EnrolmentPaymentController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index() {
        $academicyear_ids = Enrolmentfee::groupBy('academicyear_id')->pluck('academicyear_id')->toArray();
        $academicyears = Academicyear::whereIn('id', $academicyear_ids)->get();

        return view('nber.enrolmentpayments.index', compact('academicyears'));
    }

    public function display($ay_id) {
        $enrolmentfees = Enrolmentfee::where('academicyear_id', $ay_id)->get();
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->unique()->toArray();
        $year = Academicyear::where('id', $ay_id)->first()->year;

        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->groupBy('reference_number')
            ->orderBy('reference_number')->get();

        return view('nber.enrolmentpayments.view', compact('enrolmentpayments', 'year'));
    }

    public static function totalamount($reference_number) {
        $amount = 0;

        $enrolmentpayments = Enrolmentpayment::where('reference_number', $reference_number)->get();

        foreach ($enrolmentpayments as $ep) {
            $amount += $ep->enrolmentfee->enrolment_fee;

            if($ep->latefee_remark == 'Yes') {
                $amount += $ep->enrolmentfee->late_fee;
            }
        }

        return $amount;
    }

    public function showInstituteLists($ay_id) {
        $academicyear = Academicyear::find($ay_id);

        $institute_ids = Enrolmentpayment::whereHas('enrolmentfee', function($query) use($ay_id){
                   $query->where('academicyear_id', $ay_id);
                })
            ->groupBy('institute_id')->pluck('institute_id')->toArray();

        $institutes = Institute::select(array('id', 'code', 'name'))->whereIn('id', $institute_ids)->orderBy('code')->get();

        return view('nber.enrolmentpayments.showInstituteLists', compact('academicyear', 'institutes'));
    }

    public function showPaymentDetails($ay_id, $inst_id) {
        $academicyear = Academicyear::find($ay_id);

        $institute = Institute::where('id', $inst_id)->select(array('id', 'code', 'name'))->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $inst_id)->where('academicyear_id', $ay_id)
            ->with('programme')->get()->sortBy('programme.sortorder');

        $enrolmentpayments = Enrolmentpayment::where('institute_id', $inst_id)->whereHas('enrolmentfee', function ($query) use($ay_id) {
            $query->where('academicyear_id', $ay_id);
        })->groupBy('reference_number')->get();

        return view('nber.enrolmentpayments.showPaymentDetails', compact('academicyear', 'institute', 'approvedprogrammes', 'enrolmentpayments'));
    }

    public function updateStatus(Request $request) {
        $enrolmentpayment = Enrolmentpayment::where('reference_number', $request->reference_number)->first();

        $status = null;
        $enrolmentno = null;

        if(!is_null($enrolmentpayment)) {
            $enrolmentpayment->update([
                "user_id" => Auth::user()->id,
                "status_id" => $request->status_id,
                "verify_remarks" => $request->verify_remarks,
                "verified_on" => date_format(date_create_from_format("d-m-Y", $request->verified_on), "Y-m-d"),
            ]);

            $status = Status::find($request->status_id)->status;

            $paymentstatusid = Paymentstatus::where('status', $status)->first()->id;

            $enrolmentpayment->candidate->update(["paymentstatus_id" => $paymentstatusid]);

            if($status == "Approved") {
                $enrolmentno = $this->generateenrolmentno($enrolmentpayment->candidate_id);
            }

            unset($enrolmentpayment);
        }

        $response = [
            "status" => $status,
            "enrolmentno" => $enrolmentno
        ];

        return response()->json($response);
    }

    public function generateenrolmentno($cid) {
        $returndata = "";
        $candidate = Candidate::find($cid);

        if(!is_null($candidate)) {
            if(is_null($candidate->enrolmentno) || trim($candidate->enrolmentno) == "") {
                for($i=1; $i<=35;$i++) {
                    $enrolmentno = $candidate->approvedprogramme->programme->enrolmentcode.$candidate->approvedprogramme->academicyear->enrolmentcode . str_pad($candidate->approvedprogramme->institute->enrolmentcode,3,'0',STR_PAD_LEFT). str_pad($i,2,'0',STR_PAD_LEFT);

                    if(Candidate::where('enrolmentno', $enrolmentno)->count() == 0) {
                        $candidate->update(['enrolmentno' => $enrolmentno]);
                        $returndata = $enrolmentno;
                        $candidate->approvedprogramme->update([
                            'enrolment_count' => $candidate->approvedprogramme->enrolment_count + 1,
                        ]);

                        $candidateApprovalStatuses = Candidate::where('approvedprogramme_id', $candidate->approvedprogramme_id)->get(['enrolmentno', 'status_id']);
                        $enrolmentCount = Candidate::where('approvedprogramme_id', $candidate->approvedprogramme_id)->whereNotNull('enrolmentno')->count();

                        $candidate->approvedprogramme->update([
                            "registered_count" => $candidateApprovalStatuses->count(),
                            "enrolment_count" => $enrolmentCount,
                            "verificationpending_count" => $candidateApprovalStatuses->where('status_id', 6)->count(),
                            "approved_count" => $candidateApprovalStatuses->where('status_id', 2)->count(),
                            "pending_count" => $candidateApprovalStatuses->where('status_id', 1)->count(),
                            "rejected_count" => $candidateApprovalStatuses->where('status_id', 3)->count(),
                        ]);
                        break;
                    }
                }
            }
        }

        return $returndata;
    }

    public function viewReceipt($reference_number) {
        $enrolmentpayments = Enrolmentpayment::where('reference_number', $reference_number)->get();
        $common = $enrolmentpayments->where('reference_number', $reference_number)->first();

        $institute = Institute::where('id', $common->institute_id)->first();

        return view('nber.enrolmentpayments.viewReceipt', compact('institute', 'enrolmentpayments', 'common'));
    }

    public function showcourselists($ayid, $instid) {
        $academicyear = Academicyear::find($ayid);

        if(!is_null($academicyear)) {
            $institute = Institute::find($instid);

            if(!is_null($institute)) {
                $approvedprogrammes = Approvedprogramme::where("academicyear_id", $academicyear->id)->where("institute_id", $institute->id)
                    ->where("status_id", 2)->get();

                return view('nber.enrolmentpayments.showcourselists', compact('academicyear', 'institute', 'approvedprogrammes'));
            }
            else {
                return redirect('/nber/payments/enrolment/'.$ayid);
            }
        }
        else {
            return redirect('/nber/payments/enrolment');
        }
    }

    public function showstudentlists($ayid, $apid) {
        $academicyear = Academicyear::find($ayid);

        if(!is_null($academicyear)) {
            $approvedprogramme = Approvedprogramme::find($apid);

            if(!is_null($approvedprogramme)) {
                return view('nber.enrolmentpayments.showstudentlists', compact('academicyear', 'approvedprogramme'));
            }
            else {
                return redirect('/nber/payments/enrolment/'.$ayid);
            }
        }
        else {
            return redirect('/nber/payments/enrolment');
        }
    }

    public function viewstudentpaymentdetails($cid) {
        $candidate = Candidate::find($cid);

        $enrolmentpayments = Enrolmentpayment::where("candidate_id", $candidate->id)->get();
        return view('nber.enrolmentpayments.viewstudentpaymentdetails', compact('candidate', 'enrolmentpayments'));

    }

    public function downloadreceipt($enpid) {
        $enrolmentpayment = Enrolmentpayment::find($enpid);
        $institute = $enrolmentpayment->candidate->approvedprogramme->institute;

        return view('nber.enrolmentpayments.downloadreceipt', compact('institute', 'enrolmentpayment'));
    }
}
