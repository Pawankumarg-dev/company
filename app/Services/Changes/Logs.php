<?php
    namespace App\Services\Logs;

    class Logs{
        
        public $changes ;

        public function __construct($changes) {
            $this->changes = $changes;
        }

        public function getLogs(){
            return $this->changes->getLogs();
        }

        public function getTitle(){
            return $this->changes->getTitle();
        }

        public function filter($r){
            return $this->changes->filter($r);
        }
        
    }