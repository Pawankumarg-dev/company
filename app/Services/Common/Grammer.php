<?php

namespace App\Services\Common;

class Grammer{
    static public function returnIfNotNull($return,$ifnotnull){
        return is_null($ifnotnull) ? null : $return;
    }
}

?>