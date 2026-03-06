<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Exam\GeotaggedphotouploadService;

use DB;
use App\Http\Requests;

class GeotaggedphotoController extends Controller
{
    private $helperService;
    private $gtService;

    public function __construct(HelperService $help,GeotaggedphotouploadService $gt)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $this->gtService = $gt;
    }
    public function index(Request $r){
        if($r->has('institute')){
            //$institute_ids = \App\Newapplicant::pluck('institute_id')->unique()->toArray();
            $sql = ' select id, rci_code, name from institutes where id in(select distinct institute_id from newapplicants) order by rci_code';
            $result = DB::select($sql);
            $institutes = array_map(function ($value) {
                return (array)$value;
            }, $result);
            
            return view('nber.geotaggedphotos.institutes',compact('institutes'));
        }
        $date = \Carbon\Carbon::now()->toDateString();
        if($r->has('date')){
            $date = $r->date;
        }
        $gtphotos = \App\Geotaggedphoto::where('exam_date',$date)->get();
        $nber_id = $this->helperService->getNberID();
        $type = 'date';
        return view('nber.geotaggedphotos.index',compact('gtphotos','nber_id','date','type'));
    }

    public function show($id, Request $r){
        if($r->has('institute')){
            $awardlists = \App\Awardlisttemplate::where('institute_id',$id)->get();
            if($r->has('photos')){
                
                $gtphotos = \App\Geotaggedphoto::whereHas('practicalexam',function($q) use ($id){
                    $q->where('institute_id',$id);
                })->get();
                
                $nber_id = $this->helperService->getNberID();
                $instite = \App\Institute::find($id);
                $date =  $instite->rci_code . ' - ' . $instite->name;
                $type = 'institute';
                $iid = $id;
                return view('nber.geotaggedphotos.index',compact('gtphotos','nber_id','date','type','iid'));
            }
        }else{
        $date = $id;
            if($date==0){
                $awardlists = \App\Awardlisttemplate::all();
            }else{
                $awardlists = \App\Awardlisttemplate::where('exam_date',$date)->get();
            }
        }
        $count = 0; $ofzero =0 ;
        /*foreach($awardlists as $list){
            foreach($list->subjects as $s){
                if($s->pivot->marks_upload == 0 ){
                    $ofzero ++;
                    $na = \App\Newapplication::whereHas('newapplicant',function($q) use($list) {
                        $q->where('approvedprogramme_id',$list->approvedprogramme_id);
                    })->where('subject_id',$s->id)->first();
                    if(!is_null($na)){
                        if($na->external_mark>0){
                            $s->pivot->marks_upload = 1;
                            $s->pivot->save();
                            $count++;
                        }
                    }
                }
            }
        }
        */
        $nber_id = $this->helperService->getNberID();
        return view('nber.geotaggedphotos.show',compact('awardlists','nber_id'));
    }
}
