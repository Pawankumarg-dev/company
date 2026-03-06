<?php

namespace App\Http\Controllers\Evaluation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Services\Common\HelperService;

use PDF;

class EvaluationtrackingController extends Controller
{
    private $helperService;
    private $evaluationcenter_id;

    public function __construct(HelperService $helper)
    {
        $this->middleware(['role:evaluationcenter']);
        $this->helperService = $helper;
        $this->evaluationcenter_id = $this->helperService->getEvaluationcenterID();
    }

    public function index(){
        $exampapers = \App\Exampaper::where('evaluationcenter_id',$this->evaluationcenter_id)->get();
        return view('evaluationcenters.evaluationtracking.index',compact(
            'exampapers'
        ));
    }
}