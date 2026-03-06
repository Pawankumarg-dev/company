<?php

namespace App\Http\Controllers\Institute;

use App\Academicyear;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Exammarksheetdetail;
use App\Http\Controllers\Auth\AuthController;
use App\Institute;
use App\Provisionalcertificate;
use App\Withheld;
use Auth;
use PDF;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CertificationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        return view('institute.certifications.index');
    }

    public function showprovisionalpage() {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $provisionalcertificates = Provisionalcertificate::select('provisionalcertificates.*')
            ->join('candidates', 'candidates.id', '=', 'provisionalcertificates.candidate_id')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('approvedprogrammes.institute_id', $institute->id)
            ->where('provisionalcertificates.publish_status', 1)
            ->orderBy('academicyears.year')
            ->orderBy('programmes.sortorder')
            ->orderBy('candidates.enrolmentno')
            ->get();

        return view('institute.certifications.provisionalcertificates.index', compact('institute', 'provisionalcertificates'));
    }

    public function downloadprovisional($cand_id) {
        $provisionalCertificate = Provisionalcertificate::where('candidate_id', $cand_id)->first();

        return view('institute.certifications.provisionalcertificates.download', compact('provisionalCertificate'));
    }

    public function showmarksheetspage() {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('approvedprogrammes.institute_id', $institute->id)
            ->orderBy('academicyears.year')
            ->orderBy('programmes.sortorder')
            ->get();

        $exammarksheetdetails = Exammarksheetdetail::select('exammarksheetdetails.*')
            ->join('exams', 'exams.id', '=', 'exammarksheetdetails.exam_id')
            ->join('programmes', 'programmes.id', '=', 'exammarksheetdetails.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'exammarksheetdetails.academicyear_id')
            ->get();

        $exams = Exam::whereIn('id', $exammarksheetdetails->unique('exam_id')->pluck('exam_id')->toArray())
            ->orderBy('date')->get();

        return view('institute.certifications.marksheets.index', compact('approvedprogrammes','exammarksheetdetails','exams'));
    }

    public function showmarksheetcandidateslist($eid, $apid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        if($institute->id )
        $exam = Exam::find($eid);
        $approvedprogramme = Approvedprogramme::find($apid);

        $withheldcandidate_ids = Withheld::where('exam_id', $exam->id)->where('status', '1')->pluck('candidate_id')->toArray();


    }
}
