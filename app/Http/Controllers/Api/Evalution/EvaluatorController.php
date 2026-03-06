<?php

namespace App\Http\Controllers\Api\Evalution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subject;
use App\Programme;
use App\Approvedprogramme;
use App\Academicyear;
use App\Allapplicant;
use App\Institute;
use App\User;
use Validator;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use PDF;
use App\Utils\CustomPDF;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Services\Common\HelperService;
use App\Token;
use App\Evaluationcenter;
use App\Services\DBService;
use Illuminate\Support\Str;
use File;



class EvaluatorController extends Controller
{
    private $helperService;
    private $exam_id;
    public function __construct() {
        $this->helperService = new HelperService;
        $this->exam_id = $this->helperService->getScheduledExamID();
    }

    public function login(Request $request)
    {
        
        $errors = [];
        try {
            if (!isset($request->username)) {
                $errors['username'] = 'Please input a valid username';
            }
            if (!isset($request->password)) {
                $errors['password'] = 'Please input a valid password';  
            }
    
            if (count($errors) > 0) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $errors
                ], 200);
            }
    
            $user = User::where('username', $request->username)
                        ->where('usertype_id', 13)
                        ->first();

                        

                if (!$user || !Hash::check($request->password, $user->password)) {
                $errors['Invalid User'] = 'Wrong user credentials';
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $errors
                ], 200); 
            }

            $evaluator = \App\Evaluator::where('user_id', $user->id)->first();
            if (!$evaluator) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Evaluation center not found for the user.'
                ], 200);
            }
            $expiry = Carbon::now()->addDay(); 
            $token =rand(100000, 999999);

    
            Token::create([
                'user_id' => $user->id,
                'evaluationcenter_id' => $evaluator->id,
                'token' => $token,
                'expiry' => $expiry,
            ]);
            return new JsonResponse([
                'status' => 'success',
                'token' => $token,
                'expires_at' => $expiry->toDateTimeString(),
                'evaluator_id' => $evaluator->id
            ], 200);
    
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 200); 
        }
    }
    public function subjects_old(Request $r){
        $sql = 'select 
            se.id,
            se.examtimetable_id,
            se.subject_id,
            l.id as language_id,
            p.abbreviation as course,
            s.scode as subject_code,
            s.sname as subject,
            l.language,
            count(a.id) as no_of_papers,
            sum(if(abs.uploaded=1,1,0)) as available,
            sum(if(abs.evaluated=1,1,0)) as evaluated,
            se.exam_id as exam_id
        from 
            subjectofevaluators se
        inner join 
            subjects s
        on
            s.id = se.subject_id
        inner join
            programmes p
        on 
            p.id = s.programme_id
        inner join
            languages l
        on 
            l.id = se.language_id
        inner join
            allapplications aa
        on
            aa.subject_id = s.id 
        inner join
            allapplicants a 
        on 
            a.id = aa.applicant_id 
        and
            a.language_id = se.language_id
        left join
            answerbookletscans abs
        on
            abs.allapplication_id = aa.id
        where
            aa.blocked != 1 and

            se.evaluator_id = ' . $r->evaluator_id .' 
        and 
            se.exam_id = '.$this->exam_id.'
        group by
            se.id
        ;';
    
        $result = (new DBService())->fetch($sql);
        return response()->json($result);
    }

    public function subjects(Request $r){
        $sql = 'select 
            se.id,
            se.examtimetable_id,
            se.subject_id,
            l.id as language_id,
            p.abbreviation as course,
            s.scode as subject_code,
            s.sname as subject,
            l.language,
            count(distinct aa.id) as no_of_papers,
            sum(if(abs.uploaded=1,1,0)) as available,
            sum(if(abs.evaluated=1,1,0)) as evaluated,
            se.exam_id as exam_id
        from 
            subjectofevaluators se
        inner join 
            subjects s
        on
            s.id = se.subject_id
        inner join
            programmes p
        on 
            p.id = s.programme_id
        inner join
            languages l
        on 
            l.id = se.language_id
        inner join
            allapplications aa
        on
            aa.subject_id = s.id 
        and
            aa.language_id = se.language_id
        left join
            answerbookletscans abs
        on
            abs.allapplication_id = aa.id
        where
            aa.blocked != 1 
        and
            aa.attendance_ex = 1
        and
            se.evaluator_id = ' . $r->evaluator_id .' 
        and 
            se.exam_id = '.$this->exam_id.'
        and
            aa.evaluator_id = '.$r->evaluator_id .' 
        group by
            se.id
        ;';
    
        $result = (new DBService())->fetch($sql);
        return response()->json($result);
    }


    public function answerbooklets(Request $r){
        $sql = 'select 
                    aa.id,
                    aa.candidate_id,
                    aa.subject_id
                from
                    allapplications aa
                inner join
                    answerbookletscans abs
                on
                    abs.allapplication_id = aa.id
                inner join
                    subjectofevaluators se 
                on 
                    se.subject_id = aa.subject_id
                and
                    se.language_id = aa.language_id
                where
                    abs.uploaded = 1
                and
                    abs.evaluated = 0
                and
                    aa.evaluator_id =  ' . $r->evaluator_id . ' 
                and
                    se.evaluator_id = ' . $r->evaluator_id . ' 
                and
                    se.id = ' . $r->id . ' 
                and
                    aa.blocked = 0;';
        $result = (new DBService())->fetch($sql);
        return response()->json($result);
    }
   
    public function qppattern(Request $r){
        $sql = " select ak.total_marks, sum(p.number_of_questions_to_answer * p.marks_per_question) as total_mark, s.emax_marks  from answerkeys ak inner join qppatterns p  on p.examtimetable_id = ak.examtimetable_id inner join subjects s on s.id = ak.subject_id inner join programmes c on c.id = s.programme_id where ak.examtimetable_id  = " .$r->examtimetable_id . " group by ak.id;";
        $totalmarks = (new DBService())->fetch($sql)[0];

        if($totalmarks->total_marks > 0){
            if($totalmarks->total_marks != $totalmarks->total_mark){
                return response()->json('failed');
            }
            if($totalmarks->total_marks != $totalmarks->emax_marks){
                return response()->json('failed');
            }
        }
        $sql = 'select
                id,
                heading,
                number_of_questions,
                number_of_questions_to_answer,
                marks_per_question
            from 
                qppatterns
            where
                examtimetable_id  = ' .$r->examtimetable_id . ' 
                ';
        $result = (new DBService())->fetch($sql);
        return response()->json($result);
    }
    public function answerkey(Request $r){
        $sql = 'select 
                    answerkey 
                from
                    answerkeys
                where 
                    examtimetable_id = ' .$r->examtimetable_id . ' 
                ';
        $result = (new DBService())->fetch($sql);
        return response()->json($result);
    }
    public function questionpaper(Request $r){
        $fileexists = 0;
        $sql = '
                select 
                    case  es.qpset 
                    when 1 then qp.question_paper_1
                    when 2 then qp.question_paper_2
                    when 3 then qp.question_paper_3
                    end as question_paper,
                    tt.password
                from examtimetable_language qp
                inner join examtimetables tt on tt.id = qp.examtimetable_id
                inner join examschedules es on tt.examschedule_id = es.id
                where qp.language_id = ' .$r->language_id . '  and tt.id =  ' .$r->examtimetable_id . ' ;
                ';


        $result = (new DBService())->fetch($sql);

        $recheck = 0;
        if($result->count() == 0 || is_null($result[0]->question_paper) ){
                $recheck = 1;
        }else{
            $file = public_path().'/files/processedqp/todelete/dc_' .$r->language_id . '_'.$result[0]->question_paper;
            if((!file_exists($file))){ $recheck = 1; }else{
                $fileexists = 1;
            }
        }
        if(($recheck == 1 && $fileexists == 0)){
            $sql = '
                select 
                    case  es.qpset 
                    when 1 then qp.question_paper_1
                    when 2 then qp.question_paper_2
                    when 3 then qp.question_paper_3
                    end as question_paper,
                    tt.password
                from examtimetable_language qp
                inner join examtimetables tt on tt.id = qp.examtimetable_id
                inner join examschedules es on tt.examschedule_id = es.id
                where qp.language_id = 14  and tt.id =  ' .$r->examtimetable_id . ' ;
                ';
        
            $result = (new DBService())->fetch($sql);
            if($result->count() > 0 && !is_null($result[0]->question_paper)){
                try{
                    $source = public_path().'/files/processedqp/todelete/dc_14_'.$result[0]->question_paper;
                    $destination = public_path().'/files/processedqp/todelete/dc_'.$r->language_id.'_'.$result[0]->question_paper;
                    if(file_exists($source) && !file_exists($destination)){
                        File::copy($source,$destination);
                    }
                }catch(\Exception $e){

                }
            }
            //}
        }
        $recheck = 0;
        if($result->count() == 0 || is_null($result[0]->question_paper) ){
                $recheck = 1;
        }else{
            $file = public_path().'/files/processedqp/todelete/dc_' .$r->language_id . '_'.$result[0]->question_paper;
            if((!file_exists($file))){ $recheck = 1; }else{
                $fileexists = 1;
            }
        }
        if(($recheck == 1 && $fileexists == 0)){
            $sql = '
                select 
                    case  es.qpset 
                    when 1 then qp.question_paper_1
                    when 2 then qp.question_paper_2
                    when 3 then qp.question_paper_3
                    end as question_paper,
                    tt.password
                from examtimetable_language qp
                inner join examtimetables tt on tt.id = qp.examtimetable_id
                inner join examschedules es on tt.examschedule_id = es.id
                where qp.language_id = 1  and tt.id =  ' .$r->examtimetable_id . ' ;
                ';

            $result = (new DBService())->fetch($sql);
            if($result->count() > 0 && !is_null($result[0]->question_paper)){
                try{
                    $source = public_path().'/files/processedqp/todelete/dc_1_'.$result[0]->question_paper;
                    $destination = public_path().'/files/processedqp/todelete/dc_'.$r->language_id.'_'.$result[0]->question_paper;
                    if(file_exists($source) && !file_exists($destination)){
                        File::copy($source,$destination);
                    }
                }catch(\Exception $e){

                }
            }
        }
        $recheck = 0;
        if($result->count() == 0 || is_null($result[0]->question_paper) ){
                $recheck = 1;
        }else{
            $file = public_path().'/files/processedqp/todelete/dc_' .$r->language_id . '_'.$result[0]->question_paper;
            if((!file_exists($file))){ $recheck = 1; }else{
                $fileexists = 1;
            }
        }
        if(($recheck == 1 && $fileexists == 0)){
            $sql = '
                select 
                    case  es.qpset 
                    when 1 then qp.question_paper_1
                    when 2 then qp.question_paper_2
                    when 3 then qp.question_paper_3
                    end as question_paper,
                    tt.password
                from examtimetable_language qp
                inner join examtimetables tt on tt.id = qp.examtimetable_id
                inner join examschedules es on tt.examschedule_id = es.id
                where qp.language_id = 2  and tt.id =  ' .$r->examtimetable_id . ' ;
                ';

            $result = (new DBService())->fetch($sql);
            if($result->count() > 0 && !is_null($result[0]->question_paper)){
                try{
                    $source = public_path().'/files/processedqp/todelete/dc_2_'.$result[0]->question_paper;
                    $destination = public_path().'/files/processedqp/todelete/dc_'.$r->language_id.'_'.$result[0]->question_paper;
                    if(file_exists($source) && !file_exists($destination)){
                        File::copy($source,$destination);
                    }
                }catch(\Exception $e){

                }
            }
        }
        $recheck = 0;
        if($result->count() == 0 || is_null($result[0]->question_paper) ){
                $recheck = 1;
        }else{
            $file = public_path().'/files/processedqp/todelete/dc_' .$r->language_id . '_'.$result[0]->question_paper;
            if((!file_exists($file))){ $recheck = 1; }else{
                $fileexists = 1;
            }
        }
        if(($recheck == 1 && $fileexists == 0)){
            $sql = '
                select 
                    case  es.qpset 
                    when 1 then qp.question_paper_1
                    when 2 then qp.question_paper_2
                    when 3 then qp.question_paper_3
                    end as question_paper,
                    tt.password
                from examtimetable_language qp
                inner join examtimetables tt on tt.id = qp.examtimetable_id
                inner join examschedules es on tt.examschedule_id = es.id
                where qp.language_id = 3  and tt.id =  ' .$r->examtimetable_id . ' ;
                ';

            $result = (new DBService())->fetch($sql);
            if($result->count() > 0 && !is_null($result[0]->question_paper)){
                try{
                    $source = public_path().'/files/processedqp/todelete/dc_3_'.$result[0]->question_paper;
                    $destination = public_path().'/files/processedqp/todelete/dc_'.$r->language_id.'_'.$result[0]->question_paper;
                    if(file_exists($source) && !file_exists($destination)){
                        File::copy($source,$destination);
                    }
                }catch(\Exception $e){

                }
            }
        }
        
        
        return response()->json($result);
    }

    public function answerbooklet(Request $r){
        $applicaion_id = $r->allapplication_id;
        $answerbooklet = \App\Answerbookletscan::where('allapplication_id',$applicaion_id)->first();
        $application = \App\Allapplication::find($applicaion_id);
      //  return view('evaluationcenters.ansbooklet',compact('answerbooklet','application'));
        if(is_null($answerbooklet)){
            return response()->json('failed');
        }
        view()->share('application',$application);
        view()->share('answerbooklet',$answerbooklet);
      //  return view('evaluationcenters.ansbooklet',compact('application','answerbooklet'));
        $pdf = PDF::loadView('evaluationcenters.ansbooklet')->setPaper('a4', 'portrait');
        return $pdf->download($answerbooklet->id.'.pdf'); 
    }

    public function savemarks(Request $r){
        $evaluations = json_decode($r->marks);
        $allapplication_id = 0;
        $eval = \App\Evaluation::where('allapplication_id',$evaluations[0]->p4)->first();
        if(is_null($eval)){
            foreach($evaluations as $e){
            \App\Evaluation::create(
                [
                    'exam_id'=> $e->p1,
                    'examtimetable_id' => $e->p2,
                    'subject_id' => $e->p3,
                    'allapplication_id' => $e->p4,
                    'candidate_id' => $e->p5,
                    'evaluator_id' => $e->p6,
                    'subjetofevaluator_id' => $e->p7,
                    'qppattern_id' => $e->p8,
                    'question_no' => $e->p9,
                    'mark' => $e->p10
                ]
                );
                $allapplication_id  = $e->p4;
            }
            $abls = \App\Answerbookletscan::where('allapplication_id',$allapplication_id)->first();
            $abls->evaluated = 1;
            $abls->save();
            return response()->json("success");
        }else{                   
            return response()->json("failed");

        }
    }

    public function pending(Request $r){
        \App\Pendingevaluation::create([
            'exam_id' => $this->exam_id,
            'allapplication_id' => $r->allapplication_id,
            'evaluator_id' => $r->evaluator_id,
            'reason_id' => $r->reason_id
        ]);
        if($r->reason_id == 1){
            $abl = \App\Answerbookletscan::where('allapplication_id',$r->allapplication_id)->first();
            $abl->scanned = 0;
            $abl->verified = 0;
            $abl->uploaded = 0;
            $abl->save();
        }
        return response()->json("success");
    }
}