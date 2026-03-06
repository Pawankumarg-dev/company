<?php

namespace App\Http\Controllers\Examcenter\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

use App\Examattendancesheet;

use App\Services\Common\HelperService;

class AttendancesheetController extends Controller
{
    private $helper;
    private $exam_id;
    public function __construct()
    {
        $this->middleware(['role:examcenter']);
        $this->helper = new HelperService;
        $this->exam_id = $this->helper->getScheduledExamID();
        $this->exam_id = 27;
    }

    public function store(Request $r){
//        return '';
        $file = $r->filename;
        $ex = explode('.', $file);
        $extn = end($ex);
        $fname = $this->exam_id.'_'.$r->approvedprogramme_id. "." . $r->exampaper_id;
        $destination = public_path()."/files/examattendancefiles/".$fname;
        move_uploaded_file( $file, $destination);
        $exists = Examattendancesheet::where('approvedprogramme_id',$r->approvedprogramme_id)
                                        ->where('subject_id',$r->subject_id)
                                        ->where('exam_id',$this->exam_id)
                                        ->first();
        if(is_null($exists)){
            Examattendancesheet::create([
                'approvedprogramme_id' => $r->approvedprogramme_id,
                'subject_id' => $r->subject_id,
                'filename' => $fname,
                'exam_id' => $this->exam_id
            ]);
        }else{
            $exists->filename = $fname;
            $exists->save();
        }
        $exampaper = \App\Allexampaper::find($r->exampaper_id);
        $exampaper->scan_copy = 1;
        $exampaper->filename = $fname;
        $exampaper->save();
        Session::put('messages','Uploaded');
        return back();
    }
}