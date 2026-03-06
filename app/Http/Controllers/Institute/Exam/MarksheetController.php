<?php

namespace App\Http\Controllers\Institute\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;

class MarksheetController extends Controller
{
    public function show($cid,Request $r){
        
        $term = $r->term;
        if($r->has('exam_id') && $r->exam_id == 24){
            $sa = \App\Supplimentaryapplicant::where('candidate_id',$cid)->first();
            $aid = $sa->id;
            $rid = $sa->randstrig;
            $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
            return redirect(url('/files/marksheet/24'."/".$term.'_'.$rid.'_'.$applicantid.'.pdf'));
        }
        if($r->has('exam_id') && $r->exam_id == 25){
            $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
            $aid = $sa->id;
            $rid = $sa->randstrig;
            $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
            return redirect(url('/files/marksheet/25'."/".$term.'_'.$rid.'_'.$applicantid.'.pdf'));
        }
        if($r->has('exam_id') && $r->exam_id > 25){
            



            $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$r->exam_id)->first();
            $aid = $sa->id;
            $rid = $sa->randstrig;
            $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
            if($r->type=='re'){
            return redirect(url('/files/marksheet/'.$r->exam_id."/RE_".$term.'_'.$rid.'_'.$applicantid.'.pdf'));
            }
            return redirect(url('/files/marksheet/'.$r->exam_id."/".$term.'_'.$rid.'_'.$applicantid.'.pdf'));
        }
    
    }
}
