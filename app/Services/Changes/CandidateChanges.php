<?php
    namespace App\Services\Changes;

    use App\Services\Changes\IChange;
    use App\Services\DBService;
    use App\Services\Common\FilterService;

    class CandidateChanges  extends FilterService implements IChange{
        
        private $academicyear_id;

        public function __construct($academicyear_id,$type) {
            $this->academicyear_id = $academicyear_id;
            parent::__construct($type);
            $this->setTitle("Candidate Changes");
        }   

        public function getLogs(){
            $sp = "getCandidateChanges(".$this->academicyear_id.",'". $this->getType()."')";
            return  is_null($this->getType()) ? null : (new DBService)->callSP($sp);
        }

    }
?>