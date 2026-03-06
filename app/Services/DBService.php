<?php 
    namespace App\Services;

    use DB;

    
    class DBService extends PaginationService{

        public function fetch($sql, $paginate = false){
            ini_set('memory_limit','-1');
            $result = DB::select($sql);
            return 
                (!($paginate) || $this->getperPage() == 0)  ? 
                collect($result) : 
                $this->arrayPaginator($result);
        }
       
        public function callSP($sp, $paginate = null){
            return $this->fetch("CALL ". $sp, $paginate);
        }

    }

?>