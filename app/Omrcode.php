<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Omrcode extends Model
{
    //
    public function languages(){
        return $this->belongsToMany('App\Language')->withPivot('rand_string','question_paper_1','question_paper_2','question_paper_3');
    }
}
