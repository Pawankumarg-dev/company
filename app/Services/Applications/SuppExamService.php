<?php
    namespace App\Services\Applications;
    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Allapplicant;
    use App\Allapplication;
    use Session;
    use App\Nplustwoexception;

    class SuppExamService{
        private $candidate;
        private $helperService;
        private $exam;
        private $applicant;
        private $subjects;
        private $absentNPlusTwo;
        private $nplustwoexception;
        private $request;
        private $reason ='';
        public function __construct() {
            $this->helperService = new HelperService();        
            $this->candidate = $this->helperService->getCandidate();
            $this->exam = $this->helperService->getScheduledExam();
            $this->applicant = Allapplicant::where('candidate_id',$this->candidate->id)->where('exam_id',$this->exam->id)->first();
            $this->request = app()->request;
            $this->subjects =  $this->getSubjects();
            $this->nplustwoexception = Nplustwoexception::where('candidate_id',$this->candidate->id)->first();
            $this->absentNPlusTwo =0;
            $this->request = app()->request;
        }

        public function getabsentNPlusTwo(){
            return $this->absentNPlusTwo;
        }
        public function getSubjects(){
            //Session::put('testing','Testing');
            
            //Session::put('first_year_attemps',$first_year_attemps);
            $second_year_attemps = 0;
            //Session::put('second_year_attemps',$second_year_attemps);
            $subjects =  $this->getEligibleSubjects();
            //return $subjects;
            $fyp = 0;
            $syp = 0;
            foreach($subjects as $s){
                if($s->syear == 1){
                    $fyp = 1;
                }
                if($s->syear == 2){
                    $syp = 1;
                }
            }
            $first_year_attemps =  0;
            if($fyp == 1){
                $first_year_attemps = $this->checkNPlusTwo(1);
            }
            if($this->candidate->approvedprogramme->programme->numberofterms == 2 && $syp = 1 ){
                $second_year_attemps = $this->checkNPlusTwo(2);
            }
            //return $second_year_attemps;
            if($first_year_attemps > 2 || $second_year_attemps > 2){ 
                // $fywoAbsent_attempts = $this->checkNPlusTwoWithOutAbsents(1);
                // $sywoAbsent_attempts = 0;
                // if($this->candidate->approvedprogramme->programme->numberofterms == 2 && $syp == 1){
                //     $sywoAbsent_attempts = $this->checkNPlusTwo(2);
                //     if($fywoAbsent_attempts < 3 && $sywoAbsent_attempts < 3){ 
                //         $this->absentNPlusTwo = 1;
                //         return $subjects;
                //     }
                // }   
                $this->absentNPlusTwo = 1;
                //$subjects = null;
             //    $subjects = $this->getEligibleSubjectsWithNotAttended();
               // if($subjects->count() == 0){
                   $this->reason = " N+2 completed.";
                //}
                //return null;
            }
            return $subjects;
        }
        

        public function getApplicant(){
            return $this->applicant;
        }

        public function checkNPlusTwo($term){
            $sql  = "SELECT count(distinct exam_id) as no_of_attempt FROM combinedapplications a
                INNER JOIN subjects s on s.id = a.subject_id and s.syear = ".$term." and a.exam_id < 26
                WHERE a.candidate_id= " . $this->candidate->id;
            return  (new DBService)->fetch($sql)[0]->no_of_attempt;
        }

        public function checkNPlusTwoWithOutAbsents($term){
            $sql  = "SELECT count(distinct exam_id) as no_of_attempt FROM combinedapplications a
                INNER JOIN subjects s on s.id = a.subject_id and s.syear = ".$term." and a.attendance_ex != 2 and a.exam_id < 26
                WHERE a.candidate_id= " . $this->candidate->id;
            return  (new DBService)->fetch($sql)[0]->no_of_attempt;
        }
        

        public function getEligibleSubjects(){
            //(cid INT, eid INT,pid INT, etid INT,cayid INT, eayid INT,passed_subjects VARCHAR(255),internal_failed_subjects VARCHAR(255))
            //return $this->candidate;
            $examtype_id = $this->helperService->getExamType($this->exam->id);
            $academicyear_id = $this->candidate->approvedprogramme->academicyear_id;
            // CBID Main Exam with Supplementary exam 2025 January
//            if($this->exam->id == 26 && $this->candidate->approvedprogramme->programme_id == 57){
            if($this->exam->id == 26 && ($this->candidate->approvedprogramme->programme_id == 57 || $this->candidate->approvedprogramme_id == 8797 )){

                $examtype_id = 1;
                $academicyear_id  = 11;
            }
            $failed_internal_papers = $this->getFailedInternalPapers();
            $failed_internal_papers = is_null($failed_internal_papers) ? '0' : $failed_internal_papers;
            $passed_papers = $this->getPassPapers();
            $passed_papers = is_null($passed_papers) ? '0' : $passed_papers;

            $sql = "SELECT
			s.id,
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
        AND
			a.subject_id = s.id
        INNER JOIN 
            candidates c  ON c.id = ".$this->candidate->id."  
        INNER JOIN 
            approvedprogrammes ap on ap.id = c.approvedprogramme_id
        LEFT JOIN
            tmp_attendance_supp_2025 ats
        ON
            ats.candidate_id = ". $this->candidate->id." 
		
		WHERE 
			s.programme_id = ".$this->candidate->approvedprogramme->programme_id;
        // $sql .="
        // AND
        //     (ap.academicyear_id < 10
        //     OR 
        //     ats.attendance = 1
        //     ) ";
                $sql .="     
		AND
			(
				(
					" . $examtype_id ." = 1 
				) 
				OR
				(
					" . $examtype_id ." = 2 
					AND
					s.subjecttype_id = 1
                    AND
                    s.is_external = 1
				)
			)
        
		AND
			s.alternative = 0
		AND 
			(
				(".$academicyear_id." < ".$this->exam->academicyear_id." AND ". $academicyear_id . " > " . ($this->exam->academicyear_id - 3 ) .")  
				OR
				(
					".$academicyear_id." = ".$this->exam->academicyear_id."
					AND
					s.syear = 1
				)
			)
		AND
			s.id NOT IN (".$passed_papers.")
        AND
            s.id NOT IN (".$failed_internal_papers.") 
		GROUP BY
			s.id;";
            $subjects =  (new DBService)->fetch($sql);    
            if($subjects->count()==0 && $failed_internal_papers != '0'){
                $this->reason = " Internal not cleared ";
            }
            if($subjects->count()==0){
                $sqlattendance = "SELECT attendance from tmp_attendance_supp_2025 WHERE candidate_id =  ". $this->candidate->id;
                $attendancerow = (new DBService)->fetch($sqlattendance);
                $attendance = 0;
                if($attendancerow->count() > 0){
                    $attendance = $attendancerow[0]->attendance;
                }
                //
                if($attendance != 1)   {
                    $this->reason = " Not enought classroom attendance";
                }
            }
            // /return $failed_internal_papers;
            return $subjects;
        }

        public function getReason(){
            return $this->reason;
        }
        
        public function getEligibleSubjectsWithNotAttended(){
            //(cid INT, eid INT,pid INT, etid INT,cayid INT, eayid INT,passed_subjects VARCHAR(255),internal_failed_subjects VARCHAR(255))
            //return $this->candidate;
            $examtype_id = $this->helperService->getExamType($this->exam->id);
            $academicyear_id = $this->candidate->approvedprogramme->academicyear_id;
            // CBID Main Exam with Supplementary exam 2025 January
            if($this->exam->id == 26 && ($this->candidate->approvedprogramme->programme_id == 57 || $this->candidate->approvedprogramme_id == 8797 )){
                $examtype_id = 1;
                $academicyear_id  = 11;
            }
            $failed_internal_papers = $this->getFailedInternalPapers();
            $failed_internal_papers = is_null($failed_internal_papers) ? '0' : $failed_internal_papers;
            $passed_papers = $this->getPassPapers();
            $passed_papers = is_null($passed_papers) ? '0' : $passed_papers;

            $sql = "SELECT 
                t1.*,
                SUM(
                    IF(ca.attendance_ex != 2  and ca.result_id_re = 0, 1, 0)) as no_of_attempts
             FROM (SELECT
            c.id as candidate_id,
			s.id,
			s.scode,
			s.sname,
			IF( COUNT(alts.id) > 0 ,GROUP_CONCAT(json_object(
				'id',alts.id,
				'scode', alts.scode,
				'sname', alts.sname
			)),NULL) AS elective_subjects,
            st.type as type,
            s.id as subject_id,
            s.syear as term,
            s.is_external,
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
        AND
			a.subject_id = s.id
        INNER JOIN 
            candidates c  ON c.id = ".$this->candidate->id."  
        INNER JOIN 
            approvedprogrammes ap on ap.id = c.approvedprogramme_id
        LEFT JOIN
            tmp_attendance_supp_2025 ats
        ON
            ats.candidate_id = ". $this->candidate->id." 
		
		WHERE 
			s.programme_id = ".$this->candidate->approvedprogramme->programme_id."
        AND
            (ap.academicyear_id < 10
            OR 
            ats.attendance = 1
            )
		AND
			(
				(
					" . $examtype_id ." = 1 
				) 
				OR
				(
					" . $examtype_id ." = 2 
					AND
					s.subjecttype_id = 1
                    AND
                    s.is_external = 1
				)
			)
        
		AND
			s.alternative = 0
		AND 
			(
				(".$academicyear_id." < ".$this->exam->academicyear_id." AND ". $academicyear_id . " > " . ($this->exam->academicyear_id - 3 ) .")  
				OR
				(
					".$academicyear_id." = ".$this->exam->academicyear_id."
					AND
					s.syear = 1
				)
			)
		AND
			s.id NOT IN (".$passed_papers.")
        AND
            s.id NOT IN (".$failed_internal_papers.") 
		GROUP BY
			s.id) AS t1
            LEFT JOIN combinedapplications ca 
            ON ca.candidate_id  = t1.candidate_id and t1.subject_id = ca.subject_id AND ca.exam_id != 26
            WHERE ca.exam_id !=26 and ca.candidate_id = ". $this->candidate->id . " 
            GROUP BY t1.subject_id 
            HAVING no_of_attempts < 3
                
            ";
            return  (new DBService)->fetch($sql);    
        }
        public function saveApplication(){
            
            if(is_null($this->applicant)){
                if($this->candidate->approvedprogramme_id != 8797 ){
                    if($this->candidate->id != 84615){
                        if($this->candidate->id != 55166){
                            if($this->candidate->approvedprogramme->programme_id != 57){
                                return null;
                            }
                        }
                    }
                    
                }
                if($this->request->exception == 1){
                    try{
                        $imageName = '';
                        if ($this->request->hasFile('document')) {
                            $image = $this->request->file('document');
                            $imageName = $this->exam->id.'_'. $this->candidate->id .'.'. $image->getClientOriginalExtension();
                            $image->move(public_path('files/supplyevidance'), $imageName);
                        }
                    }catch(Exception $e){
                        Session::flash('error','Could not upload Document. Please try again');
                        return back();
                    }
                }
                $this->applicant = Allapplicant::create([
                    'candidate_id' => $this->candidate->id,
                    'exam_id' => $this->exam->id,
                    'language_id' => $this->request->language_id,
                    'amount' => $this->request->finalamount
                ]);
                
                if($this->request->exception == 1){
                    if(is_null($this->nplustwoexception)){
                        Nplustwoexception::create([
                            'candidate_id' => $this->candidate->id,
                            'reason' => $this->request->reason,
                            'allapplicant_id' => $this->applicant->id,
                            'document' => $imageName,
                            'exam' => $this->request->exam
                        ]);
                    }
                }
                //Change this to payment service
                $this->saveSubjects();
                return $this->applicant;
            }
            return null;
        }
        public function saveAdditionalPapers($additional){
            if($this->applicant->payment_status = 1 || $this->applicant->payment_status = 2 ){
                $this->applicant->amount = 100 * $additional;
            }else{
                $this->applicant->amount += 100 * $additional;
            }
            $this->saveSubjects();
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
                    if(is_null($application)){
                        Allapplication::create([
                            'exam_id' => $this->exam->id,
                            'candidate_id' => $this->candidate->id,
                            'applicant_id' => $this->applicant->id,
                            'subject_id' => $s->id,
                            'alternativesubject_id' => $alt
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
                        sum(if(ifnull(a.result_id_re,0) = 1,1,0)) as pass
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
                        a.candidate_id =  '. $this->candidate->id .' AND exam_id != 26
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