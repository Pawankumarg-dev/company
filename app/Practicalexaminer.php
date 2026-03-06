<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practicalexaminer extends Model
{
    //
    protected $fillable = [
        "name", "practicalexam_id", "practicalexaminertype_id", 'title_id', 'name',
        'age', 'gender_id', 'qualification', 'crrnumber', 'experience', 'address', 'city_id', 'pincode', 'contactnumber',
        'whatsappnumber', 'email', 'select_status', 'edit_status', 'active_status',
        'selected_date', 'user_id','password'
    ];

    public function practicalexam() {
        return $this->belongsTo('App\Practicalexam');
    }

    public function practicalexaminertype() {
        return $this->belongsTo('App\Practicalexaminertype');
    }

    public function title() {
        return $this->belongsTo('App\Title');
    }

    public function gender() {
        return $this->belongsTo('App\Gender');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
