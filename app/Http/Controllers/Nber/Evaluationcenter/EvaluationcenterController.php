<?php

namespace App\Http\Controllers\Nber\Evaluationcenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Evaluationcenter;

use App\Services\Common\HelperService;
use App\Http\Requests\EVC\StoreEvaluationcenterRequest;
use App\Http\Requests\EVC\UpdateEvaluationcenterRequest;
use App\Lgstate;
use App\Exam;
use Session;
use Auth;
use DB;
class EvaluationcenterController extends Controller
{
    private $helperService;
private $exam_id;
    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;
       $this->middleware(['role:nber']);
              $this->exam_id=28;

    }

    // public function index(){
    //     $evaluationcenters = Evaluationcenter::orderBy('id','desc')->get();
    //     return view('nber.evaluationcenter.index',
    //         compact(
    //             'evaluationcenters'
    //         )
    //     );
    // }

    // public function show($id){
    //     $isRCI = $this->helperService->isRCILogin();
    //     $evaluationcenter = Evaluationcenter::find($id);
    //     return view('nber.evaluationcenter.show',compact('evaluationcenter','isRCI'));
    // }

    // public function create(){
    //     $lgstates = \App\Lgstate::all();
    //     return view('nber.evaluationcenter.create',compact('lgstates'));
    // }

    // public function edit($id){
    //     $isRCI = $this->helperService->isRCILogin();
    //     $evaluationcenter = Evaluationcenter::find($id);
    //     $lgstates = \App\Lgstate::all();
    //     return view('nber.evaluationcenter.edit',compact('evaluationcenter','lgstates','isRCI'));
    // }

    // public function store(StoreEvaluationcenterRequest $r){
    //     $evaluationcenter = Evaluationcenter::create($r->except('username','password','deusername','depassword'));
    //     $this->helperService->createUser($evaluationcenter,7,$r);
    //     $r->username = $r->deusername;
    //     $r->password = $r->depassword;
    //     $this->helperService->createUser($evaluationcenter,8,$r,'deuser_id');
    //     Session::flash('messages','Created');
    //     return view('nber.evaluationcenter.show',compact('evaluationcenter'));
    // }

    // public function update($id,UpdateEvaluationcenterRequest $r){
    //     $isRCI = $this->helperService->isRCILogin();
    
    //     $evaluationcenter = Evaluationcenter::find($id);
    //     $evaluationcenter->update($r->except('username','password','deusername','depassword'));
    //     if($isRCI){
    //         $user = \App\User::where('username',$r->username)->first();
    //         if(is_null($user)){
    //             $this->helperService->createUser($evaluationcenter,7,$r);
    //         }else{
    //             $this->helperService->updatePassword($evaluationcenter,$r);
    //         }
    //         $r->username = $r->deusername;
    //         $r->password = $r->depassword;
            
    //         $user = \App\User::where('username',$r->username)->first();
    //         if(is_null($user)){
    //             $this->helperService->createUser($evaluationcenter,8,$r,'deuser_id');
    //         }else{
    //             $this->helperService->updatePassword($evaluationcenter,$r,'deuser_id');
    //         }
    //     }

    //     Session::flash('messages','Updated');
    //     return view('nber.evaluationcenter.show',compact('evaluationcenter','isRCI'));
    // }


    public function evalution_details(){
        $evaluationcenters = Evaluationcenter::where('exam_id',$this->exam_id)->orderBy('exam_id','desc')->get();       // dd($evaluationcenters);
        return view('nber.evaluationcenter.evalution.evalutioncenterdetail',compact('evaluationcenters'));
    }
  public function evalution_add(){
        $states = Lgstate::all();
        $exams = Exam::all();
       
        return view('nber.evaluationcenter.evalution.examcenter',compact('states','exams'));
    }
    public function evalution_store(Request $request){
  

        Evaluationcenter::create([
            'code' => $request->code,
            'exam_id' => $this->exam_id,
            'name' => $request->name,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address' => $request->address,
            'contactnumber1' => $request->number1,
            'contactnumber2' => $request->number2,
            'email1' => $request->email1,
            'email2' => $request->email2,
            'contactperson' => $request->contact_person
        ]);
        Session::flash('messages','Created');

        return redirect('nber/evalution_details');
    }

    public function evalution_edit($id){
        $evaluationcenters =Evaluationcenter::find($id);
        $states = Lgstate::all();
       // dd( $evaluationcenters);
       return view('nber.evaluationcenter.evalution.edit',compact('evaluationcenters','states'));
    }

    public function evalution_update(Request $request , $id){
        
        $evaluationcenter = Evaluationcenter::find($id);
        $evaluationcenter->update([
        'code' => $request->code,
        'name' => $request->name,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'address' => $request->address,
        'contactnumber1' => $request->number1,
        'contactnumber2' => $request->number2,
        'email1' => $request->email1,
        'email2' => $request->email2,
        'contactperson' => $request->contact_person
    ]);
           Session::flash('messages','Updated');

        return redirect('nber/evalution_details');
      
    }
    public function magging_add(){

    $nber_id = \App\Nberstaff::where('user_id', Auth::user()->id)
                        ->first()
                        ->nber_id;

    $examcenter = DB::table('examcenters')
        ->join('externalexamcenters', 'examcenters.externalexamcenter_id', '=', 'externalexamcenters.id')
        ->leftJoin('evaluationcenterdetails', function ($join) {
            $join->on('examcenters.externalexamcenter_id', '=', 'evaluationcenterdetails.externalexamcenter_id')
                ->on('examcenters.nber_id', '=', 'evaluationcenterdetails.nber_id')
                ->on('examcenters.exam_id', '=', 'evaluationcenterdetails.exam_id');
        })
        ->where('examcenters.exam_id', $this->exam_id)
        ->where('examcenters.nber_id','=', $nber_id)
        ->whereNull('evaluationcenterdetails.id')
        ->select('externalexamcenters.*')
        ->groupby('externalexamcenters.id')
        ->get();
        
    $evaluation = \App\Evaluationcenter::where('exam_id',$this->exam_id)->orderBy('id', 'desc')->get();

       return view('nber.evaluationcenter.evalution.mapping-add',compact('nber_id','examcenter','evaluation'));
    }

    public function magging_store(Request $request)
{

$nber_id = \App\Nberstaff::where('user_id', Auth::user()->id)
                    ->first()
                    ->nber_id;
    DB::table('evaluationcenterdetails')->insert([
        'exam_id' => $this->exam_id,
        'nber_id' => $nber_id,
        'externalexamcenter_id' => $request->externalexamcenter_id,
        'evaluationcenter_id' => $request->evaluationcenter_id,
       
    ]);
           Session::flash('messages','mapped');

    return redirect('/nber/evalution-mapping-list');
}

 public function magging_list()
 {
    $data = DB::table('evaluationcenterdetails')
        ->join('exams', 'evaluationcenterdetails.exam_id', '=', 'exams.id')
        ->join('externalexamcenters', 'evaluationcenterdetails.externalexamcenter_id', '=', 'externalexamcenters.id')
        ->join('evaluationcenters', 'evaluationcenterdetails.evaluationcenter_id', '=', 'evaluationcenters.id')
        ->where('evaluationcenterdetails.exam_id', 28)
        ->select(
            'exams.name as exam_name',
            'externalexamcenters.code as exam_center_code',
            'externalexamcenters.name as exam_center_name',
            'evaluationcenters.code as evaluation_center_code',
            'evaluationcenters.name as evaluation_center_name'
        )
        ->get();

           return view('nber.evaluationcenter.evalution.mapping-list',compact('data'));

 }
}
