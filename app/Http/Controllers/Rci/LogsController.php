<?php 
    namespace App\Http\Controllers\Rci;
    use App\Http\Controllers\Controller;

    use App\Services\Common\Downloadable;
    use Illuminate\Http\Request;

    use App\Services\Logs\CandidateLogs;
    use App\Services\Logs\Logs;

    use Session;

    class LogsController extends Controller{

        private $academicyear_id;
        
        public function __construct() {
            $this->middleware(['role:rci']);
            $this->academicyear_id = Session::get('academicyear_id');
        }

        public function index(Request $r){
            
            $changes = new CandidateLogs($this->academicyear_id,$r->type);
            $logs = new Logs($changes);

            $logs->filter($r);

            $results =  $logs->getLogs(true);
            $title = $logs->getTitle();
            $type = $changes->getType($r);
            return view('rci.logs.index',compact(
                'results',
                'title',
                'type'
            ));
          
        }
    }
?>