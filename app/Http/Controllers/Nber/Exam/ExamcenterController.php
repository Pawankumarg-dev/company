<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Externalexamcenter;
use App\Examcenter;
use App\Statezone;

use App\Http\Requests\Exam\StoreExamcenterRequest;
use App\Http\Requests\Exam\UpdateExamcenterRequest;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;

class ExamcenterController extends Controller
{
    private $exam_id;

    public function __construct()
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');

    }

    public function index(Request $r){
        
        if(Auth::user()->id == 88387){
           
            $show = $r->has('show') ? $r->show : 'all';
            $examcenters = Examcenter::where('exam_id',$this->exam_id);
            if($show=='ec'){
                $examcenters = $examcenters->groupBy('externalexamcenter_id');
            }
            $examcenters = $examcenters->get();
            $examname = \App\Exam::find(Session::get('exam_id'))->name;
            
            if($r->has('download')){
                $examcenters = Examcenter::where('exam_id',$this->exam_id)->groupBy('externalexamcenter_id')->get();
                Excel::create('Exam Centers', function ($excel) use($examcenters,$show){
                    $excel->sheet('Exam Centers', function ($sheet) use($examcenters,$show){
                        $sheet->loadview("nber.exam.examcenter.excel",[
                            'examcenters' => $examcenters,
                            'show' => $show
                        ]);
                    });
                })->export('xlsx');
            }
            return view('nber.exam.examcenter.index',
                compact(
                    'examcenters',
                    'examname',
                    'show'
                )
            );
        }
    }

    public function create(){
        if(Auth::user()->id == 88387){
        //$examcenters_ids = Examcenter::where('exam_id',$this->exam_id)->pluck('externalexamcenter_id')->toArray();
        $externalexamcenters = Externalexamcenter::where('exam_id',Session::get('exam_id'))->get();
        $lgstates = \App\Lgstate::all();
        $districts = \App\District::all();
        $maxstudents = \App\Maxstudent::where('exam_id',Session::get('exam_id'))->get();
        return view('nber.exam.examcenter.create',
            compact(
                'externalexamcenters',
                'maxstudents',
                'lgstates',
                'districts'
            )
        );
        }
    }
    public function verifyotp($id,$examschedule_id){
        $otp = \App\Questionpaperotp::where('externalexamcenter_id',$id)->where('exam_id',27)->where('examschedule_id',$examschedule_id)->first();
            if(is_null($otp)){
                \App\Questionpaperotp::create([
                        'externalexamcenter_id' => $id,
                        'examschedule_id' => $examschedule_id,
                        'verified' =>1 ,
                        'exam_id' => 27
                ]);
            }else{
                $otp->verified = 1;
                $otp->save();
            }
    }
    public function edit($id,Request $r){
        if($r->has('req')){
            if($r->req == 'otp'){
                $examschedule_id = 67;
                $this->verifyotp($id,$examschedule_id);
                $examschedule_id = 68;
                $this->verifyotp($id,$examschedule_id);
            }
        }

        Session::put('message','Updated');
        return redirect('nber/excenter/');
        $examcenter  = \App\Examcenter::find($id);
        $state_ids = $examcenter->states()->pluck('lgstate_id')->toArray();
        $lgstates = \App\Lgstate::whereNotIn('id',$state_ids)->get();
        $examsin = \App\Supplimentaryapplicant::groupBy('institute_id')->pluck('institute_id')->toArray();
        $institutes = \App\Institute::whereIn('state_id',$state_ids)->whereIn('id',$examsin)->get();
        $districts = \App\Institute::whereIn('state_id',$state_ids)->groupBy('rci_district')->pluck('rci_district')->toArray();
        $statezones = Statezone::all();
        $evaluationcenters = \App\Evaluationcenter::all();
        $evaluationcenter = \App\Evaluationcenterdetail::where('exam_id',24)
                            ->where('externalexamcenter_id',$examcenter->externalexamcenter_id)->first();
        return view('nber.exam.examcenter.edit',
            compact(
                'examcenter',
                'lgstates',
                'institutes',
                'statezones',
                'districts',
                'examsin',
                'evaluationcenters',
                'evaluationcenter'
            )
        );
    }

    public function store(StoreExamcenterRequest $r){
        if(Auth::user()->id == 88387){
            
            if($r->type == 'institute'){
                $examcenter = Examcenter::create($r->all());
            }
            if($r->type == 'district'){
                $district = $r->district_id;
                $institute_ids = \App\Institute::where('district_id',$district)->pluck('id')->toArray();
                Examcenter::where('exam_id',Session::get('exam_id'))->whereIN('institute_id',$institute_ids)->delete();
                $currentinstitutes = \App\Maxstudent::whereIn('institute_id',$institute_ids)->get();
                foreach($currentinstitutes as $ms){
                    Examcenter::create([
                        'exam_id' => $r->exam_id,
                        'institute_id' => $ms->institute_id,
                        'externalexamcenter_id' => $r->externalexamcenter_id
                    ]);
                }
            }
            if($r->type == 'state'){
                $state = $r->state_id;
                $institute_ids = \App\Institute::where('state_id',$state)->pluck('id')->toArray();
                Examcenter::where('exam_id',Session::get('exam_id'))->whereIN('institute_id',$institute_ids)->delete();
                $currentinstitutes = \App\Maxstudent::whereIn('institute_id',$institute_ids)->get();
                foreach($currentinstitutes as $ms){
                    Examcenter::create([
                        'exam_id' => $r->exam_id,
                        'institute_id' => $ms->institute_id,
                        'externalexamcenter_id' => $r->externalexamcenter_id
                    ]);
                }
            }
            
            
            Session::flash('messages','Added the center to current exam');
            return redirect('nber/exam/examcenter');
        }
    }

    public function update($id,UpdateExamcenterRequest $r){
        $examcenter = Examcenter::find($id);
        if($examcenter->states->count() > 0){
            foreach($examcenter->states as $state){
                if($r->has('statezone_id_'.$state->id)){
                    $zone_id = 'statezone_id_'.$state->id;
                    $examcenter->states()->detach($state->id);
                    $examcenter->states()->attach([$state->id => ['statezone_id' => $r->$zone_id]]);
                }
                if($r->has('remove_'.$state->id)){
                    $examcenter->states()->detach($state->id);         
                }
            }
        }

        if($r->has('lgstate_id')){
            $examcenter->states()->attach($r->lgstate_id); 
        }
        $evaluationcenter = \App\Evaluationcenterdetail::where('exam_id',24)
                            ->where('externalexamcenter_id',$r->externalexamcenter_id)->first();
        if(is_null($evaluationcenter)){
            \App\Evaluationcenterdetail::create([
                'exam_id' => 24,
                'evaluationcenter_id' => $r->evaluationcenter_id,
                'externalexamcenter_id' => $r->externalexamcenter_id
            ]);
        }else{
            $evaluationcenter->evaluationcenter_id = $r->evaluationcenter_id;
            $evaluationcenter->save();
        }   
        Session::flash('messages','Updated');
        return back();

    }
    public function destroy($id){
        $ec = Examcenter::find($id);
        $ec->delete();
        Session::put('messages','Deleted');
        return back();
    }

}
