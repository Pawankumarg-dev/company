<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Http\Requests;

use App\Institute;
use App\Candidate;

class SearchController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
	
	 public function search(Request $request){
    	$institutes = Institute::whereHas('user',function($q) use($request){
            $q->where('username','like','%'.$request->key.'%');
        })->orWhere('name','like','%'.$request->key.'%');
        $candidates = Candidate::where('enrolmentno','like','%'.$request->key.'%')->orWhere('name','like','%'.$request->key.'%');

        $icount = $institutes->count();
        $ccount = $candidates->count();
        if( $icount == 1 && strtolower($institutes->first()->user->username) == strtolower($request->key)){
            return redirect('/institute/'.$institutes->first()->id);
        }
        if( $ccount == 1 && strtolower($candidates->first()->enrolmentno) == strtolower($request->key)){
            return redirect('/candidate/'.$candidates->first()->id);
        }
        
            $institutes = $institutes->paginate(8);
            $candidates = $candidates->paginate(8);
            $text = 'Search Result';
            $key = $request->key;
            return view('nber.search.index',compact('institutes','candidates','key'));
        


    //	return view('nber.institutes.index',compact('institutes'));
    }
	public function show($id){
    	$institute = Institute::find($id);
    	return view('nber.institutes.show',compact('institute'));
    }
	
}
