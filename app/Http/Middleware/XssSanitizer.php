<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class XssSanitizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
       // $input = $request->all(); 

        // Check file extension
       /* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(request()->allFiles() == true){
                array_walk_recursive($input, function ($key, $input) use($request) {
                    if(file_exists($key)){
                        $file = $request->$input;
                        if($file->isValid()){
                            $extension = $file->extension();
                            $extensions = array('png','jpg','jpeg','pdf');
                            if(!in_array($extension,$extensions)){
                                Session::flash('error','Not valid file extension');
                                return response(view('errors.500'), 500);
                            }
                        }
                    }
                });
            }
        }*/
        
        //strip tags from input values
       /* array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });
        $request->merge($input);*/
        return $next($request);
    }
}
