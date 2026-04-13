<?php

    namespace App\Services;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Pagination\LengthAwarePaginator;


    class PaginationService{

        private $perPage; 
        private $request;

        public function __construct() {
            $this->perPage = Input::get('perPage', 50);
            $this->request = app()->request;
            if($this->request->has('download') && $this->request->download==1){
                $this->perPage = 0;
            }
        }

        public function getperPage(){
            return $this->perPage;
        }

        public function arrayPaginator($array) {
            
            $page = Input::get('page', 1);
            
            $offset = ($page * $this->perPage) - $this->perPage;
            
            return new LengthAwarePaginator(
                array_slice(
                    $array,
                    $offset,
                    $this->perPage,
                    true
                ),
                count($array),
                $this->perPage,
                $page,
                ['path' => $this->request->url(), 'query' => $this->request->query()]
            );

        }


    }
?>