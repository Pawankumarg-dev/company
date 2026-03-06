<?php

namespace App\Http\Controllers\Nber;

use App\Coursecoordinator;
use App\Institute;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseCoordinatorController extends Controller
{
    //
    public function showCourseCoordinators() {
        $institutes = Institute::orderBy('code')->where('active_status', 1)->get(['id', 'code', 'name']);

        $coursecoordinators = Coursecoordinator::where('active_status', 1)->get();

        return view('nber.coursecoordinators.show_course_coordinators', compact('institutes', 'coursecoordinators'));
    }
}
