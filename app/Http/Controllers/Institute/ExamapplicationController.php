<?php

namespace App\Http\Controllers\Institute;

use App\Exam;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExamapplicationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function showcandidates($e_id, $ap_id) {
        $exam = Exam::find($e_id);
    }
}
