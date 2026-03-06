<?php

namespace App\Http\Controllers\Evaluation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Evaluationcenter;

use App\Examtimetable;

use App\Evaluationcenterdetail;

use App\Approvedprogramme;

use App\Currentapplication;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\DB;
use App\Reevaluationapplicationsubject;

use Auth;
use Session;


class ReevaluationController extends Controller
{
    public function download($sid,Request $r){
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        $subject= \App\Subject::find($sid);
        $show = 1;
        if($r->has('show')){
            $show = $r->show;
        }
        $type = 'all';
        if($r->has('type')){
            $type = $r->type;
        }
        $reevaluation =  DB::table('reevaluationapplicationsubjects AS rs')
        ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
        ->join('approvedprogrammes as ap', 'ap.id','=','rs.approvedprogramme_id')
        ->join('institutes AS i','i.id','=','rs.institute_id')
        ->join('examcenters AS ec',function($join){
            $join->on('ec.institute_id','=','ra.institute_id');
            $join->where('ec.exam_id','=',25);
        })
        ->join('newapplications AS ca','ca.id','=','rs.application_id')
        ->join('newapplicants AS na', 'na.id', '=','ca.newapplicant_id')
        ->join('languages as l','l.id','=','na.language_id')
        ->where('rs.exam_id',25)
        ->where('ra.orderstatus_id',1)
        ->where('rs.subject_id',$sid)
        ->where('ec.evaluationcenter_id',$evaluationcenter_id)
        ->selectRaw('
            rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
            concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
            lpad(ca.id,6,0) as dummy_nu,
            ca.external_mark as obtained_mark,
            l.language
        ');
        if($show==2){
            $reevaluation = $reevaluation->where('rs.active_status',1);
        }
        if($type != 'all'){
            $reevaluation = $reevaluation->where('rs.'.$type.'_applystatus',1);
        }
        $reevaluation=$reevaluation->get();
        //$html = View::make('evaluationcenters.reevaluation.excel', compact('reevaluation'))->render();
        $shows = $show == 1 ? 'All' : 'Pending';
        Excel::create('reevaluation-'.$subject->programme->course_name.'-'.$subject->scode.'-'.$type.'-'.$shows, function ($excel) use ($reevaluation,$subject,$shows) {
            $excel->sheet('Reevaluation', function ($sheet) use ($reevaluation, $subject,$shows) {
                $sheet->loadView('evaluationcenters.reevaluation.excel', [
                    'reevaluation' => $reevaluation,
                    'subject' => $subject,
                    'shows' => $shows
                ]);
            });
        })->download();
    }
    public function reevaluation($sid,Request $r){
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        $subject= \App\Subject::find($sid);
                $exam_id=27;

        $show = 1;
        if($r->has('show')){
            $show = $r->show;
        }
        $type = 'all';
        if($r->has('type')){
            $type = $r->type;
        }
        if($r->has('search')){
            $reevaluation =  DB::table('reevaluationapplicationsubjects AS rs')
            ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
            ->join('approvedprogrammes as ap', 'ap.id','=','rs.approvedprogramme_id')
            ->join('examcenters AS ec',function($join) use ($exam_id){
                $join->on('ec.institute_id','=','ra.institute_id');
                $join->where('ec.exam_id','=',$exam_id);
            })
            ->join('institutes AS i','i.id','=','ra.institute_id')
            ->join('newapplications AS ca','ca.id','=','rs.application_id')
            ->join('newapplicants AS na','na.id','=','ca.newapplicant_id')
            ->join('languages as l','l.id','=','na.language_id')
            ->join('evaluationcenterdetails as ed',function($join) use($exam_id){
                $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
                $join->where('ed.exam_id','=',$exam_id);
            })
            ->where('rs.exam_id',$exam_id)
            ->where('ra.orderstatus_id',1)
            ->where('rs.subject_id',$sid)
            ->where('ed.evaluationcenter_id',$evaluationcenter_id)
            ->where('rs.id',$r->search)
            ->selectRaw('
                rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
                concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
                LPAD(ca.id,6,0) as dummy_nu,
                ca.external_mark as obtained_mark,
                rs.reevaluated_marks, rs.no_change, l.language,rs.subject_id,rs.file
            ');
        }else{
            $reevaluation =  DB::table('reevaluationapplicationsubjects AS rs')
            ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
            ->join('approvedprogrammes as ap', 'ap.id','=','rs.approvedprogramme_id')
            ->join('examcenters AS ec',function($join) use ($exam_id){
                $join->on('ec.institute_id','=','ra.institute_id');
                $join->where('ec.exam_id','=',$exam_id);
            })
              ->join('externalexamcenters', 'externalexamcenters.id','=','ec.externalexamcenter_id')
              
            ->join('institutes AS i','i.id','=','ra.institute_id')
             ->join('allapplicants AS ca', function($join) use ($exam_id) {
                $join->on('ca.candidate_id', '=', 'rs.candidate_id');
                $join->where('ca.exam_id', '=', $exam_id);
                $join->where('ca.exam_id', '=', $exam_id);
                $join->whereNull('ca.deleted_at');

            })  
             ->join('allapplications AS na', function($join) use ($exam_id, $sid) {
                    $join->on('na.candidate_id', '=', 'rs.candidate_id');
                    $join->where('na.exam_id', '=', $exam_id);
                    $join->whereNull('na.deleted_at');
                    $join->where('na.subject_id', '=', $sid);
                }) 
            ->join('languages as l','l.id','=','ca.language_id')
            ->join('evaluationcenterdetails as ed',function($join) use ($exam_id){
                $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
                $join->where('ed.exam_id','=',$exam_id);
            })
            ->where('rs.exam_id',$exam_id)
            ->where('ra.orderstatus_id',1)
            ->where('rs.subject_id',$sid)
            ->where('ed.evaluationcenter_id',$evaluationcenter_id)
            ->selectRaw('
                rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
                concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
                na.dummy_number as dummy_nu,
                na.mark_ex as obtained_mark,
                rs.reevaluated_marks, rs.no_change, l.language,externalexamcenters.code,rs.subject_id,rs.file
            ');
        }
        if($show==2){
            $reevaluation = $reevaluation->where('rs.active_status',1);
        }
        if($type != 'all'){
            $reevaluation = $reevaluation->where('rs.'.$type.'_applystatus',1);
        }
        $reevaluation=$reevaluation->paginate(1115);
        return view('evaluationcenters.reevaluation.reevaluation',compact('reevaluation','subject','show','type'));
    }
    public function listsubjects($pid){

          $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        $programme= \App\Programme::find($pid);
        $exam_id=27;
   

        $subjects = DB::table('reevaluationapplicationsubjects AS rs')
                    ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                    ->join('approvedprogrammes AS ap', 'ap.id', '=', 'ra.approvedprogramme_id')

                    ->join('examcenters AS ec',function($join) use ($exam_id){
                        $join->on('ec.institute_id','=','ra.institute_id');
                        $join->where('ec.exam_id','=',$exam_id);
                    })
                    ->join('subjects as s','s.id','=','rs.subject_id')
                    ->join('evaluationcenterdetails as ed',function($join) use ($exam_id){
                        $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
                        $join->where('ed.exam_id','=',$exam_id);
                    })
                    ->where('ra.orderstatus_id',1)
                    ->where('rs.exam_id',$exam_id)
                     ->where('ap.programme_id',$pid)
                    ->where('ed.evaluationcenter_id',$evaluationcenter_id)
                    ->selectRaw('s.id, s.scode,s.sname,  count(distinct ra.id) as reevaluation_applications,  s.syear as term,
                    sum(reevaluation_applystatus) as reevaluation_papers, 
                    sum(retotalling_applystatus) as retotalling_papers, 
                    sum(if(reevaluation_applystatus=1 and rs.active_status= 1,1,0)) as reevaluation_papers_pending, 
                    sum(if(retotalling_applystatus=1 and rs.active_status= 1,1,0)) as retotalling_papers_pending, 
                    sum(photocopying_applystatus) as photocopying_papers')
                    ->groupBy('s.id')
                    ->get();
                    
        return view('evaluationcenters.reevaluation.subjects',compact('subjects','programme'));
    }
    public function downloadall(){

        $exam_id=27; 

        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        // $reevaluation =  DB::table('reevaluationapplicationsubjects AS rs')
        // ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
        // ->join('subjects as s','s.id','=','rs.subject_id')
        // ->join('approvedprogrammes as ap', 'ap.id','=','rs.approvedprogramme_id')
        // ->join('academicyears as y','y.id','=','ap.academicyear_id')
        // ->join('programmes as p', 'p.id','=','ap.programme_id')
        // ->join('examcenters AS ec',function($join) use ($exam_id){
        //     $join->on('ec.institute_id','=','ra.institute_id');
        //     $join->where('ec.exam_id','=',$exam_id);
        // })


        //  ->join('externalexamcenters', 'externalexamcenters.id','=','ec.externalexamcenter_id')
              
        //     ->join('institutes AS i','i.id','=','ra.institute_id')
        //      ->join('allapplicants AS ca', function($join) use ($exam_id) {
        //         $join->on('ca.candidate_id', '=', 'rs.candidate_id');
        //         $join->where('ca.exam_id', '=', $exam_id);
        //         $join->where('ca.exam_id', '=', $exam_id);
        //         $join->whereNull('ca.deleted_at');

        //     })  
        //      ->join('allapplications AS na', function($join) use ($exam_id) {
        //             $join->on('na.candidate_id', '=', 'rs.candidate_id');
        //             $join->where('na.exam_id', '=', $exam_id);
        //             $join->whereNull('na.deleted_at');
        //         }) 
      
        // ->join('languages as l','l.id','=','ca.language_id')
        // ->join('evaluationcenterdetails as ed',function($join) use ($exam_id){
        //     $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
        //     $join->where('ed.exam_id','=',$exam_id);
        // })
        // ->where('rs.exam_id',$exam_id)
        // ->where('ra.orderstatus_id',1)
        // ->where('ed.evaluationcenter_id',$evaluationcenter_id)
        // ->selectRaw('
        //     p.abbreviation as course, s.scode, s.sname, y.year as batch, s.syear as term,
        //      reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
        //     externalexamcenters.code,
        //     concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
        //                     na.dummy_number as dummy_nu,
        //     na.mark_ex as obtained_mark,
        //     rs.reevaluated_marks, rs.no_change, l.language
        // ')->get();


        $reevaluation=[];


        Excel::create('reevaluation-all', function ($excel) use ($reevaluation) {
            $excel->sheet('Reevaluation', function ($sheet) use ($reevaluation) {
                $sheet->loadView('evaluationcenters.reevaluation.allexcel', [
                    'reevaluation' => $reevaluation,
                ]);
            });
        })->download();

    }

     public function printfoilsheet($sid,Request $r){
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        $subject= \App\Subject::find($sid);
                $exam_id=27;

        $show = 1;
        if($r->has('show')){
            $show = $r->show;
        }
        $type = 'all';
        if($r->has('type')){
            $type = $r->type;
        }
                $evaluationcenter  = \App\Evaluationcenter::find($evaluationcenter_id);

   
            $reevaluation =  DB::table('reevaluationapplicationsubjects AS rs')
            ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
            ->join('approvedprogrammes as ap', 'ap.id','=','rs.approvedprogramme_id')
                        ->join('programmes as p', 'p.id','=','ap.programme_id')

            ->join('examcenters AS ec',function($join) use ($exam_id){
                $join->on('ec.institute_id','=','ra.institute_id');
                $join->where('ec.exam_id','=',$exam_id);
            })
              ->join('externalexamcenters', 'externalexamcenters.id','=','ec.externalexamcenter_id')
              
            ->join('institutes AS i','i.id','=','ra.institute_id')
             ->join('allapplicants AS ca', function($join) use ($exam_id) {
                $join->on('ca.candidate_id', '=', 'rs.candidate_id');
                $join->where('ca.exam_id', '=', $exam_id);
                $join->where('ca.exam_id', '=', $exam_id);
                $join->whereNull('ca.deleted_at');

            })  
             ->join('allapplications AS na', function($join) use ($exam_id, $sid) {
                    $join->on('na.candidate_id', '=', 'rs.candidate_id');
                    $join->where('na.exam_id', '=', $exam_id);
                    $join->whereNull('na.deleted_at');
                    $join->where('na.subject_id', '=', $sid);
                }) 
            ->join('languages as l','l.id','=','ca.language_id')
            ->join('evaluationcenterdetails as ed',function($join) use ($exam_id){
                $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
                $join->where('ed.exam_id','=',$exam_id);
            })
            ->where('rs.exam_id',$exam_id)
            ->where('ra.orderstatus_id',1)
            ->where('rs.subject_id',$sid)
            ->where('ed.evaluationcenter_id',$evaluationcenter_id)
            ->selectRaw(' ap.id as approveprogram_id,i.dummy_code,p.abbreviation,
                rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
                concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id) as bundle_number,
                na.dummy_number as dummy_nu,
                na.mark_ex as obtained_mark,
                rs.reevaluated_marks, rs.no_change, l.language,externalexamcenters.code,na.attendance_ex
            ');

        if($show==2){
            $reevaluation = $reevaluation->where('rs.active_status',1);
        }
        if($type != 'all'){
            $reevaluation = $reevaluation->where('rs.'.$type.'_applystatus',1);
        }
        $reevaluation=$reevaluation->orderBy('externalexamcenters.code')->get();
        return view('evaluationcenters.reevaluation.foilsheet',compact('reevaluation','subject','show','type','evaluationcenter'));
    }


    public function listcourses(){
      //  return 'TEST';
        if(Auth::user()->usertype_id ==8) {
            return view('evaluationcenters.demsg');
        }
        $exam_id=27;
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
       
        //return $courses;
$courses = DB::table('reevaluationapplicationsubjects AS rs')
    ->join('reevaluationapplications AS ra', 'rs.reevaluationapplication_id', '=', 'ra.id')
    ->join('examcenters AS i', function ($join) use ($exam_id) {
        $join->on('i.institute_id', '=', 'ra.institute_id')
             ->where('i.exam_id', '=', $exam_id);
    })
    ->join('approvedprogrammes AS ap', 'ap.id', '=', 'ra.approvedprogramme_id')
    ->join('programmes AS p', 'p.id', '=', 'ap.programme_id')
    ->join('evaluationcenterdetails AS ed', function ($join) use ($exam_id) {
        $join->on('ed.externalexamcenter_id', '=', 'i.externalexamcenter_id')
             ->where('ed.exam_id', '=', $exam_id);
    })
    ->where('ra.orderstatus_id',1)
    ->where('ed.evaluationcenter_id', $evaluationcenter_id)
        ->where('rs.exam_id', $exam_id)

    ->selectRaw('
        p.id,
        p.abbreviation,
        COUNT(DISTINCT ra.id) AS reevaluation_applications,
        SUM(reevaluation_applystatus) AS reevaluation_papers,
        SUM(IF(reevaluation_applystatus = 1 AND rs.active_status = 1, 1, 0)) AS reevaluation_papers_pending,
        SUM(retotalling_applystatus) AS retotalling_papers,
        SUM(IF(retotalling_applystatus = 1 AND rs.active_status = 1, 1, 0)) AS retotalling_papers_pending,
        SUM(photocopying_applystatus) AS photocopying_papers
    ')
    ->groupBy('p.id')
    ->get();

//                     SELECT 
//     p.id, 
//     p.abbreviation,  
//     COUNT(DISTINCT ra.id) AS reevaluation_applications, 
//     SUM(reevaluation_applystatus) AS reevaluation_papers, 
//     SUM(IF(reevaluation_applystatus = 1 AND rs.active_status = 1, 1, 0)) AS reevaluation_papers_pending, 
//     SUM(retotalling_applystatus) AS retotalling_papers, 
//     SUM(IF(retotalling_applystatus = 1 AND rs.active_status = 1, 1, 0)) AS retotalling_papers_pending, 
//     SUM(photocopying_applystatus) AS photocopying_papers 
// FROM 
//     reevaluationapplicationsubjects AS rs
// inner JOIN 
//     reevaluationapplications AS ra ON rs.reevaluationapplication_id = ra.id
// inner JOIN 
//     examcenters AS i ON i.institute_id = ra.institute_id and i.exam_id=25
// inner JOIN 
//     approvedprogrammes AS ap ON ap.id = ra.approvedprogramme_id
// inner JOIN 
//     programmes AS p ON p.id = ap.programme_id
// inner JOIN 
//     evaluationcenterdetails AS ed ON ed.externalexamcenter_id = i.externalexamcenter_id and ed.exam_id=25
// 	WHERE 
//  ed.evaluationcenter_id = 39

// GROUP BY 
//     p.id;

        return view('evaluationcenters.reevaluation.index',compact('courses'));
    }

    public function save(Request $r){



if ($r->hasFile('folisheet')) {
    $file = $r->file('folisheet');
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;

    $filename = 'RE27_' . $evaluationcenter_id . '_' . $r->subject_id . '.' . $file->getClientOriginalExtension();
    $destinationPath = public_path('files/markfiles/');
    $file->move($destinationPath, $filename);
}



        $ids = explode(',',substr($r->ids,0,-1));
        foreach($ids as $id){
            $reesub  = Reevaluationapplicationsubject::find($id);
            $new_mark = 'reevaluated_marks_'.$id;
            if($r->has($new_mark) ){
                $reesub->reevaluated_marks = $r->$new_mark;
                if($r->$new_mark == "" ){
                    return 'Yes';
                    $reesub->reevaluated_marks = null;
                }
            }else{
                $reesub->reevaluated_marks = null;
            }
            $no_change = 'nochange_'.$id;
            if($r->has($no_change)){
                $reesub->no_change = 1;
                $reesub->reevaluated_marks = null;
            }else{
                $reesub->no_change = 0;
            }
            if($reesub->no_change == 1 || $reesub->reevaluated_marks != null){
                $reesub->active_status = 0;
            }else{
                $reesub->active_status = 1;
            }

            $reesub->file =$filename;

            $reesub->save();
        }
        Session::put('messages','Updated');
        return back();
    }
}
