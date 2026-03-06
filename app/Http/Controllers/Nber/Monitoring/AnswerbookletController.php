<?php

namespace App\Http\Controllers\Nber\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Monitoring\Answerbooklet;
use App\Services\Common\Downloadable;
use PDF;
use Auth;

use Session;
use DB;
use Illuminate\Support\Facades\Hash;


class AnswerbookletController extends Controller
{
    private $helperService;
    private $page;


    function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[random_int(0, $charactersLength - 1)];
      }
      return $randomString;
  }

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new Answerbooklet($type));
    }
    public function index(Request $r){
      if(Auth::user()->id != 88387){
        return "";
      }
      // foreach(\App\Evaluator::whereNotNull('password')->whereNotNull('email')->get() as $e){
      // //  $rstring = $this->generateRandomString(6);
      //   $user = \App\User::where('username',$e->email)->first();
      //   if(is_null($user)){
      //   $user = \App\User::create([
      //     'username' => $e->email,
      //     'password' => Hash::make($e->password),
      //     'usertype_id' => 13,
      //     'confirmed' => 1
      //   ]);
      //   }else{
      //     $user->password = Hash::make($e->password);
      //     $user->usertype_id = 13;
      //     $user->save();
      //   }
      //   $e->user_id = $user->id;
      //   $e->save();
      // }
      $results = $this->page->getData();
      $title = $this->page->getTitle();
      $type = $this->page->getType();
      $languages = \App\Language::all();
      //return $results;
     // $evaluationcenters  = $this->page->getEvaluationCenters();
      return (new Downloadable('nber/monitoring','answerbooklets',compact(
        'results',
        'title',
        'type',
        'languages'
      ),$title))->load();
    }
    public function update($id, Request $r){
      if($r->language_id==0){
        Session::flash('messages',"Updated");
        $pe = \App\Pendingevaluation::where('allapplication_id',$id)->get();
        foreach($pe as $p){
          $p->reason_id = 3;
          $p->save();  
        }
        return back();
      }
      $allapplication = \App\Allapplication::find($id);
      $soe = \App\Subjectofevaluator::where('subject_id',$r->subject_id)->where('language_id',$r->language_id)->get();
      
      $approvedprogramme_id = $allapplication->candidate->approvedprogramme_id;
      if($soe->count() > 0){
        $otherapplications= \App\Allapplication::whereHas('candidate',function($q) use($approvedprogramme_id){
          $q->where('approvedprogramme_id',$approvedprogramme_id);
        })->where('subject_id',$allapplication->subject_id)->where('candidate_id','!=',$allapplication->candidate_id)
        ->first();
        if(is_null($otherapplications)){
          $allapplication->evaluator_id =  \App\Subjectofevaluator::where('subject_id',$r->subject_id)->where('language_id',$r->language_id)->first()->evaluator_id;
        }else{
          $allapplication->evaluator_id = $otherapplications->evaluator_id;
        }
        $allapplication->language_id = $r->language_id;
        $allapplication->save();
        Session::flash('messages',"Language Changed");
        $pe = \App\Pendingevaluation::where('allapplication_id',$id)->get();
        foreach($pe as $p){
          $p->reason_id = 3;
          $p->save();  
        }
      }else{
        Session::flash('error',"No evaluator is mapped for this subject");
      }
      return back();
    }
    
    public function show($id){
      $answerbooklet = \App\Answerbookletscan::where('allapplication_id',$id)->first();
      $application = \App\Allapplication::find($id);
    //  return view('evaluationcenters.ansbooklet',compact('answerbooklet','application'));
      if(is_null($answerbooklet)){
          Session::flash("Could not download");
          return back();
      }
      view()->share('application',$application);
      view()->share('answerbooklet',$answerbooklet);
    //  return view('evaluationcenters.ansbooklet',compact('application','answerbooklet'));
      $pdf = PDF::loadView('nber..monitoring.answerbooklets.ansbooklet')->setPaper('a4', 'portrait');
      return $pdf->download($answerbooklet->allapplication->candidate->enrolmentno.'.pdf'); 
    }
}
