<?php

namespace App\Http\Controllers\Nber;

use App\Baslpcandidate;
use App\Baslpexam;
use App\Baslpexamcenter;
use App\Baslpexamcenterdetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaslpController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('baslp');
    }

    public function index() {
        $exams = Baslpexam::orderBy('date', 'desc')->get();

        return view('nber.baslpexam.index', compact('exams'));
    }

    public function show_candidates_list($e_id, $exc_id) {
        $exam = Baslpexam::where('id', $e_id)->first();

       //$examcenterdetails = Baslpexamcenterdetail::where('baslpexam_id', $exam->id)->get();

       $examcenterdetails = Baslpexamcenterdetail::select('baslpexamcenterdetails.*')
           ->join('baslpexams', 'baslpexams.id', '=', 'baslpexamcenterdetails.baslpexam_id')
           ->join('baslpcandidates', 'baslpcandidates.id', '=', 'baslpexamcenterdetails.baslpcandidate_id')
           ->join('baslpexamcenters', 'baslpexamcenters.id', '=', 'baslpexamcenterdetails.baslpexamcenter_id')
           ->orderBy('baslpcandidates.roll_no')
           ->orderBy('baslpexamcenters.sortorder')
           ->where('baslpexam_id', $exam->id)->where('baslpexamcenter_id', $exc_id)->get();

        return view('nber.baslpexam.showcandidatelist', compact('exam', 'examcenterdetails'));
    }

    public function show_examcenters_list($e_id) {
        $exam = Baslpexam::where('id', $e_id)->first();

        $examcenterdetails = Baslpexamcenterdetail::where('baslpexam_id', $exam->id)->groupBy('baslpexamcenter_id')->get();

        return view('nber.baslpexam.showexamcenterlist', compact('exam', 'examcenterdetails'));
    }

    public function download_candidate_hallticket($exd_id) {
        $examcenterdetail = Baslpexamcenterdetail::where('id', $exd_id)->first();

        return view('nber.baslpexam.downloadhallticket', compact('examcenterdetail'));
    }
}
