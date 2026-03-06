<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Evaluationcenterdetail;
use App\Evaluationcenter;
use DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\Common\HelperService;
use App\Services\Evaluation\EvaluationService;

use App\Services\Exam\ExamService;

use Session;

class EvaluationcenterController extends Controller
{
    private $exam_id;
    private $nber_id;
    private $helperService;
    private $evaluationService;
    private $examService;

    public function __construct(HelperService $helper,EvaluationService $evaluation,ExamService $exam)
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');
        $this->helperService = $helper;
        $this->nber_id = $this->helperService->getNberID();
        $this->evaluationService = $evaluation;
        $this->examService = $exam;

    }

    public function index(Request $r){
        $evaluationcenters = Evaluationcenterdetail::where('exam_id',$this->exam_id)->groupBy('evaluationcenter_id')->get();
        if($r->has('download')){
        $sql = "
        select   evc.name, count(*) as no_of_papers, sum(if(sa.externalattendance_id=1,1,0)) as present, sum(if(sa.externalattendance_id=2,1,0)) as absent,
        sum(if(sa.externalattendance_id not in(1,2),1,0)) as pending_attendance, 
        sum(if(sa.`external_mark` is not null,1,0)) as evaluation_completed,
        evc.`contactperson`, evc.`contactnumber1`, evc.`contactnumber2`, evc.email1, evc.email2
          from supplimentaryapplications sa
        left join supplimentaryapplicants a on a.id = sa.supplimentaryapplicant_id 
        left join institutes i on i.id = a.institute_id
        left join examcenters ec on ec.id = i.examcenter_se_24 and ec.exam_id = 24
        left join externalexamcenters eec on eec.id = ec.externalexamcenter_id
        left join evaluationcenterdetails evd on evd.externalexamcenter_id = eec.id and evd.exam_id = 24
        left join evaluationcenters evc on evc.id = evd.evaluationcenter_id
        where a.block is null
        group by evc.id
        ";
        $data = DB::select($sql);
        Excel::create('attendance', function ($excel) use($data){
            $excel->sheet('attendance', function ($sheet) use($data){
                $sheet->loadview('nber.exam.evaluationcenter.excel',[
                    'data' => $data
                ]);
            });
        })->export('xls');
        return back();
        }
        $examname = \App\Exam::find(Session::get('exam_id'))->name;
        return view('nber.exam.evaluationcenter.index',
            compact(
                'evaluationcenters',
                'examname'
            )
        );
    }

    public function show($id,Request $r){
        if($r->has('downloadall')){
            $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);
            $examcenter_ids = $this->evaluationService->getExamcenterIDs($externalexamcenter_ids);
            $institute_ids  = $this->evaluationService->getInstituteIDs($examcenter_ids);
            $applications =\App\Supplimentaryapplication::whereHas('supplimentaryapplicant',function($q) use($institute_ids){
                $q->where('block',null);
                $q->whereIn('institute_id',$institute_ids);
            })->get();
            Excel::create('attendance', function ($excel) use($applications){
                $excel->sheet('attendance', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.attendance.excel',[
                        'applications' => $applications
                    ]);
                });
            })->export('xls');
        }
        if($r->has('programme_id')){
            $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);
            $examcenter_ids = $this->evaluationService->getExamcenterIDs($externalexamcenter_ids);
            $institute_ids  = $this->evaluationService->getInstituteIDs($examcenter_ids);
            $applications =\App\Supplimentaryapplication::whereHas('supplimentaryapplicant',function($q) use($institute_ids,$r){
                $q->where('block',null);
                $q->whereIn('institute_id',$institute_ids);
                $q->where('programme_id',$r->programme_id);
            })->get();
            Excel::create('attendance', function ($excel) use($applications){
                $excel->sheet('attendance', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.attendance.excel',[
                        'applications' => $applications
                    ]);
                });
            })->export('xls');
        }
        if($r->has('subject_id')){
            $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);
            $examcenter_ids = $this->evaluationService->getExamcenterIDs($externalexamcenter_ids);
            $institute_ids  = $this->evaluationService->getInstituteIDs($examcenter_ids);
            $subject_ids = $this->examService->addAlternative($r->subject_id);
            $applications =\App\Supplimentaryapplication::whereHas('supplimentaryapplicant',function($q) use($institute_ids,$subject_ids){
                $q->where('block',null);
                $q->whereIn('institute_id',$institute_ids);
                $q->whereIn('subject_id',$subject_ids);
            })->get();
            Excel::create('attendance', function ($excel) use($applications){
                $excel->sheet('attendance', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.attendance.excel',[
                        'applications' => $applications
                    ]);
                });
            })->export('xls');
        }
        $evaluationcenter = $this->evaluationService->getEvaluationcenter($id);
        $examcenters =  $this->evaluationService->getExamcenters($id);
        $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);
        $examcenter_ids = $this->evaluationService->getExamcenterIDs($externalexamcenter_ids);
        $institute_ids  = $this->evaluationService->getInstituteIDs($examcenter_ids);
        $sa = $this->evaluationService->getStats($institute_ids,$this->nber_id,'subject_id');
        $courses = $this->evaluationService->getStats($institute_ids,$this->nber_id);
        $examname = \App\Exam::find(Session::get('exam_id'))->name;
        return view('nber.exam.evaluationcenter.show',
                        compact(
                            'examcenters',
                            'evaluationcenter',
                            'examname',
                            'sa',
                            'courses'
                        )
                    );

    }
}
