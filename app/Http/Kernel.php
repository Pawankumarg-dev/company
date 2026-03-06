<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\Validatesession::class,
            \App\Http\Middleware\CacheControl::class,
            \App\Http\Middleware\XssSanitizer::class,

            //'App\Http\Middleware\VerifyCsrfMiddleware',

        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
     //   'auth' => \App\Http\Middleware\Authenticate::class,
       // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
       // 'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
       // 'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    //   'nber' => \App\Http\Middleware\Nber::class,
    //    'institute' => \App\Http\Middleware\Institute::class,
    //    'examcenter' => \App\Http\Middleware\Externalexamcenter::class,
     //   'evaluationcenter' => \App\Http\Middleware\Evaluationcenter::class,
     //   'student' => \App\Http\Middleware\Student::class,
     //   'rci' => \App\Http\Middleware\Rci::class,
      //  'reports' => \App\Http\Middleware\Reports::class,
      //  'clo' => \App\Http\Middleware\Clo::class,
      //  'baslp' => \App\Http\Middleware\Baslp::class,
       // 'practicalexaminer' => \App\Http\Middleware\Practicalexaminer::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

       // 'ms' => \App\Http\Middleware\Ms::class,
    ];
}
