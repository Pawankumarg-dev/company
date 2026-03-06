<?php

namespace App\Http\Middleware;
use Closure;
use Session;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Facades\Auth;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'testingredirecturl', 'testingcancelurl',
        '/institute/incidentalpayments/ccavenuepaymentgatewayresponsehandler/',
        '/institute/incidentalpayments/ccavenuepaymentgatewayrequesthandler/',
        '/institute/incidentalpayments/ccavenuepaymentgatewaypaymentstatus/{order_num}',
        '/paymentstatus',
        '/institute/examinationpayments/ccavenuepaymentgatewayresponsehandler/',
        '/institute/examinationpayments/ccavenuepaymentgatewayrequesthandler/',
        '/institute/examinationpayments/ccavenuepaymentgatewaypaymentstatus/{order_num}',
        '/institute/examinationpayments/ccavenuepaymentgatewayfailpage/',
        '/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler/',
        '/institute/enrolmentpayments/ccavenuepaymentgatewayrequesthandler/',
        '/institute/enrolmentpayments/ccavenuepaymentgatewaypaymentstatus/{order_num}',
        '/institute/enrolmentpayments/ccavenuepaymentgatewayfailpage/',
        '/student/reevaluation/ccavenuepaymentgatewayresponsehandler',
        '/student/examapplication/ccavenuepaymentgatewayresponsehandler',
        '/api',
        '/payment-response',
        'api/*'
    ];


   
}
