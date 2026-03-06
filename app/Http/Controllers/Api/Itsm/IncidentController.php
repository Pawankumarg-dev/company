<?php

namespace App\Http\Controllers\Api\Itsm;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index(){

    }

    public function store(Request $r){
        $incident = json_decode($r->incident);
        
        \App\Itsmincident::create([
            'issue' => $incident->issue,
            'description' => $incident->description,
            'solution' => $incident->solution,
            'user_id' => $incident->user_id->id,
            'itsmincidentstatus_id' => $incident->itsmincidentstatus_id,
            'reported_on' => $incident->reported_on,
            'resolved_on' => $incident->resolved_on
        ]);
        return response()->json(['message' => 'success' ]);

    }

}