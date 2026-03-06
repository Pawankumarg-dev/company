<?php

namespace App\Http\Controllers\Evaluator;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Auth;
use Session;

class EvaluatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:evaluator']);
    }

    public function index(Request $r){
        return view('evaluators.index');

        
    }
}
