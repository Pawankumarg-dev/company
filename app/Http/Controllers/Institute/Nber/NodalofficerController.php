<?php

namespace App\Http\Controllers\Nber;

use App\Exam;
use App\Nodalofficer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NodalofficerController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        $nodalofficers = Nodalofficer::where("exam_id", $exam->id)->get();

        return view('nber.theoryexams.nodalofficers.index', compact('exam', 'nodalofficers'));
    }
}
