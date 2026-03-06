<?php
    namespace App\Services\Applications;
    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Allapplicant;
    use App\Allapplication;
    use Session;
    use App\Nplustwoexception;
    use Auth;

    class MainExamService{
        private $candidate;
        private $helperService;
        private $exam;
        public $applicant;
        private $subjects;
        private $absentNPlusTwo;
        private $nplustwoexception;
        private $request;
        private $reason ='';
        public function __construct() {
            $this->helperService = new HelperService();        
            $this->candidate = $this->helperService->getCandidate();
            //$this->exam = $this->helperService->getScheduledExam();
            $this->exam = \App\Exam::find(28);
            //dd($this->exam);
            $this->applicant = Allapplicant::where('candidate_id',$this->candidate->id)->where('exam_id',$this->exam->id)->first();
            $this->request = app()->request;
            $this->subjects =  $this->getSubjects();
            $this->request = app()->request;
        }

    
        public function getSubjects(){
            $subjects =  $this->getEligibleSubjects();
            return $subjects;
        }
        

        public function getApplicant(){
            return $this->applicant;
        }

        public function getEligibleSubjects(){
            $examtype_id = $this->helperService->getExamType($this->exam->id);
            $academicyear_id = $this->candidate->approvedprogramme->academicyear_id;
            $passed_papers = $this->getPassPapers();
            $passed_papers = is_null($passed_papers) ? '0' : $passed_papers;

            $sql = "SELECT
			s.id,
            s.subjecttype_id,
			s.scode,
			s.sname,
			IF( COUNT(alts.id) > 0 ,GROUP_CONCAT(json_object(
				'id',alts.id,
				'scode', alts.scode,
				'sname', alts.sname
			)),NULL) AS elective_subjects,
            st.type as type,
            s.syear as term,
            s.is_external,
            a.internal_result_id,
            s.syear,
            if(a.id IS NULL,0,1) as application_status,
            if(a.alternativesubject_id IS NULL,NULL,a.alternativesubject_id) as alternativesubject_id
		FROM
			subjects s 
		INNER JOIN
			subjecttypes st
		ON  
			st.id = s.subjecttype_id
		LEFT JOIN 
			alternativesubject_subject pvt
		ON 
			s.id = pvt.subject_id
		LEFT JOIN
			alternativesubjects alts
		ON
			alts.id = pvt.alternativesubject_id
		LEFT JOIN
			allapplications a 
		ON 
			a.candidate_id = ".$this->candidate->id." 
        
        AND a.exam_id=28 AND
			a.subject_id = s.id
        INNER JOIN 
            candidates c  ON c.id = ".$this->candidate->id."  
        INNER JOIN 
            approvedprogrammes ap on ap.id = c.approvedprogramme_id
		WHERE 
            
			s.programme_id = ".$this->candidate->approvedprogramme->programme_id .
        
                "     
		
		AND
			s.alternative = 0
		AND 
			(
				(".$academicyear_id." < ".$this->exam->academicyear_id." AND ". $academicyear_id . " > " . ($this->exam->academicyear_id - 4 ) ." AND ". $this->candidate->approvedprogramme->programme->numberofterms .  " = 2 )  
                OR
                (".$academicyear_id." < ".$this->exam->academicyear_id." AND ". $academicyear_id . " > " . ($this->exam->academicyear_id - 3 ) ." AND ". $this->candidate->approvedprogramme->programme->numberofterms .  " = 1 )  
				OR
				(
					".$academicyear_id." = ".$this->exam->academicyear_id."
					AND
					s.syear = 1
				)
                OR  ". $this->candidate->approvedprogramme->academicyear_id . " = 13
                OR  ". $this->candidate->approvedprogramme->academicyear_id . " = 15
			)
		AND
			s.id NOT IN (".$passed_papers.")
		GROUP BY
			s.id
        ORDER BY
            s.subjecttype_id, s.sortorder
        ;";
            $subjects =  (new DBService)->fetch($sql);    
            // /return $failed_internal_papers;
            //returncollect(json_decode('[{"id":809,"scode":"P05-P01","sname":"Basic Communication","elective_subjects":null,"type":"Practical","term":1,"is_external":1,"syear":1,"application_status":0,"alternativesubject_id":null},{"id":810,"scode":"P05-T01","sname":"Deaf, Deafness and Communication Options","elective_subjects":null,"type":"Theory","term":1,"is_external":1,"syear":1,"application_status":0,"alternativesubject_id":null},{"id":811,"scode":"P05-T02","sname":"Deaf Culture, History, Identity and Sign Language","elective_subjects":null,"type":"Theory","term":1,"is_external":1,"syear":1,"application_status":0,"alternativesubject_id":null},{"id":812,"scode":"P05-P02","sname":"Advanced Communication","elective_subjects":null,"type":"Practical","term":1,"is_external":1,"syear":1,"application_status":0,"alternativesubject_id":null},{"id":813,"scode":"P05-T03","sname":"Indian Sign Language Linguistics","elective_subjects":null,"type":"Theory","term":1,"is_external":1,"syear":1,"application_status":0,"alternativesubject_id":null}]',true));
            return $subjects;
        }

        public function getReason(){
            return $this->reason;
        }
        
        public function saveApplication(){

          
            $approvedprogramme_id = \App\Candidate::where('user_id',Auth::user()->id)->first()->approvedprogramme_id;
           

  $candidate= $this->helperService->getCandidate();
                    if(is_null($candidate->enrolmentno) || $candidate->enrolmentno ==''){
                        Session::flash('messages','Contact your institute');
                        return back();
                    }
                    // $newinternal= \App\Newinternalmark::where('candidate_id',$this->helperService->getCandidateID())->first();
                    // if(is_null($newinternal) && $approvedprogramme_id != 57){
                    //     Session::flash('messages','Contact your institute');
                    //     return back();
                    // }

            
            if(is_null($this->applicant)){
                $this->applicant = Allapplicant::create([
                    'candidate_id' => $this->candidate->id,
                    'exam_id' => $this->exam->id,
                    'language_id' => $this->request->language_id,
                    'nber_id' => $this->candidate->approvedprogramme->programme->nber_id,
                    'amount' => $this->request->finalamount
                ]);
                
                //Change this to payment service
                $this->saveSubjects();
                // $sql = "CALL generateTHTForCandidate(27,".$this->applicant->candidate_id.")";
                // $subjects =  (new DBService)->fetch($sql);    
                return $this->applicant;
            }
            return $this->applicant;
        }
        public function saveSubjects(){
            foreach($this->subjects as $s){
                if($this->request->has('subject_'.$s->id)){
                    $alt = null;
                    if(!is_null($s->elective_subjects)){
                        $rname = 'radio_'.$s->id;
                        $alt = $this->request->$rname;
                    }
                    $application = Allapplication::where('candidate_id',$this->candidate->id)
                                    ->where('subject_id',$s->id)
                                    ->where('exam_id',$this->exam->id)
                                    ->first();

                    // $internal_pre = \App\Combinedapplication::where('candidate_id', $this->candidate->id)
                    //     ->where('subject_id', $s->id)
                    //     ->orderBy('mark_in', 'desc')
                    //     ->first();

                    // $newinternal_curr = \App\Newinternalmark::where('candidate_id', $this->candidate->id)
                    //     ->where('subject_id', $s->id)
                    //     ->orderBy('internal', 'desc')
                    //     ->first();
                    

                
                    // if ($internal_pre) {
                    //     $mark_in = $internal_pre->mark_in;
                    // } elseif ($newinternal_curr) {
                    //     $mark_in = $newinternal_curr->internal;
                    // } else {
                    //     $mark_in = null;
                    // }  
                    $maxCombined = \App\Combinedapplication::where('candidate_id', $this->candidate->id)
                        ->where('subject_id', $s->id)
                        ->max('mark_in'); 

                    $maxInternal = \App\Newinternalmark::where('candidate_id', $this->candidate->id)
                        ->where('subject_id', $s->id)
                        ->max('internal');

                    $mark_in = max($maxCombined ?? 0, $maxInternal ?? 0);
                    $mark_in = ($maxCombined === null && $maxInternal === null) ? null : max($maxCombined ?? 0, $maxInternal ?? 0);

                //    $subject = \App\Subject::where('subject_id', $s->id)->first();

                //     if ($mark_in !== null && $subject && $subject->internal_min_mark <= $mark_in) {
                //         $internal_result_id = 1;
                //     }


                    
                    if(is_null($application)){
                        Allapplication::create([
                            'exam_id' => $this->exam->id,
                            'candidate_id' => $this->candidate->id,
                            'applicant_id' => $this->applicant->id,
                            'mark_in'=> $mark_in,
                            'subject_id' => $s->id,
                            'internal_result_id'=>1,
                            'alternativesubject_id' => $alt,
                            'language_id' => $this->request->language_id
                        ]);
                    }
                }
            }
        }

        public function getExam(){
            return $this->exam;
        }

        public function getExamType(){
            return $this->exam->examtype_id == 1 ? 'Regualr' : 'Supplementary';
        }

        public function getPassPapers(){
            $passed_subjects_sql = ' SELECT 
                    group_concat("\'",t.subject_id,"\'") as subjects
                FROM
                (
                    SELECT
                        a.subject_id,
                        sum(if(ifnull(a.result_id_re,0) = 1 or ifnull(a.result_id,0) = 1 ,1,0)) as pass
                    FROM
                        combinedapplications a
                    WHERE
                        a.candidate_id = '. $this->candidate->id ." 
                        
                    GROUP BY
                        a.subject_id
                    HAVING 	
                        pass > 0 
                ) AS t;
            ";
            
            return  (new DBService)->fetch($passed_subjects_sql)[0]->subjects;    
        }

        public function getFailedInternalPapers(){
            $internal_failed_subjects_sql = '
                SELECT 
                        group_concat("\'",t.subject_id,"\'") as subjects
                FROM
                    (
                    SELECT 
                        s.id as subject_id,
                        sum(if(
                            s.is_internal = 1
                            AND
                            ifnull(a.mark_in,0) < s.imin_marks
                            ,0,1)) as internal_pass		
                    FROM 
                        combinedapplications a
                    INNER JOIN 
                        subjects s
                    ON
                        a.subject_id = s.id
                    WHERE
                        a.candidate_id =  '. $this->candidate->id .' AND exam_id != 27 
                    GROUP BY
                        s.id
                    HAVING 
                        internal_pass = 0
                ) AS t;
            ';
            return  (new DBService)->fetch($internal_failed_subjects_sql)[0]->subjects;    
        }
    }
?>