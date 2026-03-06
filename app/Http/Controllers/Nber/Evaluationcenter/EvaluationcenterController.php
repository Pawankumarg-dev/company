<?php

namespace App\Http\Controllers\Nber\Evaluationcenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Evaluationcenter;

use App\Services\Common\HelperService;
use App\Http\Requests\EVC\StoreEvaluationcenterRequest;
use App\Http\Requests\EVC\UpdateEvaluationcenterRequest;

use Session;

class EvaluationcenterController extends Controller
{
    private $helperService;

    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;
       $this->middleware(['role:nber']);
    }

    public function index(){
        $evaluationcenters = Evaluationcenter::orderBy('id','desc')->get();
        return view('nber.evaluationcenter.index',
            compact(
                'evaluationcenters'
            )
        );
    }

    public function show($id){
        $isRCI = $this->helperService->isRCILogin();
        $evaluationcenter = Evaluationcenter::find($id);
        return view('nber.evaluationcenter.show',compact('evaluationcenter','isRCI'));
    }

    public function create(){
        $lgstates = \App\Lgstate::all();
        return view('nber.evaluationcenter.create',compact('lgstates'));
    }

    public function edit($id){
        $isRCI = $this->helperService->isRCILogin();
        $evaluationcenter = Evaluationcenter::find($id);
        $lgstates = \App\Lgstate::all();
        return view('nber.evaluationcenter.edit',compact('evaluationcenter','lgstates','isRCI'));
    }

    public function store(StoreEvaluationcenterRequest $r){
        $evaluationcenter = Evaluationcenter::create($r->except('username','password','deusername','depassword'));
        $this->helperService->createUser($evaluationcenter,7,$r);
        $r->username = $r->deusername;
        $r->password = $r->depassword;
        $this->helperService->createUser($evaluationcenter,8,$r,'deuser_id');
        Session::flash('messages','Created');
        return view('nber.evaluationcenter.show',compact('evaluationcenter'));
    }

    public function update($id,UpdateEvaluationcenterRequest $r){
        $isRCI = $this->helperService->isRCILogin();
    
        $evaluationcenter = Evaluationcenter::find($id);
        $evaluationcenter->update($r->except('username','password','deusername','depassword'));
        if($isRCI){
            $user = \App\User::where('username',$r->username)->first();
            if(is_null($user)){
                $this->helperService->createUser($evaluationcenter,7,$r);
            }else{
                $this->helperService->updatePassword($evaluationcenter,$r);
            }
            $r->username = $r->deusername;
            $r->password = $r->depassword;
            
            $user = \App\User::where('username',$r->username)->first();
            if(is_null($user)){
                $this->helperService->createUser($evaluationcenter,8,$r,'deuser_id');
            }else{
                $this->helperService->updatePassword($evaluationcenter,$r,'deuser_id');
            }
        }

        Session::flash('messages','Updated');
        return view('nber.evaluationcenter.show',compact('evaluationcenter','isRCI'));
    }

  
 

}
