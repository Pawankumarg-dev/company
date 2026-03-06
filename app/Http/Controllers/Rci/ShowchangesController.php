<?php 
    namespace App\Http\Controllers\Rci;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Services\Changes\CandidateChanges;
    use App\Services\Changes\Logs;

    use Session;

    class ShowchangesController extends Controller{

        private $academicyear_id;
        
        public function __construct() {
            $this->middleware(['role:rci']);
            $this->academicyear_id = Session::get('academicyear_id');
        }

        public function index(Request $r){
            
            $changes = new CandidateChanges($this->academicyear_id,$r->type);
            $logs = new Logs($changes);

            $logs->filter($r);

            $results =  $logs->getLogs();
            $title = $logs->getTitle();
            $type = $changes->getType($r);
            
            return view('rci.changes.index',compact(
                    'results',
                    'title',
                    'type'
            ));
            
        }

    

    }
?>