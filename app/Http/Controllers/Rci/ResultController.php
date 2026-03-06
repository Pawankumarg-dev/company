<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use DB;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
    public function index(){
        $sql = "CALL updateResultPublishProgress";
        $result  = DB::select($sql);

        $sql = "CALL getResultPublishProgress";
        $result  = DB::select($sql);
            
        $results = array_map(function ($value) {
            return (array)$value;
        }, $result); 
        
        return view('rci.reports.result',compact('results'));
    }
  
}
