<?php 
    namespace App\Services\Logs;

    interface ILogs{
        public function getLogs();
        public function getTitle();
        public function getType();
        public function filter($r);
    }
?>