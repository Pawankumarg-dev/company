<?php

namespace App\Http\Controllers\Nber\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Services\Common\HelperService;

use PDF;

class EvaluationtrackingController extends Controller
{
    private $helperService;
    private $nber_id;

    public function __construct(HelperService $helper)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $helper;
        $this->nber_id = $this->helperService->getNberID();
    }

    public function index(){
        $exampapers = \App\Exampaper::whereHas('programme',function($q){
            $q->where('nber_id',$this->nber_id);
        })->get();
        return view('nber.exam.evaluationtracking.index',compact(
            'exampapers'
        ));
    }
}