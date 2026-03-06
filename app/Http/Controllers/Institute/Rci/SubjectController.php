<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Programmegroup;

use App\Programme;

use App\Subject;

use App\Subjecttype;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
    public function index($id){

    	$collections = Subject::where('programme_id',$id)->orderBy('syear','asc')->orderBy('subjecttype_id')->orderBy('sortorder')->paginate(10);
        $programme = Programme::find($id)->course_name;
        $pid = $id;
    	$link = 'subjects';

    	$breadcrumblinkto = 'programmes';
        $breadcrumblinktext = 'Programmes';
    	$text = ' Subjects for '. $programme;
    	$subjecttypes = Subjecttype::all();
        return view('rci.master.programmes.subjects',compact('collections','link','text','breadcrumblinkto','breadcrumblinktext','subjecttypes','pid'));
    }
    public function create(Request $request){
        echo json_encode($request->all());
    	$subject = Subject::create($request->all());
    	return back();
    }
    public function update(Request $request){
    	$sub = Subject::find($request->id);
    	$sub->update($request->except('id'));
        return back();
    }
}
