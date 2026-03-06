<?php

namespace App\Http\Controllers\Nber;

use App\Expert;
use App\Expertrciqualification;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExpertController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {

        /*
        $experts = Expert::where('stages_passed', 10)->get();

        return view('nber.examexperts.index', compact('experts'));
        */

        $experts = Expert::where('stages_passed', '>=', '6')->where('has_crr_no', 'Yes')->get();

        return view('nber.examexperts.index1', compact('experts'));
    }
}
