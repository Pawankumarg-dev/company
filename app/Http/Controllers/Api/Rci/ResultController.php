<?php

namespace App\Http\Controllers\Api\Rci;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ResultController extends Controller
{
    

    public function index(Request $r){

        if($r->has('all')){
            $sql = "CALL getPendingMarkEntryAllNBERs";
            $results  = DB::select($sql);
            return response()->json(['message' => 'success', 'results'=> $results ]);    
        }
        $sql = "CALL updateResultPublishProgress";
        $result  = DB::select($sql);

        $sql = "CALL getResultPublishProgress";
        $results  = DB::select($sql);
            
        return response()->json(['message' => 'success', 'results'=> $results ]);
    }

    public function show($id){

        $sql = "CALL getPendingMarkEntry(".$id.")";
        $results  = DB::select($sql);
            
        return response()->json(['message' => 'success', 'results'=> $results ]);
    }

}