<?php

namespace App\Http\Controllers\Nber\Result;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Externalexamcenter;
use App\Examcenter;
use App\Jobs\GenerateMarksheet;
use App\Statezone;

use App\Services\Result\RemoveDuplicateService;
use App\Services\Result\GenerateMarksheetService;
use Session;
use DB;

class RegenerateController extends Controller
{
    private $exam_id;
    private $removeDuplicateService;
    private $marksheetService;

    public function __construct(RemoveDuplicateService $remove_duplicate,GenerateMarksheetService $marksheet)
    {
       $this->middleware(['role:nber']);
        $this->exam_id = 22;
        $this->removeDuplicateService = $remove_duplicate;
        $this->marksheetService = $marksheet;
        
    }

    public function regenerate($caid,$term){
        
        
        $currentapplicat = \App\Currentapplicant::find($caid);

        /*$max = $currentapplicat->candidate->approvedprogramme->programme->first_year_max;
        if($currentapplicat->candidate->approvedprogramme->programme->noofterms == 2){
            $max += $currentapplicat->candidate->approvedprogramme->programme->second_year_max;
        }
        $sql = "
            SELECT sum(total) as total FROM 
            (SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(reevaluation_mark,0),0)) + sum(ifnull(grace,0)) as total
            FROM currentapplications ca 
            LEFT JOIN subjects s on s.id = ca.subject_id
            WHERE ca.result_id = 1 and ca.candidate_id = " . $currentapplicat->candidate_id . "
            UNION
            SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(external_mark,0),0)) + sum(ifnull(grace,0)) as total
            FROM applications ca 
            LEFT JOIN subjects s on s.id = ca.subject_id
            WHERE ca.result_id = 1 and ca.candidate_id = " . $currentapplicat->candidate_id . ") as m
        ";
        
        $total = DB::select($sql);
        return array_pluck($total,'total')[0];
        Session::flash('errors',$total);
        return back();
 */
        $candidate_id = $currentapplicat->candidate_id;
        $changes = $this->removeDuplicateService->updateSubjectResult($candidate_id);
        $return = $this->removeDuplicateService->getResult($candidate_id);
        $certificate = false;
        if($return['status'] == 'duplicates'){
            $subjects =  $this->removeDuplicateService->getDuplicates();
            $candidate = \App\Candidate::find($candidate_id);
            $duplicatesubject_ids = $return['data'];
            return view('nber.result.duplicate',compact('subjects','candidate','changes','duplicatesubject_ids'));
        }else{
//            Session::flash('error','Ready to Generate');
            
            if(\App\Reevaluationapplication::where('candidate_id',$candidate_id)->count() > 0){
                 $certificate= $this->marksheetService->generateMarksheet($candidate_id,22,$term,true);
            }else{
                $certificate= $this->marksheetService->generateMarksheet($candidate_id,22,$term);
            }
         //   return $certificate ;//== true ? 'T': 'F';
            $job = (new \App\Jobs\GenerateMarksheet($candidate_id,$term))->onQueue('newms');
            $this->dispatch($job);
            Session::put('messages','Generated..');

            //return back();
            //return redirect('nber/candidate/'.$candidate_id);
        }
        //return $certificate ? 'Yes' : 'No';
        if($certificate){
            $job = (new \App\Jobs\GenerateCertificate($candidate_id))->onQueue('newcertificate');
            $this->dispatch($job);
        }
        return back();
    }

    public function fixduplicates(Request $r){
        $sids = '';
        $notdone = null;
        return $this->removeDuplicateService->markDuplicate($r);
        return back();
    }

}
