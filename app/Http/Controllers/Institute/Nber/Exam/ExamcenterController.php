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

use Session;

class ExamcenterController extends Controller
{
    private $exam_id;

    public function __construct()
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');
    }

    public function index(){
        $examcenters = Examcenter::where('exam_id',$this->exam_id)->get();
        $examname = \App\Exam::find(Session::get('exam_id'))->name;
        return view('nber.exam.examcenter.index',
            compact(
                'examcenters',
                'examname'
            )
        );
    }

    public function create(){
        $examcenters_ids = Examcenter::where('exam_id',$this->exam_id)->pluck('externalexamcenter_id')->toArray();
        $externalexamcenters = Externalexamcenter::whereNotIn('id',$examcenters_ids)->get();
        $lgstates = \App\Lgstate::all();
        return view('nber.exam.examcenter.create',
            compact(
                'externalexamcenters',
                'lgstates'
            )
        );
    }

    public function edit($id){
        $examcenter  = Examcenter::find($id);
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
        $examcenter = Examcenter::create($r->except('lgstate_id'));
        $examcenter->states()->attach($r->lgstate_id);
        
        Session::flash('messages','Added the center to current exam');
        return redirect('nber/exam/examcenter');
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

}
