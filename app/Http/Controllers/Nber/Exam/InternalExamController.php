<?php

namespace App\Http\Controllers\Nber\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;

class InternalExamController extends Controller
{
    public function index(){
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        $institutes = collect(DB::table('institutes')
        ->select(
            'institutes.id',
            'institutes.name',
            'institutes.rci_code',
            'courses.name as course_name',
            'academicyears.year as academic_year',
            'academicyears.id as academic_id',
            'approvedprogrammes.id as approvedprogramme_id'
        )
        ->join('approvedprogrammes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
        ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
        ->join('academicyears', 'approvedprogrammes.academicyear_id', '=', 'academicyears.id')
        ->join('courses', 'courses.id', '=', 'programmes.course_id')
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->where('approvedprogrammes.academicyear_id', '>', 8)
                    ->where('programmes.numberofterms', '=', 2);
            })->orWhere(function ($q) {
                $q->where('approvedprogrammes.academicyear_id', '>', 9)
                    ->where('programmes.numberofterms', '=', 1);
            });
        })
        ->where('institutes.id', '<>', 1004)
        ->where('programmes.nber_id', $nber_id)
        ->whereNULL('programmes.deleted_at')

        ->get())->groupBy('id');
//return $institutes;
    return view('nber.exam.internal.index', compact('institutes'));

    }


    public function attandance_internal(Request $request){
       // echo $approvedprogramme_id = $request['approvedprogramme_id'];
        // $instituteId = $request['institute_id'];
        // $academicYear = $request['academic_year'];








//die();
        return view('nber.exam.internal.attandance-internal', compact('institutes'));

    }
}
