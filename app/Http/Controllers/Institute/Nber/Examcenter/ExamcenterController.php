<?php

namespace App\Http\Controllers\Nber\Examcenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Externalexamcenter;
use Illuminate\Support\Facades\Hash;
use App\Services\Common\HelperService;

use Session;

class ExamcenterController extends Controller
{


    private $helperService;

    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;
       $this->middleware(['role:nber']);
    }

    public function index(){
        $examcenters = Externalexamcenter::orderBy('id','desc')->get();
        return view('nber.examcenter.index',
            compact(
                'examcenters'
            )
        );
    }

    public function show($id){
        $examcenter = Externalexamcenter::find($id);
        return view('nber.examcenter.show',compact('examcenter'));
    }

    public function create(){
        $lgstates = \App\Lgstate::all();
        return view('nber.examcenter.create',compact('lgstates'));
    }

    public function edit($id){
        $examcenter = Externalexamcenter::find($id);
        $lgstates = \App\Lgstate::all();
        return view('nber.examcenter.edit',compact('examcenter','lgstates'));
    }

    public function store(Request $r){
        $examcenter = Externalexamcenter::create($r->except('username','password'));
        $user = \App\User::where('username',$r->username)->first();
        $this->helperService->createUser($examcenter,$user,$r);
        Session::flash('messages','Created');
        return view('nber.examcenter.show',compact('examcenter'));
    }

    public function update($id,Request $r){
        $examcenter = Externalexamcenter::find($id);
        $examcenter->update($r->except('username','password'));
        $user = \App\User::where('username',$r->username)->first();
        if(!is_null($examcenter->user_id)){
            $this->helperService->updatePassword($examcenter,$r);
        }else{
            if(is_null($user)){
                $this->helperService->createUser($examcenter,6,$r);
            }else{
                $user->usertype_id = 6;
                $user->password = Hash::make($r->password);
                $examcenter->user_id = $user->id;
                $examcenter->save();
                $user->save();
            }
        }
        return redirect('/nber/excenter/'.$examcenter->id.'/edit') ;
        
        Session::flash('messages','Updated');
        return view('nber.examcenter.show',compact('examcenter'));
    }

  
    

}
