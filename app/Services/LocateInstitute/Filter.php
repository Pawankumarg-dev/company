<?php

    namespace App\Services\LocateInstitute;

    use App\Services\DBService;
    use App\Academicyear;
    use Illuminate\Http\Request;


    abstract class Filter{

        protected $selected = -1;
        protected $setter = null;
        protected $currentyear_id;
        protected $sp; 

        public function __construct(Request $r) {
            if(!is_null($this->setter) &&  $r->has($this->setter)){
                $this->selected = $r->{$this->setter};
            }
            $this->currentyear_id = Academicyear::where('current',1)->first()->id;
        }
        
        public function getSelected()
        {
            return $this->selected;
        }
        
        abstract function getParams();

        public function setParams($args){
            $rval = $this->currentyear_id ;
            if(!is_null($this->getParams())){
                $type = $args['type'];
                foreach($this->getParams()[$type] as $param){
                    $var = $param === 'none' ?  "-1" : $args[$param];
                    $rval .= "," . $var;
                }
            }
            return $rval;
        }

        public function getData($args){
            $sp = $this->getSP($args);
            return (new DBService)->callSP($sp);
        }

        public function getSP($args){
            return  $this->sp."(".$this->setParams($args).")";
        }

    }
?>