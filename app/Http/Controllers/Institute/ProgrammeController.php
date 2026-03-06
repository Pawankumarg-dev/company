<?php

namespace App\Http\Controllers\Institute;

use App\Academicyear;
use App\Approvedprogramme;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Programme;
use Validator;
use App\Http\Controllers\Controller;
use App\Institute;
use Auth;

class ProgrammeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index()
    {
        $programmes = Programme::all();
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        //$approvedprogrammes = Approvedprogramme::where('')

        $approvedprogrammes = $institute->approvedprogrammes;
        return view('institute.programmes',compact('programmes','institute','approvedprogrammes'));
    }

    /*
     public function index()
    {
        $programmes = Programme::all();
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $academicyears = Academicyear::orderBy('year', 'desc')->get();

        $currentyear = Academicyear::where('year', '2018')->first();

        $ap = Approvedprogramme::where('institute_id', $institute->id)->where('academicyear_id', $currentyear->id)->get();

        if($ap->count() == '0') {
            $programmelist = Programme::where('active_status', '1')->get();
        }
        else {
            $ap_ids = $ap->pluck('programme_id')->toArray();
            $programmelist = Programme::where('active_status', '1')->whereNotIn('id', $ap_ids)->get();
        }

        $approvedprogrammes = $institute->approvedprogrammes;

        return view('institute.programmes',compact('programmes','institute','approvedprogrammes', 'academicyears', 'programmelist'));

    }
     */

}
