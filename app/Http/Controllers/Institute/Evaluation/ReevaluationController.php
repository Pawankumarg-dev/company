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
        ->join('currentapplications AS ca','ca.id','=','rs.application_id')
        ->join('languages as l','l.id','=','ca.language_id')
        ->where('rs.exam_id',22)
        ->where('ra.orderstatus_id',1)
        ->where('rs.subject_id',$sid)
        ->where('i.evaluationcenter_id',$evaluationcenter_id)
        ->selectRaw('
            rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
            concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
            ca.dummy_no as dummy_nu,
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
            ->join('institutes AS i','i.id','=','rs.institute_id')
            ->join('currentapplications AS ca','ca.id','=','rs.application_id')
            ->join('languages as l','l.id','=','ca.language_id')
            ->where('rs.exam_id',22)
            ->where('ra.orderstatus_id',1)
            ->where('rs.subject_id',$sid)
            ->where('i.evaluationcenter_id',$evaluationcenter_id)
            ->where('rs.id',$r->search)
            ->selectRaw('
                rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
                concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
                ca.dummy_no as dummy_nu,
                ca.external_mark as obtained_mark,
                rs.reevaluated_marks, rs.no_change, l.language
            ');
        }else{
            $reevaluation =  DB::table('reevaluationapplicationsubjects AS rs')
            ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
            ->join('approvedprogrammes as ap', 'ap.id','=','rs.approvedprogramme_id')
            ->join('institutes AS i','i.id','=','rs.institute_id')
            ->join('currentapplications AS ca','ca.id','=','rs.application_id')
            ->join('languages as l','l.id','=','ca.language_id')
            ->where('rs.exam_id',22)
            ->where('ra.orderstatus_id',1)
            ->where('rs.subject_id',$sid)
            ->where('i.evaluationcenter_id',$evaluationcenter_id)
            ->selectRaw('
                rs.id, reevaluation_applystatus, retotalling_applystatus, photocopying_applystatus,
                concat(ap.id,"-",i.dummy_code,"-",ap.programme_id,"-",rs.subject_id,"-",l.code) as bundle_number,
                ca.dummy_no as dummy_nu,
                ca.external_mark as obtained_mark,
                rs.reevaluated_marks, rs.no_change, l.language
            ');
        }
        if($show==2){
            $reevaluation = $reevaluation->where('rs.active_status',1);
        }
        if($type != 'all'){
            $reevaluation = $reevaluation->where('rs.'.$type.'_applystatus',1);
        }
        $reevaluation=$reevaluation->paginate(25);
        return view('evaluationcenters.reevaluation.reevaluation',compact('reevaluation','subject','show','type'));
    }
    public function listsubjects($pid){
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        $programme= \App\Programme::find($pid);
      
        $subjects = DB::table('reevaluationapplicationsubjects AS rs')
                    ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                    ->join('institutes AS i','i.id','=','ra.institute_id')
                    ->join('approvedprogrammes as ap','ap.id','=','ra.approvedprogramme_id')
                    ->join('programmes as p','p.id','=','ap.programme_id')
                    ->join('subjects as s','s.id','=','rs.subject_id')
                    ->join('examtimetables as tt','tt.subject_id','=','rs.subject_id')
                    ->where('ra.orderstatus_id',1)
                    ->where('ra.exam_id',22)
                    ->where('tt.exam_id',22)
                    ->where('p.id',$pid)
                    ->where('i.evaluationcenter_id',$evaluationcenter_id)
                    ->selectRaw('s.id, s.scode,s.sname,  count(distinct ra.id) as reevaluation_applications,  s.syear as term,
                    sum(reevaluation_applystatus) as reevaluation_papers, 
                    sum(retotalling_applystatus) as retotalling_papers, 
                    sum(if(reevaluation_applystatus=1 and rs.active_status= 1,1,0)) as reevaluation_papers_pending, 
                    sum(if(retotalling_applystatus=1 and rs.active_status= 1,1,0)) as retotalling_papers_pending, 
                    sum(photocopying_applystatus) as photocopying_papers,
                    tt.examdate, tt.starttime')
                    ->groupBy('s.id')
                    ->get();
                    
        return view('evaluationcenters.reevaluation.subjects',compact('subjects','programme'));
    }
    public function listcourses(){
        if(Auth::user()->usertype_id ==8) {
            return view('evaluationcenters.demsg');
        }
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->first()->id;
        $courses = DB::table('reevaluationapplicationsubjects AS rs')
                    ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                    ->join('institutes AS i','i.id','=','ra.institute_id')
                    ->join('approvedprogrammes as ap','ap.id','=','ra.approvedprogramme_id')
                    ->join('programmes as p','p.id','=','ap.programme_id')
                    ->where('ra.exam_id',22)
                    ->where('i.evaluationcenter_id',$evaluationcenter_id)
                    ->where('ra.orderstatus_id',1)
                    ->selectRaw('p.id, p.abbreviation,  count(distinct ra.id) as reevaluation_applications, 
                    sum(reevaluation_applystatus) as reevaluation_papers, 
                    sum(if(reevaluation_applystatus =1 and rs.active_status=1,1,0)) as reevaluation_papers_pending, 
                    sum(retotalling_applystatus) as retotalling_papers, 
                    sum(if(retotalling_applystatus =1 and rs.active_status=1,1,0)) as retotalling_papers_pending, 
                    sum(photocopying_applystatus) as photocopying_papers')
                    ->groupBy('p.id')
                    ->get();
        return view('evaluationcenters.reevaluation.index',compact('courses'));
    }

    public function save(Request $r){
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
            $reesub->save();
        }
        Session::put('messages','Updated');
        return back();
    }
}
