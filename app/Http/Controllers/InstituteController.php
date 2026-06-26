<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

use App\Services\LocateInstitute\LocateInstituteService;


use App\Http\Requests;


use App\Lgstate;
use App\District;
use Session;
use DB;
use App\Institute;
use App\Academicyear;

class InstituteController extends Controller
{

    private $locationService;

    public function __construct(Request $r) {

        $this->locationService = new LocateInstituteService($r);
    
    }

    public function index(){
        $selected =  $this->locationService->getSelected();
        $dropdowndata = $this->locationService->getDropdownData();
        $data = $this->locationService->getData();
        return view('public.listinstitutes.index',compact(
            'selected',
            'dropdowndata',
            'data'
        ));

    }
public function data(Request $r)
{
    $states = Lgstate::all();

    $selected         = $r->input('type');
    $state_id         = $r->input('state_id');
    $course_id        = $r->input('course_id');
    $institute_id     = $r->input('institute_id');
    $academicyear_id  = $r->input('academicyear_id');

    $courses       = collect();
    $institutes    = collect();
    $candidates    = collect();
    $faculties     = collect();
    $academicyear  = collect();
    $institute_data = null;

    // 🔥 State → Courses
    if ($state_id) {
        $courses = DB::table('courses')
            ->join('programmes', 'programmes.course_id', '=', 'courses.id')
            ->join('approvedprogrammes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->where('institutes.state_id', $state_id)
            ->select('courses.id', 'courses.name')
            ->distinct()
            ->get();
    } else {
        $courses = Course::all();
    }

    // 🔥 Course → Institutes + Academic Years
    if ($course_id) {

        $institutes = DB::table('courses')
            ->join('programmes', 'programmes.course_id', '=', 'courses.id')
            ->join('approvedprogrammes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->where('courses.id', $course_id)
            ->when($state_id, function($q) use ($state_id) {
    return $q->where('institutes.state_id', $state_id);
})
            ->select('institutes.id', 'institutes.name', 'institutes.rci_code')
            ->distinct()
            ->orderBy('institutes.rci_code', 'asc')
            ->get();

        $academicyear = Academicyear::where('id', '>', 8)->get();
    }

    // 🔥 Institute → Full Data
    if ($course_id && $institute_id) {

        $institute_data = Institute::find($institute_id);

        $candidates = DB::table('candidates')
            ->join('approvedprogrammes', 'candidates.approvedprogramme_id', '=', 'approvedprogrammes.id')
            ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
            ->join('academicyears', 'approvedprogrammes.academicyear_id', '=', 'academicyears.id')
            ->where('programmes.course_id', $course_id)
            ->where('approvedprogrammes.institute_id', $institute_id)
            ->whereNull('candidates.deleted_at')
            ->where('candidates.status_id', '!=', 9)
->when($academicyear_id, function($q) use ($academicyear_id) {
    return $q->where('academicyears.id', $academicyear_id);
})            ->select('candidates.*', 'academicyears.year', 'approvedprogrammes.maxintake')
            ->get();

        $faculties = DB::table('faculties')
                   ->join('faculty_programme', 'faculty_programme.faculty_id', '=', 'faculties.id')
                               ->join('programmes', 'faculty_programme.programme_id', '=', 'programmes.id')

->where('programmes.course_id',$course_id)
            ->where('institute_id', $institute_id)->whereNull('faculties.deleted_at')
            ->get();
    }

    return view('public.listinstitutes.index1', compact(
        'selected',
        'states',
        'state_id',
        'courses',
        'course_id',
        'institutes',
        'institute_id',
        'candidates',
        'faculties',
        'academicyear',
        'academicyear_id',
        'institute_data'
    ));
}



}
