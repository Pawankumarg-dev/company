<?php

namespace App\Http\Controllers\Nber\Exam;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Externalexamcenter;
use App\Examcenter;

class ExamcenterStatusController extends Controller{
    public function update(Request $r){
        try{
            if($r->has('confrimation')){
                $eec = Externalexamcenter::find($r->id);
                $statuscol = "confirm_".$r->type;
                
                $eec->$statuscol = $r->confrimation;
                $eec->save();
                return response()->json('success');
            }
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
        return response()->json('failed');

    }
}
