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
use DB;
class ExamcenterController extends Controller
{
    private $exam_id;

    public function __construct()
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');

    }

   public function index(Request $r)
{

        $nber_id = \App\Nberstaff::where('user_id', Auth::user()->id)
                    ->first()
                    ->nber_id;

        $show = $r->has('show') ? $r->show : 'all';
        $examId = $this->exam_id;

        $examcenters = Examcenter::select(
        'examcenters.*',
        'institutes.name as institute_name',
        DB::raw('GROUP_CONCAT(examcenters.nber_id) as nber_ids'),
        DB::raw('GROUP_CONCAT(max_candidate_for_theory_exam.max_candidate_count) as max_candidates'),
        DB::raw('GROUP_CONCAT(institutes.rci_code) as rci_code'),
        DB::raw('GROUP_CONCAT(examcenters.created_at) as mapped_at'),
        DB::raw('GROUP_CONCAT(examcenters.id) as edit_id')


    )
    ->leftJoin('institutes', 'examcenters.institute_id', '=', 'institutes.id')
    ->leftJoin('max_candidate_for_theory_exam', function ($join) {
        $join->on('examcenters.institute_id', '=', 'max_candidate_for_theory_exam.institute_id')
             ->on('examcenters.nber_id', '=', 'max_candidate_for_theory_exam.nber_id');
    })
    ->where('examcenters.exam_id', $examId)
    ->where('examcenters.nber_id','!=', 8)
    ->groupBy('examcenters.externalexamcenter_id')
    ->get();

    //     // Base query with join to max_candidate_for_theory_exam
    //    $examcenters = Examcenter::select(
    //     'examcenters.*',
    //     DB::raw('GROUP_CONCAT(DISTINCT examcenters.nber_id) as nber_ids'),
    //     DB::raw('GROUP_CONCAT(max_candidate_for_theory_exam.max_candidate_count) as max_candidates'),
    //     DB::raw('GROUP_CONCAT(max_candidate_for_theory_exam.max_candidate_count) as max_candidates')
    // )
    // ->leftJoin('max_candidate_for_theory_exam', function ($join) use ($examId) {
    //     $join->on('examcenters.institute_id', '=', 'max_candidate_for_theory_exam.institute_id')
    //          ->on('examcenters.nber_id', '=', 'max_candidate_for_theory_exam.nber_id');
    //         //  ->where('max_candidate_for_theory_exam.exam_id', '=', $examId);
    // })
    // ->where('examcenters.exam_id', $examId)
    // ->groupBy('examcenters.externalexamcenter_id')
    // ->get();

        $examname = \App\Exam::find($examId)->name;
        // if ($r->has('download')) {
        //     $downloadCenters = Examcenter::where('exam_id', $examId)
        //         ->groupBy('externalexamcenter_id')
        //         ->get();

        //     Excel::create('Exam Centers', function ($excel) use ($downloadCenters, $show) {
        //         $excel->sheet('Exam Centers', function ($sheet) use ($downloadCenters, $show) {
        //             $sheet->loadView("nber.exam.examcenter.excel", [
        //                 'examcenters' => $downloadCenters,
        //                 'show' => $show
        //             ]);
        //         });
        //     })->export('xlsx');
        // }

        return view('nber.exam.examcenter.index', compact(
            'examcenters',
            'examname',
            'show'
        ));
    
}
    public function create(){

    return 'closed';

        $nber_id=  \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $externalexamcenters = Externalexamcenter::where('exam_id',$this->exam_id)->get();

       $maxstudents = \App\MaxCandidateForTheoryExam::where('nber_id', $nber_id)
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
            ->from('examcenters')
            ->whereColumn('examcenters.institute_id', 'max_candidate_for_theory_exam.institute_id')
            ->whereColumn('examcenters.nber_id', 'max_candidate_for_theory_exam.nber_id')
            ->where('examcenters.exam_id', $this->exam_id);
    })
        ->orderBy('rci_code', 'asc')
    ->get();
  return view('nber.exam.examcenter.coeexammap',compact('externalexamcenters','maxstudents','nber_id'));





        // if(Auth::user()->id == 88387){
        // //$examcenters_ids = Examcenter::where('exam_id',$this->exam_id)->pluck('externalexamcenter_id')->toArray();
        // $externalexamcenters = Externalexamcenter::where('exam_id',Session::get('exam_id'))->get();
        // $lgstates = \App\Lgstate::all();
        // $districts = \App\District::all();


        // $maxstudents = \App\Maxstudent::where('exam_id',Session::get('exam_id'))->get();


        // return view('nber.exam.examcenter.create',
        //     compact(
        //         'externalexamcenters',
        //         'maxstudents',
        //         'lgstates',
        //         'districts'
        //     )
        // );
        // }
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

    
        public function show($id){


        return 'closed';
             $nber = \App\Nberstaff::where('user_id', Auth::user()->id)->first();
            if (!$nber) {
                return back()->with('error', 'NBER staff not found');
            }
            $examcenters = Examcenter::where('id', $id)
                ->where('nber_id', $nber->nber_id)->where('exam_id',$this->exam_id)
                ->first();
            if (!$examcenters) {
                return back()->with('error', 'Only consern nber can edit it');
            }
            else{
$updated = Examcenter::where('id', $id)
    ->where('nber_id', $nber->nber_id)
    ->where('exam_id', $this->exam_id)
    ->update(['nber_id' => 8]);

                // $examcenters->delete();
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

    public function store(Request $r){
$examId = $r->exam_id;
$nber_id = $r->nber_id;
    $externalexamcenters = Externalexamcenter::where('exam_id', $this->exam_id)->where('id',$r->externalexamcenter_id)
    ->where(function ($query) {
        $query->whereNull('contactnumber1')->orWhere('contactnumber1', '')
              ->orWhereNull('email1')->orWhere('email1', '')
              ->orWhereNull('contactnumber2')->orWhere('contactnumber2', '')
              ->orWhereNull('email2')->orWhere('email2', '')
              ->orWhereNull('setting_capacity')->orWhere('setting_capacity', '')
              ->orWhereNull('superintendent')->orWhere('superintendent', '');
    })
    ->get();

    if ($externalexamcenters->count() > 0) {
        return back()->with('error', 'Please complete all exam center details before Exam center Mapping.');
    }

    $examcenters = Examcenter::select(
            DB::raw('SUM(max_candidate_for_theory_exam.max_candidate_count) as max_candidates')
        )
        ->leftJoin('institutes', 'examcenters.institute_id', '=', 'institutes.id')
        ->leftJoin('max_candidate_for_theory_exam', function ($join) {
            $join->on('examcenters.institute_id', '=', 'max_candidate_for_theory_exam.institute_id')
                ->on('examcenters.nber_id', '=', 'max_candidate_for_theory_exam.nber_id');
        })
        ->where('examcenters.exam_id', $examId)
        ->where('examcenters.externalexamcenter_id', $r->externalexamcenter_id)
        ->groupBy('examcenters.externalexamcenter_id')
        ->first();
    $maxstudents = \App\MaxCandidateForTheoryExam::where('nber_id', $nber_id)
        ->whereNotExists(function ($query) use ($examId, $r) {
            $query->select(DB::raw(1))
                ->from('examcenters')
                ->whereColumn('examcenters.institute_id', 'max_candidate_for_theory_exam.institute_id')
                ->whereColumn('examcenters.nber_id', 'max_candidate_for_theory_exam.nber_id')
                ->where('examcenters.exam_id', $examId)
                ->where('examcenters.institute_id', $r->institute_id);
        })
        ->orderBy('rci_code', 'asc')
        ->first();
        $total = ($examcenters->max_candidates ?? 0) + ($maxstudents->max_candidate_count ?? 0);
        $setting_capacity = Externalexamcenter::where('exam_id',$this->exam_id)->where('id',$r->externalexamcenter_id)->first()->setting_capacity;
        if ($setting_capacity < $total) {
            return back()->with('error', 'Seating capacity is full.');
        }

        if($r->exam_id == 28){

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
