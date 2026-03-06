<?php

namespace App\Http\Controllers\Institute\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;

class CertificateController extends Controller
{
    public function show($cid,Request $r){ 
        if($r->has('exam_id') && $r->exam_id == 24){
            $sa = \App\Supplimentaryapplicant::where('candidate_id',$cid)->first();
            $rid = $sa->randstrig;
            $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
            return redirect(url('/files/certificate/24').'/'.$rid.'_'.$applicantid.'.pdf');
        }
        if($r->has('exam_id') && $r->exam_id == 25){
            $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
            $rid = $sa->randstrig;
            $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
            return redirect(url('/files/certificate/25').'/'.$rid.'_'.$applicantid.'.pdf');
        }
        if($r->has('exam_id') && $r->exam_id > 25){
            $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$r->exam_id)->first();
            $rid = $sa->randstrig;
            $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
             if($r->type=='re'){
            return redirect(url('/files/certificate').'/'.$r->exam_id.'/RE_'.$rid.'_'.$applicantid.'.pdf');
            }
            return redirect(url('/files/certificate').'/'.$r->exam_id.'/'.$rid.'_'.$applicantid.'.pdf');
        }
    }
}