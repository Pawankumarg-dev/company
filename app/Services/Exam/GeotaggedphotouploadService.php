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

   public function uploadphoto($request)
{
    $practicalexaminer_id = $this->helper->getPracticalExaminerID();
    if (!$request->hasFile('photo')) {
        Session::flash('error', 'Please choose a file');
        return false;
    }

    $file = $request->file('photo');
    if (!$file->isValid()) {
        Session::flash('error', 'Invalid file upload');
        return false;
    }
    $datetime = \Carbon\Carbon::now()->format('Ymd_His');
    $extension = $file->getClientOriginalExtension();
    $fname = $request->practicalexam_id . '_' . $datetime . '.' . $extension;
    $destination = public_path('files/geotaggedphotos');
    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }
    $pe = \App\Practicalexam::find($request->practicalexam_id);

    if (!$pe) {
        Session::flash('error', 'Invalid Practical Exam ID');
        return false;
    }

    try {
        $file->move($destination, $fname);
    } catch (\Exception $e) {
        Session::flash('error', 'Upload Failed!');
        return false;
    }
        $date = \Carbon\Carbon::now()->toDateString();

    // ✅ Save to database
    \App\Geotaggedphoto::create([
        'practicalexam_id' => $request->practicalexam_id,
        'exam_date' => $date,
        'comment' => $request->comment,
        'institute_id' => $pe->institute_id,
        'faculty_id' => $practicalexaminer_id,
        'file' => $fname
    ]);

    Session::flash('messages', 'File Uploaded Successfully');
    return true;
}
}

