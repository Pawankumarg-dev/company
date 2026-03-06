<?php

    namespace App\Services\Common;

    use App\Services\Common\FilterService;
    use Maatwebsite\Excel\Facades\Excel;


    class Downloadable{
        private $request;
        private $path;
        private $blade;
        private $title;
        private $attributes;
        public function __construct($path,$blade,$attributes,$title) {
            $this->request = app()->request;
            $this->path = $path;
            $this->blade = $blade;
            $this->title = $title;
            $this->attributes = $attributes;
        }

        public function load(){
            if($this->request->has('download') && $this->request->download == 1){
                Excel::create($this->title, function ($excel){
                    $excel->sheet($this->title, function ($sheet){
                        $sheet->loadview($this->path."/download/".$this->blade,$this->attributes);
                    });
                })->export('xlsx');
            }else{
                return view($this->path.'/'.$this->blade,$this->attributes);
            }
        }
    }

?>