<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
       // if($response->has('header')){
        //return $response->header('Cache-Control','no-cache,no-store, max-age=0, must-revalidate')

        //->header('Pragma','no-cache')

        //->header('Expires','Sun, 02 Jan 1990 00:00:00 GMT');
        //$response->header('Cache-Control', 'no-cache, must-revalidate');
        // Or whatever you want it to be:
        // $response->header('Cache-Control', 'max-age=100');
        //}else{
            return $response;
        //}
    }
}