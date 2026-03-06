<?php

namespace App\Http\Controllers\Nber;

use App\Academicyear;
use App\Approvedprogramme;
use App\Incidentalfee;
use App\Incidentalpayment;
use App\Institute;
use App\Programme;
use App\Status;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class IncidentalchargePaymentController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $incidentalfee_year = Incidentalfee::distinct('academicyear_id')->pluck('academicyear_id')->toArray();

        $title = 'Affiliation fee Payment';
        $academicyears = Academicyear::whereIn('id', $incidentalfee_year)->orderBy('year', 'desc')->get();

        return view('nber.incidentalchargepayments.index', compact('academicyears', 'title'));
    }

    public function showinstitutes($ayid) {
        $academicyear = Academicyear::find($ayid);

        $incidentalfee_ids = Incidentalfee::where('academicyear_id', $ayid)->pluck('id')->toArray();

        $incidentalpayments = Incidentalpayment::whereIn('incidentalfee_id', $incidentalfee_ids)
            ->groupBy('institute_id')->get(['institute_id']);

        /*
        $institute_ids = Incidentalpayment::whereIn('incidentalfee_id', $incidentalfee_ids)
            ->groupBy('institute_id')->pluck('institute_id')->toArray();

        $institutes = Institute::whereIn('id', $institute_ids)->orderBy('code')->get(['id', 'code', 'name']);
        */

        unset($incidentalfee_ids);
        //unset($institute_ids);

        return view('nber.incidentalchargepayments.showinstitutes', compact('academicyear', 'incidentalpayments'));
    }

    public function oldshowinstitutes($ay_id) {
        $academicyear = Academicyear::find($ay_id);

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")->where("academicyear_id", $academicyear->id)
            ->join("candidates", "candidates.approvedprogramme_id", "=", "approvedprogrammes.id")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->whereNotNull("candidates.enrolmentno")
            ->orderBy("institutes.code")
            ->groupBy("approvedprogrammes.id")->get(["approvedprogrammes.id"]);

        return view('nber.incidentalchargepayments.showinstitutes', compact('academicyear', 'approvedprogrammes'));
    }

    public function showinstitutepayments($ayid, $instid) {
        $academicyear = Academicyear::find($ayid);
        $institute = Institute::find($instid);

        $user = User::find(Auth::user()->id);

        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('approvedprogrammes.academicyear_id', $academicyear->id)
            ->where('approvedprogrammes.institute_id', $institute->id)
            ->where('approvedprogrammes.status_id', 2)
            ->orderBy('programmes.sortorder')->get();

        $programme_ids = $approvedprogrammes->pluck('programme_id')->toArray();

        $incidentalfees = Incidentalfee::where('academicyear_id', $academicyear->id)->whereIn('programme_id', $programme_ids)->get();

        $incidentalfee_ids = Incidentalfee::where('academicyear_id', $ayid)->pluck('id')->toArray();

        $incidentalpayments = Incidentalpayment::where('institute_id', $instid)->whereIn('incidentalfee_id', $incidentalfee_ids)
            ->get();

        return view('nber.incidentalchargepayments.showinstitutepayments', compact('academicyear', 'institute', 'approvedprogrammes', 'incidentalpayments', 'user', 'incidentalfees'));
    }

    public function showpaymentdetails($ay_id, $ap_id, $term) {
        $approvedprogramme = Approvedprogramme::find($ap_id);
        $incidentalfee = Incidentalfee::where("programme_id", $approvedprogramme->programme_id)->where("academicyear_id", $approvedprogramme->academicyear_id)
            ->where("term", $term)->first();

        $incidentalpayments = Incidentalpayment::where("approvedprogramme_id", $approvedprogramme->id)->where("incidentalfee_id", $incidentalfee->id)->get();

        return view('nber.incidentalchargepayments.showpaymentdetails', compact('approvedprogramme', 'incidentalfee', 'incidentalpayments'));
    }

    public function updatestatus(Request $request) {
        $incidentalpayment = Incidentalpayment::find($request->incidentalpayment_id);

        if(!is_null($incidentalpayment)) {
            $incidentalpayment->update([
                "user_id" => $request->user_id,
                "status_id" => $request->status_id,
                "verify_remarks" => $request->verify_remarks,
                "verified_on" => date_format(date_create_from_format("d-m-Y", $request->verified_on), "Y-m-d"),
            ]);

            unset($incidentalpayment);

            $data = Status::find($request->status_id)->status;
        }

        return response()->json($data);
    }

    public function oldupdatestatus(Request $request) {
        $incidentalpayment = Incidentalpayment::find($request->incidentalpayment_id);

        if(!is_null($incidentalpayment)) {
            $incidentalpayment->update([
                "user_id" => Auth::user()->id,
                "status_id" => $request->status_id,
                "verify_remarks" => $request->verify_remarks,
                "verified_on" => date_format(date_create_from_format("d-m-Y", $request->verified_on), "Y-m-d"),
            ]);

            unset($incidentalpayment);

            $data = Status::find($request->status_id)->status;
        }

        return response()->json($data);
    }

    public function viewreceipt($ref_num) {
        $incidentalpayments = Incidentalpayment::where('reference_number', $ref_num)->get();
        $common = $incidentalpayments->where('reference_number', $ref_num)->first();

        $institute = Institute::where('id', $common->approvedprogramme->institute_id)->first();

        return view('nber.incidentalchargepayments.viewreceipt', compact('institute', 'incidentalpayments', 'common'));
    }

    public static function checknoofpaymententries($ayid, $iid) {
        $incidentalfee_ids = Incidentalfee::where('academicyear_id', $ayid)->pluck('id')->toArray();

        $count = Incidentalpayment::where('institute_id', $iid)->whereIn('incidentalfee_id', $incidentalfee_ids)->count();

        echo $count;
    }

    public static function checknoofverificationpending($ayid, $iid) {
        $incidentalfee_ids = Incidentalfee::where('academicyear_id', $ayid)->pluck('id')->toArray();

        $count = Incidentalpayment::where('institute_id', $iid)->whereIn('incidentalfee_id', $incidentalfee_ids)->where('status_id', 6)->count();

        if($count == 0)
            echo "<span class='label label-sucess'>".$count."</span>";
        else
            echo "<span class='label label-danger'>".$count."</span>";
    }

    public function viewInstitutes($ayId) {
        $academicyear = Academicyear::find($ayId);

        if($academicyear) {
            $approvedprogrammes = Approvedprogramme::with('institute', 'programme')
                ->where('approvedprogrammes.academicyear_id', $ayId)
                ->where('approvedprogrammes.status_id', 2)
                ->get(['approvedprogrammes.id', 'approvedprogrammes.institute_id', 'approvedprogrammes.programme_id'])
                ->sortBy('programme.abbreviation')->sortBy('institute.code');


            return view('nber.incidentalchargepayments.view_institutes', compact('academicyear', 'approvedprogrammes'));
        }
        else {
            return redirect('/nber/payments/incidentalcharge');
        }
    }
}
