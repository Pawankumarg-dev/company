<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CloReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clo_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'exam_id',
        'nber_id',
        'day',
        'title',
        'description',
        'file',
        'vidio',
    ];
}
