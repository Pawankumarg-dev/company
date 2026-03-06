<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Academicyear;
use App\Programme;
use App\Incidentalfee;
use App\Masterlist;
use Session;

class AcademicyearController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function changeayid($id){
        $academicyear= Academicyear::find($id);
        $academicyearname = $academicyear->year;
        Session::put('academicyear',$academicyearname);
        Session::put('academicyear_id',$id);
        return back();
    }
}
