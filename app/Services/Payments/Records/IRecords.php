<?php

    namespace App\Services\Payments\Records;

    interface IRecords{
        public function getRecord();
        public function getAmount();
        public function fetchOrderNumber();
    }


?>