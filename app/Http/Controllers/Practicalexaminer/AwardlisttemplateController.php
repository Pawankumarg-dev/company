<?php

namespace App\Http\Controllers\Practicalexaminer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use Session;

use App\Http\Requests;

class AwardlisttemplateController extends Controller
{
    private $helperService;
    private $exam_id;

    public function __construct(HelperService $help)
    {
        $this->middleware(['role:faculty']);
        $this->helperService = $help;
        $this->exam_id = 28;

    }

    public function store(Request $r){

        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();

        // if($practicalexaminer_id != 1894){
        //     return redirect('/logoff');
        // }
        //$practicalexaminer  = \App\Practicalexaminer::find($practicalexaminer_id);
        $practicalexaminer  = \App\Faculty::find($practicalexaminer_id);
        $date = \Carbon\Carbon::now()->toDateString();
        $downloadTime = \Carbon\Carbon::now()->toDateTimeString();
        $term = $r->term;

       

        // $templates = \App\Awardlisttemplate::where('faculty_id', $practicalexaminer_id)
        //     ->where('exam_date', $date)
        //     ->where('practicalexam_id', $r->practicalexam_id)
        //     ->where('institute_id', $r->institute_id)
        //     ->where('approvedprogramme_id', $r->approvedprogramme_id)
        //     ->where('term', $term)
        //     ->whereNotNull('marksheet')
        //     ->get();

        // if ($templates) {
        //     return back()->with('templates', $templates);
        // }


        $templates = \App\Awardlisttemplate::where('faculty_id',$practicalexaminer_id)
                    ->where('exam_date',$date)
                    ->where('practicalexam_id',$r->practicalexam_id)
                    ->where('institute_id',$r->institute_id)
                    ->where('approvedprogramme_id',$r->approvedprogramme_id)
                    ->where('term',$term)
                    ->get();
        //dd($templates);
        foreach($templates as $t){
            $t->subjects()->detach();
            $t->delete();
        }
        $template = \App\Awardlisttemplate::create([
            'faculty_id' => $practicalexaminer_id,
            'exam_date' => $date,
            'practicalexam_id' => $r->practicalexam_id,
            'institute_id' => $r->institute_id,
            'approvedprogramme_id' => $r->approvedprogramme_id,
            'term' => $term,
            'downloaded_at' => $downloadTime
           
        ]);
       // dd($template);
        
        $approvedprogramme = \App\Approvedprogramme::find($r->approvedprogramme_id);
       // $practicalexam  = \App\Practicalexam::find($r->practicalexam_id);
        $subjects = \App\Subject::where('syear',$term)
                    ->where('subjecttype_id',2)
                    ->where('programme_id',$approvedprogramme->programme_id)
                    ->get();
        foreach($subjects as $subject){
            if($r->has('chk_'.$subject->id)){
                $template->subjects()->attach($subject->id);
                Session::put($subject->scode,'yes');
            }
          
        }   
        $exam_name  = \App\Exam::find($this->exam_id);
        $subject_ids =  $template->subjects()->pluck('id');
        //dd( $subject_ids);
        $candidate_ids = \App\Allapplication::whereHas('candidate', function($q) use($r){
                    $q->where('approvedprogramme_id',$r->approvedprogramme_id);
                })->whereIn('subject_id',$subject_ids)->where('exam_id', $this->exam_id)
                ->pluck('candidate_id')->unique()->toArray();
       // dd( $candidate_ids);
        $candidates = \App\Candidate::whereIn('id',$candidate_ids)->get();
        Session::flash('messages', 'File Uploaded Successfully');
        return back();

        if($candidates->count()==0){
            $template->subjects()->detach();
            $template->delete();
            Session::flash('error','No Applications found');
            $practicalexams = \App\Practicalexam::where('faculty_id',$practicalexaminer_id)->orderBy('institute_id')->get();
            return redirect('practicalexam/home');
        }

        
        return view('practicalexaminer.awardlisttemplate.template',compact(
            'approvedprogramme',
            'term',
            'template',
            'candidates',
            'practicalexaminer',
            'exam_name'
        ));  
    }

    public function show($id,Request $r){
        $subject_id = $r->subject_id;
        $template = \App\Awardlisttemplate::find($id);
        $ap = \App\Approvedprogramme::find($template->approvedprogramme_id);
        $applications = \App\Allapplication::whereHas('candidate',function($q) use ($template){
            $q->where('approvedprogramme_id',$template->approvedprogramme_id);
        })->where('subject_id',$subject_id)->where('exam_id', $this->exam_id)
        ->get();
        $subject = \App\Subject::find($subject_id);
        if($subject->is_external == 0){
            Session::flash("error","No external for this paper");
            return back();
        }
        return view('practicalexaminer.awardlisttemplate.show',compact('template','applications','ap','subject'));
    }

   public function update($id, Request $request)
    {
        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();

        // Check if file exists
        if (!$request->hasFile('marksheet')) {
            Session::flash('error', 'Please choose a file');
            return back();
        }

        $file = $request->file('marksheet');

        // Check if file is valid
        if (!$file->isValid()) {
            Session::flash('error', 'Invalid file upload');
            return back();
        }

        // Safe datetime and filename
        $datetime = \Carbon\Carbon::now()->format('Ymd_His');
        $extension = $file->getClientOriginalExtension();
        $fname = $id . '_' . $datetime . '.' . $extension;

        // Destination folder
        $destination = public_path('files/externalpractical');

        // Create folder if not exists
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        try {
            // Move file
            $file->move($destination, $fname);
        } catch (\Exception $e) {
            Session::flash('error', 'Upload Failed!');
            return back();
        }

        // Save to database
        $template = \App\Awardlisttemplate::find($id);
        
        if ($template) {
            $template->marksheet_uploaded_at = $datetime;
            $template->marksheet = $fname;
            $template->save();
        }
        //dd( $template);
        Session::flash('messages', 'File Uploaded Successfully');
        
        return back();
    }


     public function downloadSubjectPdf(Request $r)
        {
           
            $term = $r->input('term');
            $subject_ids = collect($r->subject_ids)->map(fn($id) => (int) $id);
            $practicalexaminer_id = $this->helperService->getPracticalExaminerID();
           // dd( $practicalexaminer_id);
            $practicalexaminer  = \App\Faculty::find($practicalexaminer_id);
            $date = \Carbon\Carbon::now()->toDateString();
            $term = $r->term;
            $approvedprogramme = \App\Approvedprogramme::find($r->approvedprogramme_id);
        // $practicalexam  = \App\Practicalexam::find($r->practicalexam_id);
            $subjects = \App\Subject::where('syear',$term)
                        ->where('subjecttype_id',2)
                        ->where('programme_id',$approvedprogramme->programme_id)
                        ->whereIn('id', $subject_ids)
                        ->get(); 
            $exam_name  = \App\Exam::find($this->exam_id);
            $candidate_ids = \App\Allapplication::whereHas('candidate', function($q) use($r){
                        $q->where('approvedprogramme_id',$r->approvedprogramme_id);
                    })->whereIn('subject_id',$subject_ids)->where('exam_id', $this->exam_id)
                    ->pluck('candidate_id')->unique()->toArray();
        // dd( $candidate_ids);
            $candidates = \App\Candidate::whereIn('id',$candidate_ids)->get();
            $date = \Carbon\Carbon::now()->toDateString();
            Session::put('date', $date);
            return view('practicalexaminer.awardlisttemplate.template',compact(
                'approvedprogramme',
                'term',
                'subjects',
                'candidates',
                'practicalexaminer',
                'exam_name'
            ));

        }


    public function upload_entry(Request $r)
    {
        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();
        $date = \Carbon\Carbon::now()->toDateString();
        $downloadTime = \Carbon\Carbon::now()->toDateTimeString();
        $term = $r->term;

        $file = $r->file('marksheet');

        if (!$file) {
            Session::flash('error', 'No file selected');
            return back();
        }

        $datetime = \Carbon\Carbon::now()->format('Ymd_His');
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();
        
        if ($extension !== 'pdf' || $mime !== 'application/pdf') {
            Session::flash('error', 'Only PDF files are allowed');
            return back();
        }

        $fname = $practicalexaminer_id . '_' . $datetime . '.' . $extension;

        $destination = public_path('files/externalpractical');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        try {
            $file->move($destination, $fname);
        } catch (\Exception $e) {
            Session::flash('error', 'Upload Failed!');
            return back();
        }

        if (!empty($r->awardlist_id)) {

            $template = \App\Awardlisttemplate::find($r->awardlist_id);

            if (!$template) {
                Session::flash('error', 'Record not found');
                return back();
            }

            $template->update([
                'marksheet' => $fname,
                'exam_date' => $date,
                'downloaded_at' => $downloadTime,
                'marksheet_uploaded_at' => \Carbon\Carbon::now(),
                'longitude_latitude' =>  \DB::raw("POINT({$r->longitude} , {$r->latitude})")
            ]);

            // Subject pivot update
            $template->subjects()->syncWithoutDetaching([
                $r->subject_id => [
                    'marks_upload' => 1,
                    'date_uploaded' => \Carbon\Carbon::now()
                ]
            ]);

        } else {
            $template = \App\Awardlisttemplate::create([
                'faculty_id' => $practicalexaminer_id,
                'exam_date' => $date,
                'marksheet' => $fname,
                'practicalexam_id' => $r->practicalexam_id,
                'institute_id' => $r->institute_id,
                'approvedprogramme_id' => $r->approvedprogramme_id,
                'term' => $term,
                'downloaded_at' => $downloadTime,
                'marksheet_uploaded_at' => \Carbon\Carbon::now(),
                'longitude_latitude' =>  \DB::raw("POINT({$r->longitude}, {$r->latitude})")
            ]);

            // attach subject
            $template->subjects()->attach($r->subject_id, [
                'marks_upload' => 1,
                'date_uploaded' => \Carbon\Carbon::now()
            ]);
        }

        Session::flash('messages', 'File Uploaded Successfully');
        return back();
    }

}

//A25515