<?php
    namespace App\Services\Logs;

    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;

    class MarksLogs  extends FilterService implements ILogs{
        
        private $academicyear_id;

        public function __construct($academicyear_id,$type) {
            $this->academicyear_id = $academicyear_id;
            parent::__construct($type);
            $this->setTitle("Marks Changes");
        }   

        public function getLogs($paginate = null){
            $sp = "getMarksChanges(".$this->academicyear_id.",'". $this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,$paginate),$this->getType());
        }

    }
?>