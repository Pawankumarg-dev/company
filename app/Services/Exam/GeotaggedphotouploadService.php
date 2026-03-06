<?php

namespace App\Services\Exam;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use App\Services\Common\HelperService;
class GeotaggedphotouploadService
{
    private $helper;


    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
    }

    public function uploadphoto($request){
        $practicalexaminer_id = $this->helper->getPracticalExaminerID();
        $file = $request->photo;
        if(!is_file($file)){
            Session::flash('error','Plese choose a file');
            return false;
        }
        $datetime = \Carbon\Carbon::now()->toDateTimeString();
      //  $date = \Carbon\Carbon::now()->toDateString();
        $date = Session::get('date');
        $fname = $request->practicalexam_id.'_'.$datetime;
        $destination = public_path()."/files/geotaggedphotos/".$fname;
        $pe = \App\Practicalexam::find($request->practicalexam_id);

        try{
            move_uploaded_file( $file, $destination);
        }catch(Exception $e){
            Session::flash('error','Upload Failed!');
            return false;
        }
        \App\Geotaggedphoto::create([
            'practicalexam_id' => $request->practicalexam_id,
            'exam_date' => $date,
            'comment' => $request->comment,
            'institute_id' => $pe->institute_id,
            'faculty_id' => $practicalexaminer_id,
            'file' => $fname
        ]);
        Session::flash('messages','File Uploaded');
        return true;
    }
}

