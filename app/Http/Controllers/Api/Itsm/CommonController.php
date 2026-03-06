<?php

namespace App\Http\Controllers\Api\Itsm;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    

    public function getusers(){
        $users = \App\User::whereIn('usertype_id',[1,2,7])->select('id','username')->get();
        return response()->json(['message' => 'success', 'users'=> $users ]);
    }

}