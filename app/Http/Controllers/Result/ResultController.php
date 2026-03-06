<?php

namespace App\Http\Controllers\Result;

use App\Candidate;
use App\Candidateexamresultdate;
use App\Exam;
use App\Examresultdate;
use App\Programme;
use App\Application;
use App\Mark;
use App\Reevaluation;
use App\Reevaluationresult;
use App\Withheld;
use Carbon\Carbon;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ResultController extends Controller
{
    public function index($exam_id)
    {
        //--- exam details ---//
        $exam = Exam::find($exam_id);
        //--- ./exam details ---//

        return view('result.index', compact('exam'));
    }

    public function check($exam_id, Request $request)
    {
        $rules = [
            'enrolmentno' => 'required|numeric|exists:candidates,enrolmentno',
            'dob' => 'required'
        ];

        $messages = [
            'enrolmentno.required' => 'Enrolment Number is required',
            'enrolmentno.numeric' => 'Invalid Enrolment Number is entered',
            'enrolmentno.exists' => 'Enrolment Number does not exists',
            'dob.required' => 'Date of Birth is required'
        ];

        $validator = validator($request->all(), $rules, $messages);

        $candidate = Candidate::where('enrolmentno', $request->enrolmentno)->first();
        $validator->after(function ($validator) use ($request, $exam_id, $candidate) {
            if ($candidate) {
                $application = Application::where('exam_id', $exam_id)->where('candidate_id', $candidate->id)->first();

                if (($candidate->dob->format('Y-m-d') != $request->dob)) {
                    $validator->errors()->add('enrolmentno', 'No matches for entered detail found');
                }
                elseif (is_null($application)) {
                    $validator->errors()->add('enrolmentno', 'Candidate Applied detail Not Found');
                }
                else {
                    $candidateexamresultdate = Candidateexamresultdate::where('exam_id', $exam_id)
                        ->where('candidate_id', $candidate->id)->first();

                    if (is_null($candidateexamresultdate)) {
                        $validator->errors()->add('enrolmentno', 'No Exam Result Published');
                    }
                    else {
                        if($candidateexamresultdate->publish_status === 0) {
                            $validator->errors()->add('enrolmentno', 'Exam Result is not Published');
                        }
                        else {
                            if($candidateexamresultdate->underreview_status != 1 && $candidateexamresultdate->withheld_status != 1) {
                                if(is_null($candidateexamresultdate->publish_date)) {
                                    $validator->errors()->add('enrolmentno', 'Exam Result is not Published');
                                }
                            }
                        }
                    }
                    /*
                    else {
                        $applications = Application::where('exam_id', $exam_id)->where('candidate_id', $candidate->id)->get();

                        if($applications->count() == $applications->where('publish_status', 0)->count()) {
                            $validator->errors()->add('enrolmentno', 'Results Under Process');
                        }
                    }
                    */
                }
            }
        });

        $this->validateWith($validator);

        return redirect('/examresult/' . $exam_id . '/' . $candidate->id);
    }

    public function showresult($exam_id, $candidate_id)
    {
        $exam = Exam::find($exam_id);
        $candidate = Candidate::find($candidate_id);

        $applications = Application::select('applications.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->where('applications.exam_id', $exam->id)
            ->where('applications.candidate_id', $candidate->id)
            ->where('applications.publish_status', '1')
            ->orderBy('subjects.syear')->orderBy('subjecttypes.id')->orderBy('sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();

        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $candidateexamresultdate = Candidateexamresultdate::where('exam_id', $exam_id)
            ->where('candidate_id', $candidate->id)->first();

        if (!is_null($candidateexamresultdate)) {
            if($candidateexamresultdate->underreview_status === 1) {
                if($candidateexamresultdate->publish_status === 1) {
                    return view('result.under_review_result', compact('exam', 'applications', 'candidate', 'marks', 'candidateexamresultdate'));
                }
                else {
                    return redirect('/examresult/'.$exam_id);
                }
            }
            elseif($candidateexamresultdate->withheld_status === 0) {
                if($candidateexamresultdate->publish_status === 1 && !is_null($candidateexamresultdate->publish_date)) {
                    $withheldStatusCount = $applications->where('withheld_status', 1)->count();
                    if ($exam_id == 20) {
                        return view('result.january2023_result', compact('exam', 'applications', 'candidate', 'marks', 'candidateexamresultdate', 'withheldStatusCount'));
                    } else {
                        return view('result.result', compact('exam', 'applications', 'candidate', 'marks', 'candidateexamresultdate', 'withheldStatusCount'));
                    }
                }
                else {
                    return redirect('/examresult/'.$exam_id);
                }
            }
            elseif($candidateexamresultdate->withheld_status === 1) {
                if ($exam_id == 20) {
                    return view('result.january2023_withheld_result', compact('exam', 'candidate', 'candidateexamresultdate'));
                } else {
                    return view('result.withheldresult', compact('exam', 'candidate', 'candidateexamresultdate'));
                }
            }
            else {

            }
        }
        else {
            return redirect('/examresult/'.$exam_id);
        }
    }

    //---- Re-evaluation Result ----//
    public function reevaluation($exam_id)
    {
        //--- exam details ---//
        $exam = Exam::find($exam_id);
        //--- ./exam details ---//

        $reevaluation = Reevaluation::where('exam_id', $exam->id)->first();

        return view('result.reevaluation', compact('reevaluation'));
    }

    //---- Re-evaluation Result - Validating ----//
    public function reevaluationcheck($exam_id, Request $request)
    {
        $rules = [
            'enrolmentno' => 'required|numeric|exists:candidates,enrolmentno',
            'dob' => 'required'
        ];

        $messages = [
            'enrolmentno.required' => 'Enrolment Number is required',
            'enrolmentno.numeric' => 'Invalid Enrolment Number is entered',
            'enrolmentno.exists' => 'Enrolment Number does not exists',
            'dob.required' => 'Date of Birth is required'
        ];

        $validator = validator($request->all(), $rules, $messages);

        $c = Candidate::where('enrolmentno', $request->enrolmentno)->first();
        $validator->after(function ($validator) use ($request, $exam_id, $c) {
            if ($c) {
                $a = Application::where('exam_id', $exam_id)->where('candidate_id', $c->id)->first();

                $re = Reevaluation::where('exam_id', $exam_id)
                    ->where('publish_status', '1')->first();

                $rer = Reevaluationresult::where('reevaluation_id', $re->id)->where('candidate_id', $c->id)->where('publish_status', '1')->get();

                if ((\Carbon\Carbon::parse($c->dob)->format('Y-m-d') != $request->dob)) {
                    $validator->errors()->add('enrolmentno', 'Invalid Login Details');
                } elseif (is_null($a)) {
                    $validator->errors()->add('enrolmentno', 'Candidate didn\'t applied the Online Exam Application');
                } elseif ($rer->count() == '0') {
                    $validator->errors()->add('enrolmentno', 'May be it is under process or the candidate didn\'t applied the Re-evaluation');
                } else {

                }
            }

        });

        $this->validateWith($validator);

        return redirect('/reevaluationresult/' . $exam_id . '/' . $c->id);
    }

    public function showreevaluationresult($exam_id, $candidate_id)
    {
        $exam = Exam::find($exam_id);

        $reevaluation = Reevaluation::where('exam_id', $exam->id)->first();

        $reevaluationresult = Reevaluationresult::where('reevaluation_id', $reevaluation->id)
            ->where('candidate_id', $candidate_id)->where('publish_status', '1')->get();

        $candidate = Candidate::where('id', $candidate_id)->first();

        return view('result.reevaluationresult', compact('reevaluationresult', 'candidate', 'reevaluation'));
    }

    public function update()
    {

        /*
        $candidate = Candidate::where('enrolmentno', '231612919')->first();
        $subject = Subject::where('scode', '02MRDM')->first();
        $application = Application::where('exam_id', '2')->where('candidate_id', $candidate->id)->where('subject_id', $subject->id)->first();
        $reevaluated_external_mark = '27';

        if(!is_null($application)) {
            $mark = Mark::where('application_id', $application->id)->first();

            if(!is_null($mark)) {
                $reevaluation = Reevaluation::where('exam_id', '2')->first();

                if(!is_null($reevaluation)) {
                    $reevaluationresult = Reevaluationresult::where('reevaluation_id', $reevaluation->id)
                        ->where('candidate_id', $candidate->id)
                        ->where('subject_id', $subject->id)->first();

                    if(is_null($reevaluationresult)) {
                        Reevaluationresult::create([
                            'reevaluation_id'           =>  $reevaluation->id,
                            'mark_id'                   =>  $mark->id,
                            'application_id'            =>  $application->id,
                            'candidate_id'              =>  $candidate->id,
                            'subject_id'                =>  $subject->id,
                            'actual_external_mark'      =>  $mark->external,
                            'reevaluated_external_mark' =>  $reevaluated_external_mark,
                            'reevaluation_remarks'      => 'Change',
                            'resultdate'                =>  '2018-10-05',
                            'publish_status'            =>  '1'
                        ]);
                    }
                }
            }
        }
        */
        /*
        $revaluation_array = array(

            array("enrolmentno" => "231612919", "scode" => "02MRDM ", "exam_id" => "2", "reevaluated_external_mark" => "27", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "231615606", "scode" => "02MRDM", "exam_id" => "2", "reevaluated_external_mark" => "20", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "231621413", "scode" => "02MRDM", "exam_id" => "2", "reevaluated_external_mark" => "27", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211625616", "scode" => "02ASDES", "exam_id" => "2", "reevaluated_external_mark" => "27", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211716919", "scode" => "01ASDIM", "exam_id" => "2", "reevaluated_external_mark" => "26", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211711821", "scode" => "01ASDNE", "exam_id" => "2", "reevaluated_external_mark" => "28", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211616222", "scode" => "02ASDAF", "exam_id" => "2", "reevaluated_external_mark" => "26", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211711812", "scode" => "01ASDIT", "exam_id" => "2", "reevaluated_external_mark" => "25", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211616222", "scode" => "02ASDTI-1", "exam_id" => "2", "reevaluated_external_mark" => "23", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211616222", "scode" => "02ASDIC", "exam_id" => "2", "reevaluated_external_mark" => "25", "reevaluation_remarks" => "Change", "publish_status" => "1"),

            array("enrolmentno"=>"231608006","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"17", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231621327","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"19", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231607718","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231608004","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"13", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615604","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612630","scode"=>"02MRSC", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717018","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"33", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612610","scode"=>"02MRES", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231625826","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615011","scode"=>"02MRES ", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231624604","scode"=>"02MRES ", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615919","scode"=>"02MRES ", "exam_id"=>"2", "reevaluated_external_mark"=>"8", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231716118","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"32", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231708004","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"12", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"241715904","scode"=>"ECSCT", "exam_id"=>"2", "reevaluated_external_mark"=>"44", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717911","scode"=>"01MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221728016","scode"=>"01CPIT", "exam_id"=>"2", "reevaluated_external_mark"=>"28", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),

            array("enrolmentno"=>"211730521","scode"=>"01ASDAM", "exam_id"=>"2", "reevaluated_external_mark"=>"31", "reevaluation_remarks"=>"Change", "publish_status"=>"1"), array("enrolmentno"=>"231725914","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"22", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717006","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231607428","scode"=>"02MRDM", "exam_id"=>"2", "reevaluated_external_mark"=>"19", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231607428","scode"=>"02MRTP", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231616228","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"14", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221605305","scode"=>"02CPES ", "exam_id"=>"2", "reevaluated_external_mark"=>"26", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221602507","scode"=>"02CPES ", "exam_id"=>"2", "reevaluated_external_mark"=>"30", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221603222","scode"=>"02CPES ", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717911","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231624802","scode"=>"02MRES", "exam_id"=>"2", "reevaluated_external_mark"=>"17", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717029","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615606","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211605506","scode"=>"02ASDTI-1", "exam_id"=>"2", "reevaluated_external_mark"=>"22", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231621404","scode"=>"02MRDM ", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231718708","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"36", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231728009","scode"=>"01MRAA", "exam_id"=>"2", "reevaluated_external_mark"=>"11", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615019","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"14", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615019","scode"=>"02MRTP", "exam_id"=>"2", "reevaluated_external_mark"=>"15", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612109","scode"=>"02MRSC", "exam_id"=>"2", "reevaluated_external_mark"=>"15", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612107","scode"=>"02MRSC", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221603319","scode"=>"02CPES", "exam_id"=>"2", "reevaluated_external_mark"=>"12", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221628012","scode"=>"02CPAA", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221728019","scode"=>"01CPPM", "exam_id"=>"2", "reevaluated_external_mark"=>"22", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211616225","scode"=>"02ASDTI-1", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231618427","scode"=>"02MRDM", "exam_id"=>"2", "reevaluated_external_mark"=>"15", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),

            array("enrolmentno"=>"231726702","scode"=>"01MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"17", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231721028","scode"=>"01MRST", "exam_id"=>"2", "reevaluated_external_mark"=>"8", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717719","scode"=>"01MRST", "exam_id"=>"2", "reevaluated_external_mark"=>"3", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729222","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"8", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729221","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729219","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"6", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729211","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729210","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"6", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729206","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729205","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729204","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"5", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729201","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231728009","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"10", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231728024","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"2", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231711702","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"6", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231723610","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231723623","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211701406","scode"=>"01ASDIT", "exam_id"=>"2", "reevaluated_external_mark"=>"16", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231726701","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"16", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231712102","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231718004","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"33", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231733909","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"14", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231720707","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"29", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705513","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705506","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705510","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"13", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705502","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705505","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"16", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),


            array('enrolmentno'=>'231729202','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'7', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231721329','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221627913','scode'=>'02CPIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'45', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712323','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712323','scode'=>'01MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615011','scode'=>'02MRES ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703321','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615919','scode'=>'02MRTP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211705507','scode'=>'01ASDEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231733915','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231733909','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),

        );
        */
        /*
        for ($i = 0; $i < count($revaluation_array); $i++) {

            if (!is_null($revaluation_array[$i])) {
                $candidate = Candidate::where('enrolmentno', $revaluation_array[$i]["enrolmentno"])->first();
                $subject = Subject::where('scode', $revaluation_array[$i]["scode"])->first();
                $application = Application::where('exam_id', $revaluation_array[$i]["exam_id"])->where('candidate_id', $candidate->id)->where('subject_id', $subject->id)->first();

                if (!is_null($application)) {
                    $mark = Mark::where('application_id', $application->id)->first();

                    if (!is_null($mark)) {
                        $reevaluation = Reevaluation::where('exam_id', $revaluation_array[$i]["exam_id"])->first();

                        if (!is_null($reevaluation)) {
                            $reevaluationresult = Reevaluationresult::where('reevaluation_id', $reevaluation->id)
                                ->where('candidate_id', $candidate->id)
                                ->where('subject_id', $subject->id)->get();

                            if (is_null($reevaluationresult)) {
                                $re = Reevaluationresult::create([
                                    'reevaluation_id' => $reevaluation->id,
                                    'mark_id' => $mark->id,
                                    'application_id' => $application->id,
                                    'candidate_id' => $candidate->id,
                                    'subject_id' => $subject->id,
                                    'actual_external_mark' => $mark->external,
                                    'reevaluated_external_mark' => $revaluation_array[$i]["reevaluated_external_mark"],
                                    'reevaluation_remarks' => $revaluation_array[$i]["reevaluation_remarks"],
                                    'publish_status' => $revaluation_array[$i]["publish_status"],
                                ]);

                                if (!is_null($re)) {
                                    $mark->external = $revaluation_array[$i]["reevaluated_external_mark"];
                                    $mark->save();
                                }
                            }
                        }
                    }
                }
            }
        }
        */

        $reevaluation = Reevaluation::where('exam_id', '2')->first()->id;
        $revaluation_array = (
        array(
            array('enrolmentno'=>'231733909', 'scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231721329','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221627913','scode'=>'02CPIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'45', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
        )
        );

        foreach($revaluation_array as $rea) {
            echo $rea["enrolmentno"].'<br />';
            echo $rea["scode"].'<br />';
            echo $rea["exam_id"].'<br />';
            echo $rea["reevaluated_external_mark"].'<br />';
            echo $rea["reevaluation_remarks"].'<br />';
            echo $rea["publish_status"].'<br />';

            $candidate_id = Candidate::where('enrolmentno', $rea["enrolmentno"])->first()->id;
            $subject_id = Subject::where('scode', $rea["scode"])->first()->id;
            $application = Application::where('exam_id', $rea["exam_id"])->where('candidate_id', $candidate_id)
                ->where('subject_id', $subject_id)->first()->id;

            if(!is_null($application)) {
                echo $application.'<br />';

                $mark = Mark::where('application_id', $application)->first();

                if(!is_null($mark)) {
                    echo 'Previous Mark'.$mark->external.'<br />';

                    $re = Reevaluationresult::where('reevaluation_id', $reevaluation)->where('candidate_id', $candidate_id)
                        ->where('subject_id', $subject_id)->first();

                    if(is_null($re)) {
                        Reevaluationresult::create([
                            'reevaluation_id' => $reevaluation,
                            'mark_id' => $mark->id,
                            'application_id' => $application,
                            'candidate_id' => $candidate_id,
                            'subject_id' => $subject_id,
                            'actual_external_mark' => $mark->external,
                            'reevaluated_external_mark' => $rea["reevaluated_external_mark"],
                            'reevaluation_remarks' => $rea["reevaluation_remarks"],
                            'publish_status' => $rea["publish_status"]
                        ]);

                        //$mark->external = $rea["reevaluated_external_mark"];
                        //$mark->save();

                        $r = Reevaluationresult::where('reevaluation_id', $reevaluation)->where('candidate_id', $subject_id)
                            ->where('subject_id', $subject_id)->first();

                        echo $r.'<br />';
                    }
                }
            }
        }



    }
}