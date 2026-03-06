<?php

namespace App\Http\Controllers\Evaluation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

use App\Examattendancesheet;

class AttendancesheetController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:evaluationcenter']);

    }

    public function store(Request $r){
 //       return "Closed";
//        return '';
        $file = $r->filename;
        $ex = explode('.', $file);
        $extn = end($ex);
        $fname = '25_'.$r->approvedprogramme_id. "." . $r->exampaper_id;
        $destination = public_path()."/files/examattendancefiles/".$fname;
        move_uploaded_file( $file, $destination);
        $exists = Examattendancesheet::where('approvedprogramme_id',$r->approvedprogramme_id)
                                        ->where('subject_id',$r->subject_id)
                                        ->where('exam_id',25)
                                        ->first();
        if(is_null($exists)){
            Examattendancesheet::create([
                'approvedprogramme_id' => $r->approvedprogramme_id,
                'subject_id' => $r->subject_id,
                'filename' => $fname,
                'exam_id' => 25
            ]);
        }else{
            $exists->filename = $fname;
            $exists->save();
        }
        $exampaper = \App\Exampaper::find($r->exampaper_id);
        $exampaper->scan_copy = 1;
        $exampaper->filename = $fname;
        $exampaper->save();
        Session::put('messages','Uploaded');
        return back();
    }
}
