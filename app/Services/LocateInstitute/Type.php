<?php 

    namespace App\Services\LocateInstitute;

    use Illuminate\Http\Request;

    class Type extends Filter{

        public function __construct(Request $r) {
            $this->setter = "type";
            $this->selected = "state";
            parent::__construct($r);
        }

        public function getParams(){
            return array(
                'state' => null,
                'course' => null
            );
        }
    }

?>
