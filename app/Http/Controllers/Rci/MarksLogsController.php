<?php 
    namespace App\Http\Controllers\Rci;
    use App\Http\Controllers\Controller;

    use App\Services\Common\Downloadable;
    use Illuminate\Http\Request;

    use App\Services\Logs\MarksLogs;
    use App\Services\Logs\Logs;

    use Session;

    class MarksLogsController extends Controller{

        private $academicyear_id;
        
        public function __construct() {
            $this->middleware(['role:rci']);
            $this->academicyear_id = Session::get('academicyear_id');
        }

        public function index(Request $r){
            
            $changes = new MarksLogs($this->academicyear_id,$r->type);
            $logs = new Logs($changes);

            $logs->filter($r);

            $results =  $logs->getLogs(true);
            $title = $logs->getTitle();
            $type = $changes->getType($r);
            return view('rci.logs.marks_index',compact(
                'results',
                'title',
                'type'
            ));
          
        }
    }
?>