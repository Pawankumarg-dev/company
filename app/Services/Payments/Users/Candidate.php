<?php 
    namespace App\Services\Payments\Users;

    use App\Candidate;
    use App\Services\Payments\Tests\Testable;

    class Candidates extends Testable implements Users{

        private $candidate;

        public function __construct($id) {
            $this->candidate = Candidate::find($id);
            parent::__construct();
        }
        
        public function getParam1(){
            $this->candidate->approvedprogramme->academicyear->year;
        }
        
        public function getParam2(){
            $this->candidate->enrolmentno;
        }

        public function getParam3(){
            $this->candidate->approvedprogramme->programme->nber_id;
        }

        public function test(){
            if(is_null($this->candidate) || is_null($this->candidate->enrolmentno) || $this->candidate->enrolmentno == ''){
                Testable::throwIncompleteError();
            }
        }

    }

?>