<?php
    namespace App\Services\eWeaver\ServiceDesk;

    use App\Services\DBService;
    use Illuminate\Http\Request;

    class Ticket{
        
        public $tickettype_id  = 1;
        public $cmdb_id = 1;

        public function __construct(Request $r) {
            if($r->has('tickettype_id')) {$this->tickettype_id = $r->tickettype_id;}
            if($r->has('cmdb_id')) {$this->cmdb_id = $r->cmdb_id;}
        }

        public function getTickets(){
            $sp = "getTickets(".$this->tickettype_id.",".$this->cmdb_id.")";
            return (new DBService)->callSP($sp);
        }

        
    }