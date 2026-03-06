<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Programme;

use App\Institute;

use \Auth;

use DB;

use App\Approvedprogramme;

use App\Subject;

use App\Application;

use App\Currentapplication;

use App\Markentry;

use App\Exam;

use App\Oldapplicant;

use App\Currentapplicant;

use App\Newapplication;


use Session;

class BacklogController extends Controller
{


    public function __construct()
    {
       $this->middleware(['role:nber']);

    }
    public function addsubject(Request $r){
                 return back();

        if(Auth::user()->id == 99540 || Auth::user()->id == 88387){
            $table = 'currentapplication_id';
            if($r->exam_id != 22){
                $table = 'application_id';
            }
            if($r->exam_id == 25){
                $table = 'newapplication_id';
            }


            if($r->exam_id > 25){
                $table = 'allapplication_id';
 $application = \App\Allapplication::create([
                            'candidate_id' => $r->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id' => $r->subject_id,
                            'applicant_id' => $r->applicant_id
                        ]);
                        $old_mark = null;
                        $newdata = null;
                        \App\Changemarkaudit::create([
                                                    'ip_address' =>$_SERVER["REMOTE_ADDR"],

                            'candidate_id' => $application->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id'=> $application->subject_id,
                            $table => $application->id,
                            'old_mark' => $old_mark,
                            'new_mark' => $newdata,
                            'markorattendance' => 'New Entry',
                            'user_id' => Auth::user()->id,
                            'inex' => 'New',
                            'editornew' => 'Subject New Entry'
                        ]);
                        Session::flash('messages','Subject is added');



                return back();




            }






            $candidate = \App\Candidate::find($r->candidate_id);
            if($r->exam_id == 22){
                $application = \App\Currentapplication::where('candidate_id',$r->candidate_id)
                                ->where('currentapplicant_id',$r->applicant_id)
                                ->where('subject_id',$r->subject_id)
                                ->first();
                $ca = \App\Currentapplicant::find($r->applicant_id);

                if(is_null($ca) || $ca->candidate_id != $r->candidate_id){
                    Session::flash('error','Something went wrong! (Old Applications)');
                }
                if(!is_null($application)){



                    Session::flash('error','Already exists');
                }else{
                    $application = Currentapplication::create([
                        'candidate_id' => $r->candidate_id,
                        'exam_id' => $r->exam_id,
                        'subject_id' => $r->subject_id,
                        'internalattendance_id' => 1,
                        'externalattendance_id' => 1,
                        'internal_mark' => 0,
                        'external_mark' => 0,
                        'approvedprogramme_id' => $candidate->approvedprogramme_id,
                        'term' => $r->term,
                        'language_id' => 2,
                        "payment_status" => "Not Entered",
                        "active_status" => 1,
                        "status_id" => 6,
                        "linkopen_number" => 1,
                        "penalty" => "No",
                        "externalexamcenter_id" => 1,
                        'currentapplicant_id' => $r->applicant_id
                    ]);
                    $old_mark = null;
                    $newdata = null;
                    \App\Changemarkaudit::create([
                        'ip_address' =>$_SERVER["REMOTE_ADDR"],
                        'candidate_id' => $r->candidate_id,
                        'exam_id' => $r->exam_id,
                        'subject_id'=> $application->subject_id,
                        $table => $application->id,
                        'old_mark' => $old_mark,
                        'new_mark' => $newdata,
                        'markorattendance' => 'New Entry',
                        'user_id' => Auth::user()->id,
                        'inex' => 'New',
                        'editornew' => 'New Entry'
                    ]);
                    Session::flash('messages','Subject is added');
                } 
            }else{
                if($r->exam_id < 22 || $r->exam_id == 23){
                    $application = \App\Application::where('candidate_id',$r->candidate_id)
                                    ->where('applicant_id',$r->applicant_id)
                                    ->where('subject_id',$r->subject_id)
                                    ->where('exam_id',$r->exam_id)
                                    ->first();

                    $ca = \App\Oldapplicant::find($r->applicant_id);
                    if(is_null($ca) || $ca->candidate_id != $r->candidate_id){
                        Session::flash('error','Something went wrong! (Before 2023)');
                    }
                    if(!is_null($application)){
                        Session::flash('error','Already exists');
                    }else{
                        $application = \App\Application::create([
                            'candidate_id' => $r->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id' => $r->subject_id,
                            'internalattendance_id' => 1,
                            'externalattendance_id' => 1,
                            'internal_mark' => 0,
                            'external_mark' => 0,
                            'approvedprogramme_id' => $candidate->approvedprogramme_id,
                            'term' => $r->term,
                            'language_id' => 2,
                            "payment_status" => "Not Entered",
                            "active_status" => 1,
                            "status_id" => 6,
                            "linkopen_number" => 1,
                            "penalty" => "No",
                            "externalexamcenter_id" => 1,
                            'applicant_id' => $r->applicant_id
                        ]);
                        $old_mark = null;
                        $newdata = null;
                        \App\Changemarkaudit::create([
                                                    'ip_address' =>$_SERVER["REMOTE_ADDR"],

                            'candidate_id' => $application->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id'=> $application->subject_id,
                            $table => $application->id,
                            'old_mark' => $old_mark,
                            'new_mark' => $newdata,
                            'markorattendance' => 'New Entry',
                            'user_id' => Auth::user()->id,
                            'inex' => 'New',
                            'editornew' => 'New Entry'
                        ]);
                        Session::flash('messages','Subject is added');
                    }
                }else{
                    $application = \App\Newapplication::where('candidate_id',$r->candidate_id)
                    ->where('newapplicant_id',$r->applicant_id)
                    ->where('subject_id',$r->subject_id)
                    ->first();

                    $ca = \App\Newapplicant::find($r->applicant_id);
                    if(is_null($ca) || $ca->candidate_id != $r->candidate_id){
                       // Session::flash('error','Something went wrong!');
                    }
                    if(!is_null($application)){
                        Session::flash('error','Already exists');
                    }else{
                        $application = \App\Newapplication::create([
                            'candidate_id' => $r->candidate_id,
                            //'exam_id' => $r->exam_id,
                            'subject_id' => $r->subject_id,
                            'internalattendance_id' => 1,
                            'externalattendance_id' => 1,
                            'internal_mark' => 0,
                            'external_mark' => 0,
                          //  'approvedprogramme_id' => $candidate->approvedprogramme_id,
                         //   'term' => $r->term,
                         //   'language_id' => 2,
                           // "payment_status" => "Not Entered",
                         //  "active_status" => 1,
                          //  "status_id" => 6,
                            //"linkopen_number" => 1,
                            //"penalty" => "No",
                            "externalexamcenter_id" => 1,
                            'newapplicant_id' => $r->applicant_id
                        ]);
                        $old_mark = null;
                        $newdata = null;
                        \App\Changemarkaudit::create([
                                                    'ip_address' =>$_SERVER["REMOTE_ADDR"],

                            'candidate_id' => $application->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id'=> $application->subject_id,
                            $table => $application->id,
                            'old_mark' => $old_mark,
                            'new_mark' => $newdata,
                            'markorattendance' => 'New Entry',
                            'user_id' => Auth::user()->id,
                            'inex' => 'New',
                            'editornew' => 'New Entry'
                        ]);
                        Session::flash('messages','Subject is added');
                    }
                }

            }
        }
        return back();
    }

    public function adddocument(Request $r){
                return back();

        if(Auth::user()->id == 88387){

            $randomString = uniqid(time(), true). $r->exam_id . $r->term . $r->subjecttype_id;

            $image = $r->file('document');
            $imageName = $randomString . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files/nber/marksedit'), $imageName);
            
            \App\Markchange::create([
                'candidate_id' => $r->candidate_id,
                'user_id' => Auth::user()->id,
                'document' => $imageName,
                'exam_id' => $r->exam_id,
                'subjecttype_id' => $r->subjecttype_id,
                'term' => $r->term
            ]);
            Session::flash('messages','Uploaded');
        }
        return back();
    }






    public function delete(Request $r){
               

        if(Auth::user()->id==87567){
            $exam_id = $r->exam_id;
            if($exam_id == '22'){
                $application = Currentapplication::find($r->id);
            }else{
                if($exam_id == '24'){
                    $application = \App\Supplimentaryapplication::find($r->id);
                }else{
                           if($exam_id == '26'){    
                                $application = \App\Allapplication::find($r->id);
                           }else{
                            $application = Application::find($r->id);
                           }
                }
            }
            $table = 'currentapplication_id';
            // if($exam_id != 22){
            //     $table = 'application_id';
            // }
            $application->delete();
            \App\Changemarkaudit::create([
                                        'ip_address' =>$_SERVER["REMOTE_ADDR"],

                'candidate_id' => $application->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id'=> $application->subject_id,
                $table => $r->id,
                'old_mark' => 0,
                'new_mark' => 0,
                'markorattendance' => 'Delete',
                'user_id' => Auth::user()->id,
                'inex' => 0,
                'editornew' => 'Delete',
                'status'=> 1
            ]);
            return response()->json(['Status'=>'Success','exam_id'=>$r->exam_id,'id'=>$r->id]);
        }
        //addreturn 'Not availble';
        
    }

public function mark_change_request(Request $r){
 
           

        if(Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387){
    $application = 1;
            $exam_id = $r->exam_id;
            if($exam_id == '22'){
                $application = Currentapplication::find($r->id);
            }else{
                if($exam_id == '25'){
                    $application = \App\Newapplication::find($r->id);
                    //return $application;
                   // return $application;
                }else{
                    if($exam_id == '24'){
                        $application = \App\Supplimentaryapplication::find($r->id);
                    }else{
                        if($exam_id == '26' || $exam_id == '27'){

                            $application = \App\Allapplication::find($r->id);


                        }else{
                            $application = Application::find($r->id);
                        }
                        
                    }
                }
            }
            
        $nber_id = Auth::user()->nberstaffs->first()->nber_id;


        $candidate = \App\Candidate::find($application->candidate_id);
 if($candidate->approvedprogramme->programme->nber_id != $nber_id){
                                return back();

        }



       \App\Changemarrequest::create([
                    'ip_address' =>$_SERVER["REMOTE_ADDR"],
                    'application_id' =>$r->id,
                    'exam_id' =>$r->exam_id,
                    'newdata' =>$r->newdata,
                    'edit' =>$r->edit,
                    'inex' =>$r->inex,
                   'candidate_id' => $application->candidate_id,
                    'user_id' => Auth::user()->id,
                   'candidate_id' => $application->candidate_id,
                    'nber_id' => $nber_id,
                                        'subject_id'=> $application->subject_id,

                                        'status' => 1,

                ]);

            return response()->json(['Status'=>'Success','exam_id'=>$r->exam_id,'id'=>$r->id,'newdata'=>$r->newdata]);

}
else{
            return 'Closed';

                    return back();

}
}

public function updatedata_cancel(Request $r){

    \App\Changemarrequest::where('application_id', $r->id)->where('exam_id', $r->exam_id)  // or any condition
    ->update([
        'status' => 3,
    ]);

            return response()->json(['Status'=>'Success']);

}












    public function updatedata(Request $r){
       // return $r->exam_id;
            //    return back();

$check = \App\Allapplication::where('id', $r->id)->where('exam_id', 27)->first();

// if ($check->id==$r->id) {

\App\Changemarrequest::where('application_id', $r->id)->where('exam_id', $r->exam_id)->where('inex',$r->inex)->where('status',1)->where('edit',$r->edit)  // or any condition
    ->update([
        'status' => 2,
    ]);



        if(Auth::user()->id == 88387 || Auth::user()->id != 88387){
            $application = 1;
            $exam_id = $r->exam_id;
            if($exam_id == '22'){
                $application = Currentapplication::find($r->id);
            }else{
                if($exam_id == '25'){
                    $application = \App\Newapplication::find($r->id);
                    //return $application;
                   // return $application;
                }else{
                    if($exam_id == '24'){
                        $application = \App\Supplimentaryapplication::find($r->id);
                    }else{
                        if($exam_id == '26' || $exam_id == '27'){


                            $application = \App\Allapplication::find($r->id);


                        }else{
                            $application = Application::find($r->id);
                        }
                        
                    }
                }
            }
            $table = 'currentapplication_id';
            // if($exam_id != 22){
            //     if($exam_id < 22){
            //         $table = 'application_id';
            //     }else{
            //         if($exam_id == 24){
            //             $table = 'supplimentaryapplication_id';
            //         }else{
            //             if($exam_id == 25){
            //                 $table = 'newapplication_id';
            //             }
            //         }
            //     }
            // }
            if($r->edit=='Attendance'){
                if($r->inex=='In'){
                     if($exam_id == '26' || $exam_id == '27'){
                        $application->attendance_in = $r->newdata;
                        }else{
                            $application->internalattendance_id = $r->newdata;;
                        }

                    
                }else{
                     if($exam_id == '26' || $exam_id == '27'){
                        $application->attendance_ex = $r->newdata;
                        }else{
                            $application->externalattendance_id = $r->newdata;;
                        }
                }
                $application->save();
                $old_mark = 1;
                if($r->internalattendance_id == 1){
                    $old_mark = 2;
                }
                \App\Changemarkaudit::create([
                    'ip_address' =>$_SERVER["REMOTE_ADDR"],
                   'candidate_id' => $application->candidate_id,
                            'exam_id' => $r->exam_id,
                            'subject_id'=> $application->subject_id,
                    $table => $r->id,
                    'old_mark' => $old_mark,
                    'new_mark' => $r->newdata,
                    'markorattendance' => 'Attendance',
                    'user_id' => Auth::user()->id,
                    'inex' =>$r->inex,
                    'editornew' => 'Edit'
                ]);
            }
        
            if($r->edit=='Mark'){
                if($r->inex=='In'){
                    if($exam_id == '26' || $exam_id == '27'){
                    $old_mark = $application->mark_in ;
                    $application->mark_in = $r->newdata;
                    }else{
                    $old_mark = $application->internal_mark ;
                    $application->internal_mark = $r->newdata;
                    }




                }else{
                    if($r->inex=='Gr'){
                        $old_mark = $application->grace ;
                        $application->grace = $r->newdata;
                    }else{



                          if($exam_id == '26' || $exam_id == '27'){
                     $old_mark = $application->mark_ex ;
                        $application->mark_ex = $r->newdata;
                    }else{
                        $old_mark = $application->external_mark ;
                        $application->external_mark = $r->newdata;
                    }


                        
                        if($exam_id ==22){
                            $application->reevaluation_mark = $r->newdata;
                        }
                    }
                }
                // result_id
                $subject = \App\Subject::find($application->subject_id);
                if($exam_id ==22){
                    if(
                            (($application->internal_mark >= $subject->imin_marks) || $subject->is_internal ==0 ) 
                            && 
                            ($subject->is_external == 0 || ($application->reevaluation_mark + $application->grace) >= $subject->emin_marks)){
                        $application->result_id = 1;
                        if($exam_id ==22){
                            $application->reevaluation_result_id = 1;
                        }
                    }else{
                        $application->result_id = 0;
                        if($exam_id ==22){
                            $application->reevaluation_result_id = 0;
                        }
                    }
                }else{



                    if(
                        (($application->internal_mark >= $subject->imin_marks) || $subject->is_internal ==0 ) 
                        && 
                        ($subject->is_external == 0 || ($application->external_mark + $application->grace) >= $subject->emin_marks)){
                    $application->result_id = 1;
                    }else{
                                    if(
                        (($application->mark_in >= $subject->imin_marks) || $subject->is_internal ==0 ) 
                        && 
                        ($subject->is_external == 0 || ($application->mark_ex + $application->grace) >= $subject->emin_marks)){

                    $application->result_id = 1;
                    }else{
                        $application->result_id = 0;
                    }
                    }
                }
                
                $application->save();
                
                \App\Changemarkaudit::create([
                                            'ip_address' =>$_SERVER["REMOTE_ADDR"],

                    'candidate_id' => $application->candidate_id,
                    'exam_id' => $r->exam_id,
                    'subject_id'=> $application->subject_id,
                    $table => $r->id,
                    'old_mark' => $old_mark,
                    'new_mark' => $r->newdata,
                    'markorattendance' => 'Mark',
                    'user_id' => Auth::user()->id,
                    'inex' =>$r->inex,
                    'editornew' => 'Edit'
                ]);
            }
            
            return response()->json(['Status'=>'Success','exam_id'=>$r->exam_id,'id'=>$r->id,'newdata'=>$r->newdata]);
        }else{
            return 'Not available';
        }
    
    }

    public function missingdata(){
        return '';
        $data = DB::select('
        select 
            i.rci_code,
            i.name as institute,
            ap.academicyear_id,
            y.year, 
            s.syear, 
            c.enrolmentno,
            c.name,
            ca.candidate_id, 
            count(subject_id) as no_of_subjects,
            group_concat(subject_id) as subjects
        from currentapplications ca
        left join approvedprogrammes ap on ap.id = ca.approvedprogramme_id
        left join subjects s on s.id = ca.subject_id
        left join candidates c on c.id = ca.candidate_id
        left join institutes i on i.id = ap.institute_id
        left join academicyears y on y.id = ap.academicyear_id
        where ap.programme_id = 36
        group by ca.candidate_id, s.`syear`
        having  (s.syear = 2 and  no_of_subjects < 15 and ap.academicyear_id = 9 ) or(s.syear = 1 and  no_of_subjects < 13 and ap.academicyear_id = 10) ;'
);
             $subject1 = Subject::where('programme_id',36)->where('syear',1)->get();
             $subject2 = Subject::where('programme_id',36)->where('syear',2)->get();
             return view('reports.ayj',compact('data','subject1','subject2'));
    }
	
	public function index(Request $r){
        $nber_id = Auth::user()->nberstaffs->first()->nber_id;
        $programme_ids = Programme::where('nber_id',$nber_id)->pluck('id');
        $exam = Exam::find(Session::get('exam_id'));
        if($exam->id < 25){
            if($nber_id == 1){
                $ap_ids = Approvedprogramme::whereIn('programme_id',$programme_ids)->where('academicyear_id','<=',$exam->academicyear_id)->pluck('id')->unique();
                if($exam->id == 22){
                    $ap_ids_filtered= Currentapplicant::whereIn('approvedprogramme_id',$ap_ids)->pluck('approvedprogramme_id')->unique();    
                }else{
                    $ap_ids_filtered= Oldapplicant::where('exam_id',$exam->id)->whereIn('approvedprogramme_id',$ap_ids)->pluck('approvedprogramme_id')->unique();    
                }
                $institute_ids = Approvedprogramme::whereIn('id',$ap_ids_filtered)->whereIn('programme_id',$programme_ids)->where('academicyear_id','<=',$exam->academicyear_id)->pluck('institute_id')->unique();
            }else{
                $institute_ids = Approvedprogramme::whereIn('programme_id',$programme_ids)->where('academicyear_id','<=',$exam->academicyear_id)->pluck('institute_id')->unique();
            }
        }else{
            if($nber_id != 4){
                $apids= \App\Newapplicant::pluck('approvedprogramme_id')->unique();    
                // $institute_ids = Approvedprogramme::whereIn('programme_id',$programme_ids)->whereIn('id',$apids)->pluck('institute_id')->unique();
                $institute_ids = Approvedprogramme::whereIn('programme_id',$programme_ids)->pluck('institute_id')->unique();
            }else{
                // $institute_ids = Approvedprogramme::where('programme_id',57)->where('academicyear_id','<=',12)->pluck('institute_id')->unique();
                //return $institute_ids;
                                $institute_ids = Approvedprogramme::whereIn('programme_id',$programme_ids)->pluck('institute_id')->unique();

            }
        }
        
        $institutes = Institute::whereIn('id',$institute_ids)->orderBy('rci_code')->get();
        return view('nber.backlog.index',compact('institutes'));
    }

    public function listcourses($id){
        
        $institute = Institute::find($id);
        $exam = Exam::find(Session::get('exam_id'));
        $academicyear_id = $exam->academicyear_id;
        if($exam->id < 26){
            $apids= \App\Newapplicant::pluck('approvedprogramme_id')->unique(); 
            
            
            $approvedprogrammes = Approvedprogramme::where('institute_id',$id)->orderBy('academicyear_id','desc')->get();
        }else{
            $approvedprogrammes = Approvedprogramme::where('institute_id',$id)->where('academicyear_id','>',8)->orderBy('academicyear_id','desc')->get();
        }
        
        
        
        $nber_id = Auth::user()->nberstaffs->first()->nber_id;
            return view('nber.backlog.listcourses',compact('approvedprogrammes','nber_id','institute','academicyear_id'));
       
    }

    public function listsubjects($apid){
        return 'Closed';
        $ap  = Approvedprogramme::find($apid);
        $pid = $ap->programme_id;
        $nber_id = Auth::user()->nberstaffs->first()->nber_id;
        $exam_id = Session::get('exam_id');
        $subjects  = Subject::where('programme_id',$pid)->orderBy('syear')->orderBy('subjecttype_id')->orderBy('sortorder')->get();
        $markentries  =  Markentry::where('exam_id',$exam_id)->where('approvedprogramme_id',$apid)->first();
        return view('nber.backlog.listsubjects',compact('subjects','ap','nber_id','markentries'));
    }

    public function termwise($id,$term){
        $ap  = Approvedprogramme::where('id',$id)->first();
        $exam_id = Session::get('exam_id');
        if($exam_id == 22){
            $applicant_ids = $ap->applicants()->pluck('candidate_id');
            $applications = Currentapplication::select('id', 'candidate_id','subject_id','internal_mark','external_mark','internalattendance_id','externalattendance_id','grace')->whereIn('candidate_id',$applicant_ids)->get()->toArray();
            $applicants = $ap->applicants()->get();
        }else{
            if($exam_id==25){
                $applicant_ids = $ap->newapplicants()->pluck('id');
                $applications = Newapplication::select('id', 'candidate_id','subject_id','internal_mark','external_mark','internalattendance_id','externalattendance_id','grace')->whereIn('newapplicant_id',$applicant_ids)->get()->toArray();
                $applicants = $ap->newapplicants()->where('exam_id',$exam_id)->get();
            }else{
            
                if($exam_id == 26){
                    // $applicant_ids = $ap->oldapplicants()->where('exam_id',$exam_id)->pluck('id');
                    // $applications = Application::select('id', 'candidate_id','subject_id','internal_mark','external_mark','internalattendance_id','externalattendance_id','grace')->whereIn('applicant_id',$applicant_ids)->get()->toArray();
                    // $applicants = $ap->oldapplicants()->where('exam_id',$exam_id)->get();
                    $applications = \App\Allapplication::select('id', 'candidate_id','subject_id','mark_in as internal_mark','mark_ex as external_mark','attendance_in as internalattendance_id','attendance_ex as externalattendance_id','grace')
                    ->where('exam_id',26)->whereHas('candidate',function($q) use($id){
                        $q->where('approvedprogramme_id',$id);
                    })->whereHas('subject',function($r) use($term){
                        $r->where('syear',$term);
                    })->get()->toArray();
                    $applicants = \App\Allapplicant::where('exam_id',26)->whereHas('candidate',function($q) use($id){
                        $q->where('approvedprogramme_id',$id);
                    })->get();
                }if($exam_id == 27){
                   
                    $applications = \App\Allapplication::select('id', 'candidate_id','subject_id','mark_in as internal_mark','mark_ex as external_mark','attendance_in as internalattendance_id','attendance_ex as externalattendance_id','grace')
                    ->where('exam_id',27)->whereHas('candidate',function($q) use($id){
                        $q->where('approvedprogramme_id',$id);
                    })->whereHas('subject',function($r) use($term){
                        $r->where('syear',$term);
                    })->get()->toArray();
                    $applicants = \App\Allapplicant::where('exam_id',27)->whereHas('candidate',function($q) use($id){
                        $q->where('approvedprogramme_id',$id);
                    })->get();
                }else{
                    $applicant_ids = $ap->oldapplicants()->where('exam_id',$exam_id)->pluck('id');
                    $applications = Application::select('id', 'candidate_id','subject_id','internal_mark','external_mark','internalattendance_id','externalattendance_id','grace')->whereIn('applicant_id',$applicant_ids)->get()->toArray();
                    $applicants = $ap->oldapplicants()->where('exam_id',$exam_id)->get();
                }
            }
        }
        //return $applications;
        $pid = $ap->programme_id;
        $subjects  = Subject::where('programme_id',$pid)
                        ->where('syear',$term)
                        ->orderBy('syear')
                        ->orderBy('subjecttype_id')
                        ->orderBy('sortorder')
                        ->get();       
        return view('nber.backlog.termwise',compact('subjects','ap','applications','term','applicants','exam_id')) ;
    }

    public function marks($apid,$sid){
        $approvedprogramme  = Approvedprogramme::find($apid);
        $subject = Subject::find($sid);
        return view('nber.backlog.markentry',compact('approvedprogramme','subject'));
    }

    public function editmarks($apid,$sid){
        $approvedprogramme  = Approvedprogramme::find($apid);
        $subject = Subject::find($sid);
        $applications = DB::select('select a.candidate_id as id, c.name, c.enrolmentno, a.internalattendance_id, a.externalattendance_id, a.internal_mark, a.external_mark from applications a 
        left join candidates c on c.id = a.candidate_id 
        left join subjects s on s.id = a.subject_id  where subject_id = '. $sid.' and a.approvedprogramme_id ='.$apid);
        return view('nber.backlog.editmarkentry',compact('approvedprogramme','subject','applications'));
    }

    public function view($apid,$sid){
        $exam_id = Session::get('exam_id');
        if($exam_id==22){
            $applications = Currentapplication::where('approvedprogramme_id',$apid)
            ->where('subject_id',$sid)
            ->where('exam_id',$exam_id)
            ->get();
        }else{
            $applications = Application::where('approvedprogramme_id',$apid)
            ->where('subject_id',$sid)
            ->where('exam_id',$exam_id)
            ->get();
        }
                    
        $subject = Subject::find($sid);
        $approvedprogramme  = Approvedprogramme::find($apid);
        return view('nber.backlog.view',compact('approvedprogramme','subject','applications'));
    }


  

    public function save(Request $r){
        //return 'Closed';
        $approvedprogramme  = Approvedprogramme::find($r->approvedprogramme_id);
        $exam_id = Session::get('exam_id');
        $subject = Subject::find($r->subject_id);
        if($exam_id>18 && $exam_id != 22 && $exam_id != 24){
            foreach($approvedprogramme->candidates as $c){
                $application = Application::where('approvedprogramme_id',$r->approvedprogramme_id)
                    ->where('subject_id',$r->subject_id)
                    ->where('exam_id',$exam_id)
                    ->where('candidate_id',$c->id)
                    ->first();
                $attendance = 'attendence_'.$c->id;
                $internalfield = 'internal_'.$c->id;
                $externalfield = 'external_'.$c->id;
                $applicant = Oldapplicant::where('approvedprogramme_id',$r->approvedprogramme_id)
                    ->where('exam_id',$exam_id)
                    ->where('candidate_id',$c->id)
                    ->first();
                if(is_null($application)){
                    if(is_null($applicant)){
                        $applicant = Oldapplicant::create([
                            'approvedprogramme_id' => $r->approvedprogramme_id,
                            'candidate_id'=> $c->id,
                            'exam_id' =>  $exam_id
                        ]);
                    }
                    if($r->$attendance == 1){
                        $application = Application::create([
                            'candidate_id' => $c->id,
                            'exam_id' => $exam_id,
                            'subject_id' => $r->subject_id,
                            'internalattendance_id' => 1,
                            'externalattendance_id' => 1,
                            'internal_mark' => $r->$internalfield,
                            'external_mark' => $r->$externalfield,
                            'approvedprogramme_id' => $r->approvedprogramme_id,
                            'term' => $subject->syear,
                            'language_id' => 2,
                            "payment_status" => "Not Entered",
                            "active_status" => 1,
                            "status_id" => 6,
                            "linkopen_number" => 1,
                            "penalty" => "No",
                            "externalexamcenter_id" => 1,
                            'applicant_id' => $applicant->id
                        ]);
                    }
                    
                }else{
                    if($r->$attendance == 1){
/*
                        $application->applicant_id = $applicant->id;
                        $application->internalattendance_id = $r->$attendance;
                        $application->externalattendance_id = $r->$attendance;
                        $application->internal_mark = $r->$internalfield; 
                        $application->external_mark = $r->$externalfield; 
                        $application->save(); */
                    }
                }
            }
            Session::put('messages','Updated');
            return back();
        }
        Session::put('messages','Could not update');
        return back();
    }

    public function addgracemark(Request $r){
        
        $ca = Currentapplication::find($r->id);
        if(is_null($ca)){
            return response()->json(['error'=>'Could not update' . $r->id  ]);
        }
        $ca->grace = $r->grace;
        $ca->save();
        return response()->json('success');
    }
 
}
