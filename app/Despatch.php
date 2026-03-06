<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despatch extends Model
{
    //
    protected $fillable = [
        "vendor_name", "product_name", "tracking_url", "active_status",
    ];
}
