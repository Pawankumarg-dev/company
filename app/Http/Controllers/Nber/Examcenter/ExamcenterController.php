<?php

namespace App\Http\Controllers\Nber\Examcenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Externalexamcenter;
use Illuminate\Support\Facades\Hash;
use App\Services\Common\HelperService;
use Auth;

use Session;

class ExamcenterController extends Controller
{


    private $helperService;

    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;
       $this->middleware(['role:nber']);
    }

    public function index(Request $r){
        if(Auth::user()->id == 88387){
        $examcenters = Externalexamcenter::where('exam_id',27)->orderBy('id','desc')->get();
       
        return view('nber.examcenter.index',
            compact(
                'examcenters'
            )
        );
        }
    }

    public function show($id){
        if(Auth::user()->id == 88387){

        $examcenter = Externalexamcenter::find($id);
        return view('nber.examcenter.show',compact('examcenter'));
        }
    }

    public function create(){
        return 'Closed';
        $lgstates = \App\Lgstate::all();
        $districts = \App\District::all();
        return view('nber.examcenter.create',compact('lgstates','districts'));
    }

    public function edit($id){
        return 'Closed';

        if(Auth::user()->id == 88387){
            $districts = \App\District::all();

        $examcenter = Externalexamcenter::find($id);
        $lgstates = \App\Lgstate::all();
        return view('nber.examcenter.edit',compact('examcenter','lgstates','districts'));
        }
    }

    public function store(Request $r){
        return 'Closed';

        $examcenter = Externalexamcenter::create($r->except('username','password'));
        $user = \App\User::where('username',$r->username)->first();
        if(is_null($user)){
            $user = \App\User::create([
                'username' => $r->username,
                'password' =>  Hash::make($r->password),
                'confirmed' => 0,
                'confirmation_code' => '111zzza',
                'usertype_id' => 6,
                'email' => $r->email1,
                'use_password' => null,
                'exam_id' => 27
            ]);
        }else{
            $user->password =    Hash::make($r->password);
            $user->save();         
        }
        $examcenter->user_id = $user->id;
        $examcenter->save();
        Session::flash('messages','Created');
        return view('nber.examcenter.show',compact('examcenter'));
    }

    public function update($id,Request $r){
        return 'Closed';

        $examcenter = Externalexamcenter::find($id);
        $examcenter->update($r->except('username','password'));
        $user = \App\User::where('username',$r->username)->first();
        if(!is_null($user)){
            $user->password =  Hash::make($r->password);
            $user->usertype_id = 6;
            $user->email = $r->email1;
            $user->save();     
        }else{
            $user = \App\User::create([
                'username' => $r->username,
                'password' =>  Hash::make($r->password),
                'confirmed' => 0,
                'confirmation_code' => '111zzza',
                'usertype_id' => 6,
                'email' => $r->email1,
                'use_password' => null
            ]);
        }
        $examcenter->user_id = $user->id;
        $examcenter->save();
        Session::flash('messages','Updated');
        return redirect('/nber/excenter/') ;
        
        
        return view('nber.examcenter.show',compact('examcenter'));
    }



  
    

}
