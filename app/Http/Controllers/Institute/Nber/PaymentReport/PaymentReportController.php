<?php

namespace App\Http\Controllers\Nber\PaymentReport;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use Maatwebsite\Excel\Facades\Excel;


use Session;

class PaymentReportController extends Controller
{

    private $helperService;

    public function __construct(HelperService $helpder)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $helpder;
    }

    public function index(Request $r){
        if($r->has('type')){
            $nber_id = $this->helperService->getNberID();
            if($r->type=='enrolment'){
                $fees = \App\Enrolmentfeepayment::where('academicyear_id',11)
                ->where('nber_id',$nber_id)
                ->get();
                Excel::create('enrolment', function ($excel) use($fees){
                    $excel->sheet('attendance', function ($sheet) use($fees){
                        $sheet->loadview('nber.paymentreports.enrolment',[
                            'fees' => $fees
                        ]);
                    });
                })->export('xls');
            }
            if($r->type=='exam'){
                $fees = \App\Supplimentaryapplicant::whereHas('programme',function($q) use($nber_id){
                    $q->where('nber_id',$nber_id);
                })->get();
                Excel::create('examfee', function ($excel) use($fees){
                    $excel->sheet('examfee', function ($sheet) use($fees){
                        $sheet->loadview('nber.paymentreports.exam',[
                            'fees' => $fees
                        ]);
                    });
                })->export('xls');
            }
            if($r->type=='reevaluation'){
                $fees = \App\Reevaluationapplication::where('exam_id',22)->whereHas('approvedprogramme',function($q) use($nber_id){
                    $q->whereHas('programme',function($prg) use($nber_id){
                        $prg->where('nber_id',$nber_id);
                    });
                })->get();
                Excel::create('reevaluation', function ($excel) use($fees){
                    $excel->sheet('reevaluation', function ($sheet) use($fees){
                        $sheet->loadview('nber.paymentreports.reevaluation',[
                            'fees' => $fees
                        ]);
                    });
                })->export('xls');
            }
            

        }
        return back();
    }

}
