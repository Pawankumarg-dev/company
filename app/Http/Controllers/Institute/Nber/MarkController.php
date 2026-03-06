<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Http\Requests;

use Auth;
use Session;
use Image;
use App\Mark;

class MarkController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function markabsent($mid,$inex){
        $mark = Mark::where('application_id',$mid);
        $user = Auth::user()->id;
        if($mark->count()>0){
            if($inex=='EX'){
                $mark->update(['external'=>'Abs', 'mark_entered_by'=>$user]) ;
            }else{
                $mark->update(['internal'=>'Abs']) ;
            }
        }else{
            if($inex=='EX'){
                Mark::create(['application_id'=>$mid,'external'=>'Abs', 'mark_entered_by'=>$user]);
            }else{
                Mark::create(['application_id'=>$mid,'internal'=>'Abs']);
            }
        }
        return back();
    }

    public function update(Request $r){
        $mark = Mark::where('application_id',$r->aid);
        $user = Auth::user()->id;

        if($mark->count()>0){
            if($r->inex=='EX'){
                $mark->update(['external'=>$r->mark, 'mark_entered_by'=>$user]) ;
            }else{
                if($r->inex=='GR'){
                    $mark->update(['grace'=>$r->mark]);
                }else{
                    $mark->update(['internal'=>$r->mark]) ;
                }
            }
        }else{
            if($r->inex=='EX'){
                Mark::create(['application_id'=>$r->aid,'external'=>$r->mark, 'mark_entered_by'=>$user]);
            }else{
                if($r->inex=='GR'){

                }else{
                    Mark::create(['application_id'=>$r->aid,'internal'=>$r->mark]);
                }
            }
        }
        return $r->inex.'_'.$r->cid."_".$r->sid;
        
    }
}