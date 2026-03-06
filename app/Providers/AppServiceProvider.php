<?php

namespace App\Providers;
use Validator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // This will only accept alpha and spaces. 
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value); 
        });
        Validator::extend('udid', function ($attribute, $value) {
            return (strlen($value) == 18 || strlen($value) == 23 || strlen($value) || 20) ? true : false;
        });


        Validator::extend('verhoeff', function ($attribute, $value) {

            $Verhoeff = new Object("d", new Arr(new Arr(0.0, 1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0), new Arr(1.0, 2.0, 3.0, 4.0, 0.0, 6.0, 7.0, 8.0, 9.0, 5.0), new Arr(2.0, 3.0, 4.0, 0.0, 1.0, 7.0, 8.0, 9.0, 5.0, 6.0), new Arr(3.0, 4.0, 0.0, 1.0, 2.0, 8.0, 9.0, 5.0, 6.0, 7.0), new Arr(4.0, 0.0, 1.0, 2.0, 3.0, 9.0, 5.0, 6.0, 7.0, 8.0), new Arr(5.0, 9.0, 8.0, 7.0, 6.0, 0.0, 4.0, 3.0, 2.0, 1.0), new Arr(6.0, 5.0, 9.0, 8.0, 7.0, 1.0, 0.0, 4.0, 3.0, 2.0), new Arr(7.0, 6.0, 5.0, 9.0, 8.0, 2.0, 1.0, 0.0, 4.0, 3.0), new Arr(8.0, 7.0, 6.0, 5.0, 9.0, 3.0, 2.0, 1.0, 0.0, 4.0), new Arr(9.0, 8.0, 7.0, 6.0, 5.0, 4.0, 3.0, 2.0, 1.0, 0.0)), "p", new Arr(new Arr(0.0, 1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0), new Arr(1.0, 5.0, 7.0, 6.0, 2.0, 8.0, 3.0, 0.0, 9.0, 4.0), new Arr(5.0, 8.0, 0.0, 3.0, 7.0, 9.0, 6.0, 1.0, 4.0, 2.0), new Arr(8.0, 9.0, 1.0, 6.0, 0.0, 4.0, 3.0, 5.0, 2.0, 7.0), new Arr(9.0, 4.0, 5.0, 3.0, 1.0, 2.0, 6.0, 8.0, 7.0, 0.0), new Arr(4.0, 2.0, 8.0, 6.0, 5.0, 7.0, 3.0, 9.0, 0.0, 1.0), new Arr(2.0, 7.0, 9.0, 3.0, 8.0, 0.0, 6.0, 4.0, 1.0, 5.0), new Arr(7.0, 0.0, 4.0, 6.0, 9.0, 1.0, 3.0, 2.0, 5.0, 8.0)), "j", new Arr(0.0, 4.0, 3.0, 2.0, 1.0, 5.0, 6.0, 7.0, 8.0, 9.0), "check", new Func(function($str = null) use (&$Verhoeff, &$parseInt) {
                $c = 0.0;
                call_method(call_method(call_method(call_method(call_method($str, "replace", new RegExp("\\D+", "g"), ""), "split", ""), "reverse"), "join", ""), "replace", new RegExp("[\\d]", "g"), new Func(function($u = null, $i = null) use (&$c, &$Verhoeff, &$parseInt) {
                  $c = get(get(get($Verhoeff, "d"), $c), get(get(get($Verhoeff, "p"), (float)(to_number($i) % 8.0)), call($parseInt, $u, 10.0)));
                }));
                return $c;
              }), "get", new Func(function($str = null) use (&$Verhoeff, &$parseInt) {
                $c = 0.0;
                call_method(call_method(call_method(call_method(call_method($str, "replace", new RegExp("\\D+", "g"), ""), "split", ""), "reverse"), "join", ""), "replace", new RegExp("[\\d]", "g"), new Func(function($u = null, $i = null) use (&$c, &$Verhoeff, &$parseInt) {
                  $c = get(get(get($Verhoeff, "d"), $c), get(get(get($Verhoeff, "p"), (float)(to_number(_plus($i, 1.0)) % 8.0)), call($parseInt, $u, 10.0)));
                }));
                return get(get($Verhoeff, "j"), $c);
              }));
              set(get($String, "prototype"), "verhoeffCheck", call(new Func(function() use (&$parseInt) {
                $d = new Arr(new Arr(0.0, 1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0), new Arr(1.0, 2.0, 3.0, 4.0, 0.0, 6.0, 7.0, 8.0, 9.0, 5.0), new Arr(2.0, 3.0, 4.0, 0.0, 1.0, 7.0, 8.0, 9.0, 5.0, 6.0), new Arr(3.0, 4.0, 0.0, 1.0, 2.0, 8.0, 9.0, 5.0, 6.0, 7.0), new Arr(4.0, 0.0, 1.0, 2.0, 3.0, 9.0, 5.0, 6.0, 7.0, 8.0), new Arr(5.0, 9.0, 8.0, 7.0, 6.0, 0.0, 4.0, 3.0, 2.0, 1.0), new Arr(6.0, 5.0, 9.0, 8.0, 7.0, 1.0, 0.0, 4.0, 3.0, 2.0), new Arr(7.0, 6.0, 5.0, 9.0, 8.0, 2.0, 1.0, 0.0, 4.0, 3.0), new Arr(8.0, 7.0, 6.0, 5.0, 9.0, 3.0, 2.0, 1.0, 0.0, 4.0), new Arr(9.0, 8.0, 7.0, 6.0, 5.0, 4.0, 3.0, 2.0, 1.0, 0.0));
                $p = new Arr(new Arr(0.0, 1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0), new Arr(1.0, 5.0, 7.0, 6.0, 2.0, 8.0, 3.0, 0.0, 9.0, 4.0), new Arr(5.0, 8.0, 0.0, 3.0, 7.0, 9.0, 6.0, 1.0, 4.0, 2.0), new Arr(8.0, 9.0, 1.0, 6.0, 0.0, 4.0, 3.0, 5.0, 2.0, 7.0), new Arr(9.0, 4.0, 5.0, 3.0, 1.0, 2.0, 6.0, 8.0, 7.0, 0.0), new Arr(4.0, 2.0, 8.0, 6.0, 5.0, 7.0, 3.0, 9.0, 0.0, 1.0), new Arr(2.0, 7.0, 9.0, 3.0, 8.0, 0.0, 6.0, 4.0, 1.0, 5.0), new Arr(7.0, 0.0, 4.0, 6.0, 9.0, 1.0, 3.0, 2.0, 5.0, 8.0));
                return new Func(function() use (&$d, &$p, &$parseInt) {
                  $this_ = Func::getContext();
                  $c = 0.0;
                  call_method(call_method(call_method(call_method(call_method($this_, "replace", new RegExp("\\D+", "g"), ""), "split", ""), "reverse"), "join", ""), "replace", new RegExp("[\\d]", "g"), new Func(function($u = null, $i = null) use (&$c, &$d, &$p, &$parseInt) {
                    $c = get(get($d, $c), get(get($p, (float)(to_number($i) % 8.0)), call($parseInt, $u, 10.0)));
                  }));
                  return $c === 0.0;
                });
              })));
              if (Verhoeff['check']($value) === 0) {
                /*return true;*/
                return true;
            } else {
                /*return false;*/
                return false;
            }
            // This will only accept alpha and spaces. 
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
          //  return preg_match('/^[\pL\s]+$/u', $value); 
    
        });

        Blade::directive('numberToWord', function ($number) {
         $number =  str_replace('(','',$number);
          $number =  str_replace(')','',$number);
          //$number = floatval($number);
          //return $number ;
          
          return $this->convert_number($number);
         
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function convert_number($number)
    {
     
    }
}
