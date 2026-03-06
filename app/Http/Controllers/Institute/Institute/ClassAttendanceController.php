<?php

namespace App\Http\Controllers\Institute;

use App\Approvedprogramme;
use App\Candidate;
use App\Classattendance;
use App\Classattendancepercentage;
use App\Exam;
use App\Institute;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClassAttendanceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $approvedprogrammes = $institute->approvedprogrammes;

        $exams = Exam::where('status_id', '1')->orderBy('date', 'desc')->get();

        $classattendancepercentages = Classattendancepercentage::where('active_status', '1')->get();
        $classattendancepercentage_ids = $classattendancepercentages->pluck('id')->toArray();

        $classattendances = Classattendance::whereIn('classattendancepercentage_id', $classattendancepercentage_ids)->get();

        return view('institute.classattendances.index', compact('institute', 'exams', 'approvedprogrammes', 'classattendancepercentages', 'classattendances'));

    }

    public function add_class_attendance($ap_id, $term_no) {
        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        if(!is_null($approvedprogramme)) {
            $institute = Institute::where('user_id', Auth::user()->id)->first();

            if($institute->id == $approvedprogramme->institute->id) {
                $candidates = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->whereNotNull('enrolmentno')->get();

                $classattendancepercentage = Classattendancepercentage::where('programme_id', $approvedprogramme->programme_id)->where('academicyear_id', $approvedprogramme->academicyear_id)->first();
                $classattendances = Classattendance::where('classattendancepercentage_id', $classattendancepercentage->id)->where('active_status', '1')->get();

                return view('institute.classattendances.addform', compact('term_no', 'approvedprogramme', 'candidates', 'classattendancepercentage', 'classattendances'));
            }
            else {
                return redirect('/logout');
            }
        }
        else {
            return redirect('/logout');
        }
    }

    public function update_class_attendance(Request $request) {



    }
}
