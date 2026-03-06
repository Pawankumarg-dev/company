<?php

namespace App\Http\Controllers\Nber\Examcenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Statezone;
use App\Statedistrict;

use App\Http\Requests\Exam\StoreExamcenterRequest;
use App\Http\Requests\Exam\UpdateExamcenterRequest;

use Session;

class ZoneController extends Controller
{

    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index(){
        $districts = Statedistrict::all();
        return view('nber.examcenter.zone.index',
            compact(
                'districts'
            )
        );
    }


    public function edit($id){
        $district = Statedistrict::find($id);
        $statezones = Statezone::all();
        return view('nber.examcenter.zone.edit',
            compact(
                'district',
                'statezones'
            )
        );
    }

    public function update($id,Request $r){
        $district = Statedistrict::find($id);
        $district->statezone_id = $r->statezone_id;
        $district->save();
        Session::flash('messages','Updated');
        return back();
    }

}
