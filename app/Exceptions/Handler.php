<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException as AuthenticationException;
use Auth;
use App\Error;
use Session;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */



    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */

    public function render($request, Exception $e)
    {

        // if(!is_null($e) && config('app.debug') == true){
        //     return $e;
        // }
        // if ($e instanceof AuthenticationException) {
        //     return redirect('/login');
        // }

        // if ($e instanceof ModelNotFoundException) {
        //     $e = new NotFoundHttpException($e->getMessage(), $e);
        // }

        // if ($e instanceof \Illuminate\Session\TokenMismatchException) {

        //     // flash your message

        //     \Session::flash('error', 'Sorry, your session seems to have expired. Please try again.');

        //     return redirect('login');
        // }

        // if ($e instanceof \Symfony\Component\Debug\Exception\FatalThrowableError) {
        //     //return redirect('/');
        //    // return response(view('errors.500'), 500);
        // }

        // if ($e instanceof \ErrorException && $e->getLine() == 135){
        //     Session::put('messages','Session Expired. Please login again.');
        //     return redirect('/');
        // }
        $response = parent::render($request, $e);
        //return "ERROR";
//         if ($response->status() === 500) {
// //            return Redirect::back()->withErrors(['msg' => 'The Message']);

//             Session::flash('error','Sorry! Something went wrong!');
//             //return back();
//             return response(view('errors.500'), 500);
//         }
        return $response;
        //return parent::render($request, $e);
    }

    public function report(Exception $exception) {

        // Checks if a user has logged in to the system, so the error will be recorded with the user id
        $userId = 0;
        if (Auth::user()) {
            $userId = Auth::user()->id;
        }
        // if (!(
        //     ($exception instanceof \ErrorException && $exception->getLine() == 135)
        //     ||
        //     ($exception->getMessage()=='The given data failed to pass validation.')
        //     ||
        //     ($exception->getLine()==67)
        //     ||
        //     ($exception->getLine()==161)
        //     )){
        if(1){
            $data = array(
                'user_id' => $userId,
                'code' => $exception->getCode() ,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'instanceof' => get_class($exception),
                'url' => app()->request->url()
            );
            Error::create($data); 
        }
        parent::report($exception);
    }
}
