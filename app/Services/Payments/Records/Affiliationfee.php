<?php

    namespace App\Services\Payments\Records;

    use App\Services\Common\HelperService;

    use Session;

    class Affiliationfee implements IRecords
    {
        
        private $institute_id;
        private $academicyear_id;
        private $record; 
        private $helper;

        public function __construct($institute_id,$academicyear_id) {
            $this->institute_id = $institute_id;
            $this->academicyear_id = $academicyear_id;
            $this->record = \App\Affiliationfee::where('institute_id',$this->institute_id)->where('academicyear_id',$this->academicyear_id)->first();
            $this->helper = new HelperService();   
        }


        public function fetchOrderNumber(){
            if($this->record->orders()->count() > 0){
                $order_number = $this->record->orders()->first()->order_number;
            }else{
                $order_number = "AF".$this->helper->getUserName()."OR".date('Ymdhis').$this->helper->generateRandomString(2).rand(1000, 9999);
            }
            Session::put('order_number',$order_number);
        }

        public function getRecord(){
            if(is_null($this->record)){
                $this->record = \App\Affiliationfee::create([
                    'institute_id' => $this->institute_id,
                    'academicyear_id' => $this->academicyear_id,
                    'orderstatus_id' => 0,
                    'order_id' => 0,
                ]);
            }
            $this->fetchOrderNumber();
            $this->getAmount();
            return $this->record;
        }

        public function getAmount(){
            $currentorder = \App\Academicyear::find($this->academicyear_id)->order;
            $institute = \App\Institute::find($this->institute_id);
            $total = 0;
            $noofterms = 0;
            foreach($institute->approvedprogrammes as $ap){
            //    if($ap->candidates->count()>0){
                    $noofterms = $ap->programme->numberofterms;
                    $sortorder = $ap->academicyear->order; 
                    for ($i = 1; $i < $noofterms + 1; $i++){
                        if($sortorder == $currentorder){
                            $count = \App\Incidentalfee::where('programme_id',$ap->programme_id)->where('academicyear_id',$this->academicyear_id)->where('term',$i)->count();
                            if($count>0){
                                $fee = \App\Incidentalfee::where('programme_id',$ap->programme_id)->where('academicyear_id',$this->academicyear_id)->where('term',$i)->first()->fee; 
                                $total += $fee;
                            }
                        }
                        $sortorder += 1; 
                    }
            //     }
            }
            Session::put('total',$total);
        }

    }

?>