<?php

namespace App\Services\Exam;
use App\Http\Requests;
use App\Currentapplicant;
use App\Supplimentaryapplicant;
use Session;
use App\Services\Common\HelperService;
use DB;
class ExternalPracticalService
{
    
    private $helper;


    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
    }
    public function getListOfStudents($id){
        $awardlist = \App\Awardlisttemplate::find($id);
        $subject_ids = $awardlist->subjects->pluck('id');
        $sql = 'select 
        c.name,
        c.enrolmentno
    from newapplications a 
    left join newapplicants na on na.id = a.newapplicant_id
    left join candidates c on c.id =  a.candidate_id
    left join subjects s on s.id = a.subject_id
    where 
        na.approvedprogramme_id =  '. $awardlist->approvedprogramme_id . ' and 
        s.id in ('.$subject_ids.')  			
    order by s.sortorder
        ';
    }


}
