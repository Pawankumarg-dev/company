<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Exam\ApplicantService; 
use App\Services\Common\HelperService;
use App\Services\Exam\ScheduleService;
use App\Services\Exam\ExamService;
use App\Services\Exam\TimetableService;

use Session;
use App\Exam;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\Backlog\StoreApplicantRequest;

class ApplicantsummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ApplicantService;
    protected $exam_id;
    protected $helperService;
    protected $exam;
    protected $scheduleService;
    protected $examService;
    protected $timetableService;

    public function __construct(
        ApplicantService $applicant, 
        HelperService $helper,
        ScheduleService $schedle,
        ExamService $exam,
        TimetableService $timetable
        )
    {
       $this->middleware(['role:nber']);
        $this->ApplicantService = $applicant;
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->ApplicantService->assignmodel($this->exam_id);
        $this->helperService = $helper;
        $this->scheduleService = $schedle;
        $this->scheduleService = $schedle;
        $this->examService = $exam;
        $this->timetableService = $timetable;


    }
    public function index(Request $r)
    {
        $nber_id = $this->helperService->getNberID();

        if($r->has('pending')){
            $sql = '

            SELECT  i.rci_code, i.`name` as institute, p.abbreviation as course, y.year as batch, c.name as candiate_name, c.enrolmentno, s.scode, st.type,
                if(s.is_internal=1,if(na.internalattendance_id is null,"Not marked",if(na.internalattendance_id=1,"Present","Absent")) , "No Internal Required")  as internal_attendance ,
                if(s.is_internal=1, if(na.internal_mark is null ,"Not Uploaded","Uploaded") ,"No Internal Required")  as internal_mark ,
                
                if(s.is_external=1,if(na.externalattendance_id is null,"Not marked",if(na.externalattendance_id=1,"Present","Absent")) ,"No External Required")  as external_attendance ,
                if(s.is_external=1, if(na.external_mark is null ,"Not Uploaded","Uploaded") ,"No External Required")  as external_mark 
            FROM newapplications na
                LEFT JOIN newapplicants a  ON a.id = na.newapplicant_id
                LEFT JOIN candidates c on c.id = a.candidate_id
                LEFT JOIN institutes i on i.id = a.institute_id
                LEFT JOIN programmes p on p.id= a.programme_id
                LEFT JOIN approvedprogrammes ap on ap.id = a.approvedprogramme_id
                LEFT JOIN academicyears y on y.id = ap.academicyear_id
                LEFT JOIN subjects s on s.id =na.subject_id
                LEFT JOIN subjecttypes st on st.id = s.subjecttype_id 
                WHERE 
                    ((s.is_external = 1 and ( na.externalattendance_id is null or (na.externalattendance_id = 1 and na.external_mark is null))) or
                    (s.is_internal = 1 and ( na.internalattendance_id is null or (na.internalattendance_id = 1 and na.internal_mark is null))))
                    and p.nber_id = ' . $nber_id ;
                    
            $result = DB::select($sql);
            $progress = array_map(function ($value) {
                return (array)$value;
            }, $result);
            //return $progress;
            Excel::create('Progress ', function ($excel) use($progress){
                $excel->sheet('progress', function ($sheet) use($progress){
                    $sheet->loadview('nber.exam.applicantsummary.pendingentries',[
                        'progress' => $progress
                    ]);
                });
            })->export('xls');
        }
       /* $programme = $this->ApplicantService->getProgramme($r);
        $institute = $this->ApplicantService->getInstitute($r);
        $academicyear = $this->ApplicantService->getAcademicyear($r);
        $applicants= $this->ApplicantService->getApplicants(100);

        $programmes = $this->helperService->getProgrammes(1);
        $institutes = $this->ApplicantService->getInstitutes();
        $academicyears = \App\Academicyear::where('id','>',6)->where('id','<',11)->get();
        
        $nber = $this->helperService->getNberShortCode(); */
        $schedules = $this->examService->getSchedules($this->exam_id);
        $exam = $this->exam;
        $schedule = null;
        $subject = null;
        $timetables = null;
        $examschedule_id = null;
        if($r->has('examschedule_id')){
            $examschedule_id = $r->examschedule_id;
            $schedule= \App\Examschedule::find($examschedule_id);
            $timetables = \App\Examtimetable::where('examschedule_id',$examschedule_id)->get();
        }

      /*  $rval = \App\Supplimentaryapplication::whereHas('supplimentaryapplicant',function($q){
            $q->where('block',null);
            $q->where('payment_status',1);
        })->where('subject_id',$r->subject_id)->with('supplimentaryapplicant')->get();

        */
        $examcenters = null;
        if($r->has('summary')){
            $examcenters = DB::table('supplimentaryapplications as sa')
            ->join('supplimentaryapplicants as a','a.id','=','sa.supplimentaryapplicant_id')
            ->join('institutes as i','i.id','=','a.institute_id')
            ->join('statedistricts as d', 'd.name', '=', 'i.rci_district','left outer')
            ->join('examcenter_lgstate as ecl',function($join){
                $join->on('ecl.lgstate_id','=','i.state_id')
                        ->where(DB::raw('IFNULL(ecl.statezone_id,0)'),'<',1)->orOn('d.statezone_id','=','ecl.statezone_id')
                        ->where(DB::raw('IFNULL(ecl.statezone_id,0)'),'>',0);
            })
            ->join('examcenters as ec','ec.id','=','ecl.examcenter_id')
            ->join('externalexamcenters as eec','eec.id','=','ec.externalexamcenter_id')
            ->join('subjects as s','s.id','=','sa.subject_id')
            ->where('a.payment_status',1)
            ->where('a.block',null)
            ->groupBy('eec.id')
            ->select(DB::raw('eec.code, eec.name, eec.email1, count(distinct a.id) as count_of_students '),
            DB::raw('sum(if(s.sortorder =1 and s.syear = 1,1,0)) as 1_A'),
            DB::raw('sum(if(s.sortorder =1 and s.syear = 2,1,0)) as 1_M'),
            DB::raw('sum(if(s.sortorder =2 and s.syear = 1,1,0)) as 2_A'),
            DB::raw('sum(if(s.sortorder =2 and s.syear = 2,1,0)) as 2_M'),
            DB::raw('sum(if(s.sortorder =3 and s.syear = 1,1,0)) as 3_A'),
            DB::raw('sum(if(s.sortorder =3 and s.syear = 2,1,0)) as 3_M'),
            DB::raw('sum(if(s.sortorder =4 and s.syear = 1,1,0)) as 4_A'),
            DB::raw('sum(if(s.sortorder =4 and s.syear = 2,1,0)) as 4_M'),
            DB::raw('sum(if(s.sortorder =5 and s.syear = 1,1,0)) as 5_A'),
            DB::raw('sum(if(s.sortorder =5 and s.syear = 2,1,0)) as 5_M'),
            DB::raw('sum(if(s.sortorder =6 and s.syear = 1,1,0)) as 6_A'),
            DB::raw('sum(if(s.sortorder =6 and s.syear = 2,1,0)) as 6_M')
            )
            ->get();
            
            return view('nber.exam.applicantsummary.summary',compact(
                'exam',
                'examcenters'
            ));
        }

        if($r->has('subject_id')){
            $languagesql = DB::table('languages')
                            ->selectRaw("group_concat('sum(if(a.language_id = ',id,',1,0)) as ',language) as sqlquery")->get()[0]->sqlquery;

            $languages = \App\Language::all();
            $examcenters = DB::table('supplimentaryapplications as sa')
                    ->join('supplimentaryapplicants as a','a.id','=','sa.supplimentaryapplicant_id')
                    ->join('institutes as i','i.id','=','a.institute_id')
                    ->join('statedistricts as d', 'd.name', '=', 'i.rci_district','left outer')
                  //  ->join('examcenter_lgstate as ecl','ecl.lgstate_id','=','i.state_id')
                    ->join('examcenter_lgstate as ecl',function($join){
                        $join->on('ecl.lgstate_id','=','i.state_id')
                                ->where(DB::raw('IFNULL(ecl.statezone_id,0)'),'<',1)->orOn('d.statezone_id','=','ecl.statezone_id')
                                ->where(DB::raw('IFNULL(ecl.statezone_id,0)'),'>',0);
                    })
                    ->join('examcenters as ec','ec.id','=','ecl.examcenter_id')
                    ->join('externalexamcenters as eec','eec.id','=','ec.externalexamcenter_id')
                    ->join('lgstates as lgs','lgs.id','=','i.state_id')
                    ->where('a.payment_status',1)
                    ->where('a.block',null)
                    ->where('sa.subject_id',$r->subject_id)
                    ->groupBy('eec.id')
                    ->selectRaw('eec.code, eec.name, eec.email1, count(distinct sa.id) as count_of_students, '.$languagesql)
                    ->get();
                    
                    $subject = \App\Subject::find($r->subject_id);
                    return view('nber.exam.applicantsummary.index',compact(
                        'exam',
                        'schedules',
                        'schedule',
                        'subject',
                        'timetables',
                        'examschedule_id',
                        'nber_id',
                        'examcenters',
                        'languages'
                    ));
        }            
        
        if($r->has('examschedule_id')){
            $languagesql = DB::table('languages')
                            ->selectRaw("group_concat('sum(if(a.language_id = ',id,',1,0)) as ',language) as sqlquery")->get()[0]->sqlquery;
            $subject_ids  = $this->timetableService->getSubjectIDs($r->examschedule_id);
            $languages = \App\Language::all();
            $examcenters = DB::table('supplimentaryapplications as sa')
                    ->join('supplimentaryapplicants as a','a.id','=','sa.supplimentaryapplicant_id')
                    ->join('institutes as i','i.id','=','a.institute_id')
                    ->join('statedistricts as d', 'd.name', '=', 'i.rci_district','left outer')
                  //  ->join('examcenter_lgstate as ecl','ecl.lgstate_id','=','i.state_id')
                    ->join('examcenter_lgstate as ecl',function($join){
                        $join->on('ecl.lgstate_id','=','i.state_id')
                                ->where(DB::raw('IFNULL(ecl.statezone_id,0)'),'<',1)->orOn('d.statezone_id','=','ecl.statezone_id')
                                ->where(DB::raw('IFNULL(ecl.statezone_id,0)'),'>',0);
                    })
                    ->join('examcenters as ec','ec.id','=','ecl.examcenter_id')
                    ->join('externalexamcenters as eec','eec.id','=','ec.externalexamcenter_id')
                    ->join('lgstates as lgs','lgs.id','=','i.state_id')
                    ->join('subjects as s','s.id','=','sa.subject_id')
                    ->join('programmes as p','p.id','=','s.programme_id')
                    ->where('a.payment_status',1)
                    ->where('a.block',null)
                    ->whereIn('sa.subject_id',$subject_ids)
                    ->groupBy('eec.id','s.id')
                    ->selectRaw('
                        eec.code, 
                        eec.name, 
                        eec.email1, 
                        count(distinct sa.id) as count_of_students, 
                        s.scode,
                        s.sname, 
                        p.abbreviation, 
                        '.$languagesql)
                    ->orderBy('eec.code','p.id')
                    ->get();
                    
                    $subject = \App\Subject::find($r->subject_id);
        }

        return view('nber.exam.applicantsummary.index',compact(
            'exam',
            'schedules',
            'schedule',
            'subject',
            'timetables',
            'examschedule_id',
            'nber_id',
            'examcenters',
            'languages'
        ));
    }

    public function show($id,Request $r)
    {
        $applicant = $this->ApplicantService->getApplicant($id);
        
        $district_id = $applicant->candidate->district_id;
        $exam_center = $this->ApplicantService->getExamcenter($applicant->institute,2,$district_id);
        
        $exam = $this->exam;

        if($r->has('downloadht')){
            $format = 'pdf';
            $term = 0;
            if($r->has('term')){
                $term = $r->term;
            }else{
                Session::flash('error','Please select Term');
                return back();
            }
            view()->share('applicant',$applicant);
            view()->share('exam_center',$exam_center);
            view()->share('term',$term);
            view()->share('format',$format);

            $headers = array(
                'Content-Type: application/pdf',
            );
            try{
                $pdf = PDF::loadView('common.exam.hallticket')->setPaper('a4', 'portrait');
                return $pdf->download('hallticket_'.$applicant->candidate->enrolmentno.'_term_'.$term.'.pdf');
            }catch(\Exception $e){
                $format = 'html';
                return view('common.exam.hallticket',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format'
                ));
            }

        }
        
        $fy_count = $this->ApplicantService->getNumberOfPapers(1);
        $sy_count = $this->ApplicantService->getNumberOfPapers(2);
        

        return view('nber.exam.applicants.show',compact(
            'applicant',
            'exam',
            'exam_center',
            'fy_count',
            'sy_count'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
