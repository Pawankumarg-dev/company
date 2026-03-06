<?php 
    namespace App\Services\Common;

    class FilterService{

        private $title;
        private $type;

        public function __construct($type) {
            $this->type = $type;
        }

        public function setTitle($title){
            $this->title = $title;
        }
        
        public function getTitle(){
            return $this->title;
        }   

        public function getType(){
            return $this->type;
        }

        public function filter($r){
            $this->type = $r->has('type') ? $r->type : null; 
        }
    }
?>