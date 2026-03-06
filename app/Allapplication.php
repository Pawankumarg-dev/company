<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allapplication extends Model
{

    use SoftDeletes;

	protected $fillable = [
	    'candidate_id', 'subject_id','language_id','status_id','exam_id', 'term', 'approvedprogramme_id', 'linkopen_number',
        'penalty',
        'examtype_id',
        'dummy_number',
        'bundle_number',
        'internalattendance_id', 'internal', 'internalresult_id', 'internal_lock', 'internal_file', 'grace',
        'attendance_ex', 'external', 'externalresult_id', 'external_lock', 'external_file',
        'total', 'result_id', 'active_status', 'publish_date', 'publish_status',
        'exammarksheetdetail_id', 'marksheet_number', 'withheld_status', 'externalexamcenter_id', 'examtimetable_id',
        "hallticket_status",
        'payment_status','external_mark','internal_mark','reevaluation_mark','reevaluation_result_id','applicant_id',
        'answerbooklet_no','alternative_paper','additional_application',
        'alternativesubject_id','evaluator_id','nber_id','mark_in'
    ];
    
    public function approvedprogramme()
    {
    	return $this->belongsTo('App\Approvedprogramme');
    }
    public function applicant()
    {
    	return $this->belongsTo('App\Allapplicant','applicant_id');
    }
    public function newapplicant()
    {
    	return $this->belongsTo('App\Newapplicant');
    }
    public function candidate(){
    	return $this->belongsTo('App\Candidate');
    }
    public function subject(){
    	return $this->belongsTo('App\Subject');
    }
    public function language(){
    return $this->belongsTo('App\Language');
}
    public function status(){
        return $this->belongsTo('App\Status');
    }
    public function mark(){
        return $this->hasOne('App\Mark');
    }
    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function scopeWithexam($query,$id){
        return $query->where('exam_id',$id);
    }
    public function scopeSubjectYear($query,$term){
        return $query->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->count();
    }

    public function numbertoword($number){
        

            $words = array(
                '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
                '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
                '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen',
                '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
                '30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
                '80' => 'eighty','90' => 'ninety');
            
            //First find the length of the number
            $number_length = strlen($number);
            //Initialize an empty array
            $number_array = array(0,0,0,0,0,0,0,0,0);        
            $received_number_array = array();
            
            //Store all received numbers into an array
            for($i=0;$i<$number_length;$i++){    
                  $received_number_array[$i] = substr($number,$i,1);    
              }
        
            //Populate the empty array with the numbers received - most critical operation
            for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
                $number_array[$i] = $received_number_array[$j]; 
            }
        
            $number_to_words_string = "";
            //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
            for($i=0,$j=1;$i<9;$i++,$j++){
                //"01,23,45,6,78"
                //"00,10,06,7,42"
                //"00,01,90,0,00"
                if($i==0 || $i==2 || $i==4 || $i==7){
                    if($number_array[$j]==0 || $number_array[$i] == "1"){
                        $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                        $number_array[$i] = 0;
                    }
                       
                }
            }
        
            $value = "";
            for($i=0;$i<9;$i++){
                if($i==0 || $i==2 || $i==4 || $i==7){    
                    $value = $number_array[$i]*10; 
                }
                else{ 
                    $value = $number_array[$i];    
                }            
                if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
                if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
                if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
                if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
                if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; }            
        
            }
            if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
            return ucwords(strtolower($number_to_words_string));
    }
    public function reevaluationresults() {
        return $this->hasMany('App\Reevaluationresult');
    }

    public function result() {
        return $this->belongsTo('App\Result');
    }

    public function examtype() {
        return $this->belongsTo('App\Examtype');
    }

    public function exammarksheetdetail() {
        return $this->belongsTo('App\Exammarksheetdetail');
    }

    public function internalattendance() {
        return $this->belongsTo('App\Internalattendance');
    }

    public function externalattendance() {
        return $this->belongsTo('App\Externalattendance');
    }

    public function internalresult() {
        return $this->belongsTo('App\Internalresult');
    }

    public function externalresult() {
        return $this->belongsTo('App\Externalresult');
    }

    public function internalmarks() {
        return $this->hasMany('App\Internalmark');
    }

    public function externalexamcenter() {
        return $this->belongsTo('App\Externalexamcenter');
    }

    public function examtimetable() {
        return $this->belongsTo('App\Examtimetable');
    }


}
