<?php

namespace App\Http\Controllers\Baslp;

use App\Baslpcandidate;
use App\Baslpexam;
use App\Baslpexamcenterdetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('baslp');
    }

    public function index(){

    }

    public function show_hallticket_page($e_id) {
        $exam = Baslpexam::where('id', $e_id)->first();
        $title = 'BASLP NET Exam 2019';

        return view('baslp.show_hallticket_page', compact('exam', 'title'));
    }

    public function check_roll_no(Request $request) {
        $validator = validator($request->all());

        $baslpcandidate = Baslpcandidate::where('roll_no', $request->roll_no)->first();

        $validator->after(function ($validator) use ($request, $baslpcandidate) {
            if(is_null($request->roll_no)) {
                $validator->errors()->add('roll_no', 'Please enter your Roll No.');
            }
            else {
                if(!is_null($baslpcandidate)) {
                    $baslpexamcenterdetail = Baslpexamcenterdetail::where('baslpexam_id', $request->exam_id)->where('baslpcandidate_id', $baslpcandidate->id)->first();

                    if(is_null($baslpexamcenterdetail)) {
                        $validator->errors()->add('roll_no', 'Please enter your valid Roll No.');
                    }
                }
                else {
                    $validator->errors()->add('roll_no', 'Please enter your valid Roll No.');
                }
            }
        });
        $this->validateWith($validator);

        $baslpexamcenterdetail = Baslpexamcenterdetail::where('baslpexam_id', $request->exam_id)->where('baslpcandidate_id', $baslpcandidate->id)->first();

        return redirect('baslp-exam/download-candidate-hallticket/'.$baslpexamcenterdetail->id);
    }
}
