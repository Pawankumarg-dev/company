<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\Services\LocateInstitute\LocateInstituteService;

use App\Services\Payments\Smartgateway\PaymentHandler; // Adjust if namespace is different
use App\Services\Payments\Smartgateway\APIException; // Adjust if namespace is different


class PaymentgatewayController extends Controller
{
    public function index(){

        return view('paymentgateway.smartgateway.index');

    }


    
   
    public function initiatePayment(Request $request)
    {
        try {
        $paymentHandler = new PaymentHandler();

            $orderId = "php_sdk_" . uniqid();
            $customerId = "php_sdk_customer_" . uniqid();

            // $params = [
            //     "amount" => "10.00",
            //     "order_id" => $orderId,
            //     "customer_id" => $customerId,
            //     "action" => "paymentPage",
            //     "return_url" => route('payment.callback') // Better than hardcoding a URL
            // ];

            $params = [
    "amount"      => "10.00",
    "order_id"    => $orderId,
    "customer_id" => $customerId,
    "action"      => "paymentPage",
    "return_url"  => route('payment.callback'),
];

// Build the query string
$queryString = http_build_query($params);

            
            $session = $paymentHandler->orderSession($params);

            return redirect()->away($session['payment_links']['web']);

        } catch (APIException $e) {
            return response()->view('paymentgateway.smartgateway.error', [
                'error' => $e->getErrorMessage(),
                'error_code' => $e->getErrorCode(),
                'http_code' => $e->getHttpResponseCode()
            ], 500);

        } catch (\Exception $e) {
            return response()->view('paymentgateway.smartgateway.error', [
                'error' => $e->getMessage()
            ], 500);
        }
    }


     public function status(Request $request)
    {

        if (!$request->has('order_id')) {
            return response("<p>Required Parameter Order Id is missing</p>", 400);
        }

        $params = $request->only(['order_id', 'status', 'signature', 'status_id']);

        try {
            $paymentHandler = new PaymentHandler();





            if (!$paymentHandler->validateHMAC_SHA256($params)) {
                throw new APIException(-1, false, "Signature verification failed", "Signature verification failed");
            }

            $order = $paymentHandler->orderStatus($params['order_id']);
            $message = $this->getStatusMessage($order);

            return view('paymentgateway.smartgateway.payment_status', [
                'message' => $message,
                'inputParams' => $params,
                'order' => $order
            ]);

        } catch (APIException $e) {
            return response()->view('paymentgateway.smartgateway.payment_status', [
                'message' => "Payment server error: " . $e->getErrorMessage(),
                'inputParams' => $params,
                'order' => []
            ], 500);
        } catch (\Exception $e) {
            return response()->view('paymentgateway.smartgateway.payment_status', [
                'message' => "Unexpected error occurred: " . $e->getMessage(),
                'inputParams' => $params,
                'order' => []
            ], 500);
        }
    }

    private function getStatusMessage($order)
    {
        $message = "Your order with order_id " . $order["order_id"] . " and amount " . $order["amount"] . " has the following status: ";
        $status = $order["status"];

        switch ($status) {
            case "CHARGED":
                $message .= "order payment done successfully";
                break;
            case "PENDING":
            case "PENDING_VBV":
                $message .= "order payment pending";
                break;
            case "AUTHORIZATION_FAILED":
                $message .= "order payment authorization failed";
                break;
            case "AUTHENTICATION_FAILED":
                $message .= "order payment authentication failed";
                break;
            default:
                $message .= "order status " . $status;
                break;
        }

        return $message;
    }
    
}
