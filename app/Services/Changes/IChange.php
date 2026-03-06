<?php 
    namespace App\Services\Changes;

    interface IChange{
        public function getLogs();
        public function getTitle();
        public function getType();
        public function filter($r);
    }
?>