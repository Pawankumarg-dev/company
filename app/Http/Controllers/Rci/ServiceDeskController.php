<?php
    
    namespace App\Http\Controllers\Rci;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Cmdb;
    use App\Services\eWeaver\ServiceDesk\Ticket;

    class ServiceDeskController extends Controller{

        public function index(Request $r){
            $tickets = (new Ticket($r))->getTickets();
            $tickettype_id = $r->has('tickettype_id') ? $r->tickettype_id : 1;
            $cmdb_id = $r->has('cmdb_id') ? $r->cmdb_id : 1;
            
            $cmdbs = Cmdb::all();
            return view('rci.servicedesk.index',compact(
                'tickets',
                'cmdbs',
                'tickettype_id',
                'cmdb_id'
            ));
        }
        
        public function create(Request $r){

        }
    }

?>