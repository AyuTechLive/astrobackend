<?php

// Include Header file
// include 'header.php';
define('PAY_PAGE_CONFIG', config('paypage-payment'));

/*
 * Use PaytmResponse Class
 * Use PaystackResponse Class
 * Use StripeResponse Class
 * Use RazorpayResponse Class
 * Use InstamojoResponse Class
 * Use IyzicoResponse Class
 * Use PaypalIpnResponse Class
 * Use MercadopagoResponse Class
 * Use PayUmoneyResponse Class
 * Use MollieResponse Class
 * Use RavepayResponse Class
 * Use PagseguroResponse Class
 */

use App\Paypage\Components\Payment\CoingateResponse;
use App\Paypage\Components\Payment\PaytmResponse;
use App\Paypage\Components\Payment\PaystackResponse;
use App\Paypage\Components\Payment\StripeResponse;
use App\Paypage\Components\Payment\RazorpayResponse;
use App\Paypage\Components\Payment\InstamojoResponse;
use App\Paypage\Components\Payment\IyzicoResponse;
use App\Paypage\Components\Payment\PaypalIpnResponse;
use App\Paypage\Components\Payment\MercadopagoResponse;
use App\Paypage\Components\Payment\PayUmoneyResponse;
use App\Paypage\Components\Payment\MollieResponse;
use App\Paypage\Components\Payment\RavepayResponse;
use App\Paypage\Components\Payment\PagseguroResponse;
// Get Config Data
$configData = configItem();

// Get Request Data when payment success or failed
// $requestData = $_REQUEST;
// $payload = @file_get_contents('php://input');


if ($requestData['paymentOption'] == 'coingate') {
    if ($requestData['status'] == 'success') {
        // Create payment success response data.
        $paymentResponseData = [
            'status'   => true
        ];
        // Send data to payment response.
        paymentResponse($paymentResponseData);
    } else if ($requestData['status'] == 'cancel') {
        // Create payment failed response data.
        $paymentResponseData = [
            'status'   => false
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }
} else if ($requestData['paymentOption'] == 'coingate' && !empty($payload)) {

    if (isset($payload['status']) && $payload['status'] == 'paid') {
        // Then create a data for success paypal data
        $paymentResponseData = [
            'status'    => true,
            'rawData'   => (array) $payload,
            'data'     => preparePaymentData($payload['order_id'], $payload['price_amount'], $payload['id'], 'coingate')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);

    }else{
        $paymentResponseData = [
            'status'    => $payload['status'],
            'rawData'   => (array) $payload,
            'data'     => preparePaymentData($payload['order_id'], $payload['price_amount'], $payload['id'], 'coingate')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    }
}



// Check payment Method is paytm
if ($requestData['paymentOption'] == 'paytm') {
    // Get Payment Response instance
    $paytmResponse  = new PaytmResponse();

    // Fetch payment data using payment response instance
    $paytmData = $paytmResponse->getPaytmPaymentData($requestData);

    // Check if payment status is success
    if ($paytmData['STATUS'] == 'TXN_SUCCESS') {
        // Create payment success response data.
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData($paytmData['ORDERID'], $paytmData['TXNAMOUNT'], $paytmData['TXNID'], 'paytm')
        ];
        // Send data to payment response.
        paymentResponse($paymentResponseData);
    } else {
        // Create payment failed response data.
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData($paytmData['ORDERID'], $paytmData['TXNAMOUNT'], $paytmData['TXNID'], 'paytm')
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }
    // Check payment method is instamojo
} elseif ($requestData['paymentOption'] == 'instamojo') {
    // Check if payment successfully procced
    if ($requestData['payment_status'] == "Credit") {
        // Get Instance of instamojo response service
        $instamojoResponse  = new InstamojoResponse();

        // fetch payment data from instamojo response instance
        $instamojoData = $instamojoResponse->getInstamojoPaymentData($requestData);

        // Prepare data for payment response
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $instamojoData,
            'data'     => preparePaymentData($requestData['orderId'], $instamojoData['amount'], $instamojoData['payment_id'], 'instamojo')
        ];
        // Send data to payment response
        paymentResponse($paymentResponseData);
        // Check if payment failed then send failed response
    } else {
        // Prepare data for failed response data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $instamojoData['amount'], null, 'instamojo')
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }

    // Check if payment method is iyzico.
} elseif ($requestData['paymentOption'] == 'iyzico') {
    // Check if payment status is success for iyzico.
    if ($requestData['status'] == 'success') {
        // Get iyzico response.
        $iyzicoResponse  = new IyzicoResponse();

        // fetch payment data using iyzico response instance.
        $iyzicoData = $iyzicoResponse->getIyzicoPaymentData($requestData);
        $rawResult = json_decode($iyzicoData->getRawResult(), true);

        // Check if iyzico payment data is success
        // Then create a array for success data
        if ($iyzicoData->getStatus() == 'success') {
            $paymentResponseData = [
                'status'   => true,
                'rawData'  => (array) $iyzicoData,
                'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], $rawResult['conversationId'], 'iyzico')
            ];
            // Send data to payment response
            paymentResponse($paymentResponseData);
            // If payment failed then create data for failed
        } else {
            // Prepare failed payment data
            $paymentResponseData = [
                'status'   => false,
                'rawData'  => (array) $iyzicoData,
                'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], $rawResult['conversationId'], 'iyzico')
            ];
            // Send data to payment response
            paymentResponse($paymentResponseData);
        }
        // Check before 3d payment process payment failed
    } else {
        // Prepare failed payment data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], null, 'iyzico')
        ];
        // Send data to process response
        paymentResponse($paymentResponseData);
    }

    // Check Paypal payment process
} elseif ($requestData['paymentOption'] == 'paypal') {
    // Get instance of paypal
    $paypalIpnResponse  = new PaypalIpnResponse();

    // fetch paypal payment data
    $paypalIpnData = $paypalIpnResponse->getPaypalPaymentData();
    $rawData = json_decode($paypalIpnData, true);

    // Note : IPN and redirects will come here
    // Check if payment status exist and it is success
    if (isset($requestData['payment_status']) and $requestData['payment_status'] == "Completed") {
        // Then create a data for success paypal data
        $paymentResponseData = [
            'status'    => true,
            'rawData'   => (array) $paypalIpnData,
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], $rawData['txn_id'], 'paypal')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
        // Check if payment not successful
    } else {
        // Prepare payment failed data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => [],
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], null, 'paypal')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    }

    // Check Paystack payment process
} elseif ($requestData['paymentOption'] == 'paystack') {
    $requestData = json_decode($requestData['response'], true);

    // Check if status key exists and payment is successfully completed
    if (isset($requestData['status']) and $requestData['status'] == "success") {
        // Create data for payment success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['data']['reference'], $requestData['data']['amount'], $requestData['data']['reference'], 'paystack')
        ];
        // Send data to payment response for further process
        paymentResponse($paymentResponseData);
        // If paystack payment is failed
    } else {
        // Prepare data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['data']['reference'], $requestData['data']['amount'], $requestData['data']['reference'], 'paystack')
        ];
        // Send data to payment response to further process
        paymentResponse($paymentResponseData);
    }

    // Check Stripe payment process
} elseif ($requestData['paymentOption'] == 'stripe') {
    $stripeResponse = new StripeResponse();

    $stripeData = $stripeResponse->retrieveStripePaymentData($requestData['stripe_session_id']);

    // Check if payment charge status key exist in stripe data and it success
    if (isset($stripeData['status']) and $stripeData['status'] == "succeeded") {
        // Prepare data for success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $stripeData,
            'data'     => preparePaymentData($requestData['orderId'], $stripeData->amount, $stripeData->charges->data[0]['balance_transaction'], 'stripe')
        ];

        // Check if stripe data is failed
    } else {
        // Prepare failed payment data
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $stripeData,
            'data'     => preparePaymentData($requestData['orderId'], $stripeData->amount, null, 'stripe')
        ];
    }

    // Send data to payment response for further process
    paymentResponse($paymentResponseData);

    // Check Razorpay payment process
} elseif ($requestData['paymentOption'] == 'razorpay') {
    $orderId = $requestData['orderId'];

    $requestData = json_decode($requestData['response'], true);

    // Check if razorpay status exist and status is success
    if (isset($requestData['status']) and $requestData['status'] == 'captured') {
        // prepare payment data
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['id'], 'razorpay')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
        // razorpay status is failed
    } else {
        // prepare payment data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['id'], 'razorpay')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    }
} elseif ($requestData['paymentOption'] == 'authorize-net') {
    $orderId = $requestData['order_id'];

    $requestData = json_decode($requestData['response'], true);

    // Check if razorpay status exist and status is success
    if (isset($requestData['status']) and $requestData['status'] == 'success') {
        // prepare payment data
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['transaction_id'], 'authorize-net')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
        // razorpay status is failed
    } else {
        // prepare payment data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['transaction_id'], 'authorize-net')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    }
} elseif ($requestData['paymentOption'] == 'mercadopago') {
    if ($requestData['collection_status'] == 'approved') {
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['order_id'], $requestData['amount'], $requestData['collection_id'], 'mercadopago')
        ];
    } elseif ($requestData['collection_status'] == 'pending') {
        $paymentResponseData = [
            'status'   => 'pending',
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['order_id'], $requestData['amount'], $requestData['collection_id'], 'mercadopago')
        ];
    } else {
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['order_id'], $requestData['amount'], $requestData['collection_id'], 'mercadopago')
        ];
    }
    paymentResponse($paymentResponseData);
} elseif ($requestData['paymentOption'] == 'mercadopago-ipn') {
    $mercadopagoResponse = new MercadopagoResponse();
    $mercadopagoIpnData = $mercadopagoResponse->getMercadopagoPaymentData($requestData);

    // Ipn data recieved here are as following
    //$mercadopagoIpnData['status'] = 'total_paid or not_paid';
    //$mercadopagoIpnData['message'] = 'Message';
    //$mercadopagoIpnData['raw_data'] = 'Raw Ipn Data';
} elseif ($requestData['paymentOption'] == 'payumoney') {
    $payUmoneyResponse = new PayUmoneyResponse();
    $payUmoneyResponseData = $payUmoneyResponse->getPayUmoneyPaymentResponse($requestData);
    if ($payUmoneyResponseData['status'] == 'success') {
        $paymentResponseData = [
            'status'    => true,
            'order_id'  => $payUmoneyResponseData['raw_Data'],
            'rawData'   => $payUmoneyResponseData['raw_Data'],
            'data'      => preparePaymentData($payUmoneyResponseData['order_id'], $payUmoneyResponseData['amount'], $payUmoneyResponseData['txn_id'], 'payumoney')
        ];
    } elseif ($payUmoneyResponseData['status'] == 'failed') {
        $paymentResponseData = [
            'status'    => false,
            'order_id'  => '',
            'rawData'   => $payUmoneyResponseData['raw_Data'],
            'data'      => preparePaymentData($payUmoneyResponseData['order_id'], $payUmoneyResponseData['amount'], $payUmoneyResponseData['txn_id'], 'payumoney')
        ];
    }

    paymentResponse($paymentResponseData);
} elseif ($requestData['paymentOption'] == 'mollie') {
    $paymentResponseData = [
        'status'    => true,
        'order_id'  => $requestData['order_id'],
        'rawData'   => $requestData,
        'data'      => preparePaymentData($requestData['order_id'], $requestData['amount'], null, 'mollie')
    ];

    paymentResponse($paymentResponseData);
} elseif ($requestData['paymentOption'] == 'mollie-webhook') {
    $mollieResponse = new MollieResponse();
    $webhookData = $mollieResponse->retrieveMollieWebhookData($requestData);

    // mollie webhook data received here with following option
    // $webhookData['status']; - payment status (paid|open|pending|failed|expired|canceled|refund|chargeback)
    // $webhookData['raw_data']; - webhook all raw data
    // $webhookData['message']; - if payment failed then message

    // Check Ravepay payment process
} elseif ($requestData['paymentOption'] == 'ravepay') {
    $requestData = json_decode($requestData['response'], true);

    //Check if status key exists and payment is successfully completed
    if (isset($requestData['body']['status']) and $requestData['body']['status'] == "success") {
        // Create data for payment success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['body']['data']['txref'], $requestData['body']['data']['amount'], $requestData['body']['data']['txid'], 'ravepay')
        ];
        // Send data to payment response for further process
        paymentResponse($paymentResponseData);
        // If ravepay payment is failed
    } else {
        // Prepare data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['body']['data']['txref'], $requestData['body']['data']['amount'], $requestData['body']['data']['txid'], 'ravepay')
        ];
        // Send data to payment response to further process
        paymentResponse($paymentResponseData);
    }

    // Check Pagseguro payment process
} elseif ($requestData['paymentOption'] == 'pagseguro') {
    // Get Payment Response instance
    $pagseguroResponse  = new PagseguroResponse();

    // Fetch payment data using payment response instance
    $pagseguroData = $pagseguroResponse->fetchTransactionByRefrenceId($requestData['reference_id']);

    //handling errors
    if (isset($pagseguroData['status']) and $pagseguroData['status'] == 'error') {
        //throw exception when generate errors
        throw new Exception($pagseguroData['message']);
    }

    //transaction status
    //1 - Awaiting payment, 2 - In analysis, 3 - Pay, 4 - Available, 5 - In dispute,
    //6 - Returned, 7 - Canceled
    $txnStatus = $pagseguroData['responseData']->getTransactions()[0]->getStatus();

    //collect transaction code
    $transactionCode = $pagseguroData['responseData']->getTransactions()[0]->getCode();

    // Fetch transaction data by transaction code
    $transactionData = $pagseguroResponse->fetchTransactionByTxnCode($transactionCode);

    // Check if payment status is success
    if ($transactionData['status'] == 'success' and $txnStatus == 3 and $transactionData['responseData']->getReference() == $requestData['reference_id']) {
        // Create payment success response data.
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $transactionData['responseData'],
            'data'     => preparePaymentData(
                $transactionData['responseData']->getReference(),
                $transactionData['responseData']->getGrossAmount(),
                $transactionData['responseData']->getCode(),
                'pagseguro'
            )
        ];
        // Send data to payment response.
        paymentResponse($paymentResponseData);
    } else {
        // Create payment failed response data.
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData(
                $transactionData['responseData']->getReference(),
                $transactionData['responseData']->getGrossAmount(),
                $transactionData['responseData']->getCode(),
                'pagseguro'
            )
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }
} else if ($requestData['paymentOption'] == 'paypal-checkout') {

    $rawData = json_decode($requestData['response'], true);
    $amount = $rawData['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

    // Check if payment status exist and it is success
    if (isset($rawData['status']) and $rawData['status'] == "COMPLETED") {
        // Then create a data for success paypal data
        $paymentResponseData = [
            'status'    => true,
            'rawData'   => (array) $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $amount, $rawData['id'], 'paypal-checkout')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
        // Check if payment not successful
    } else {
        // Prepare payment failed data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => [],
            'data'     => preparePaymentData($requestData['orderId'], $amount, null, 'paypal-checkout')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    }
}

/*
 * This payment used for get Success / Failed data for any payment method.
 *
 * @param array $paymentResponseData - contains : status and rawData
 *
 */
function paymentResponse($paymentResponseData)
{
    // payment status success
    if ($paymentResponseData['status'] === true) {
        // Show payment success page or do whatever you want, like send email, notify to user etc
       
        header('Location: ' . getAppUrl('payment-success'));
        
    } elseif ($paymentResponseData['status'] === 'pending') {
        // Show payment success page or do whatever you want, like send email, notify to user etc
        header('Location: ' . getAppUrl('payment-pending'));
    } else {
        // Show payment error page or do whatever you want, like send email, notify to user etc
        header('Location: ' . getAppUrl('payment-failed'));
    }
}

/*
* Prepare Payment Data.
*
* @param array $paymentData
*
*/
function preparePaymentData($orderId, $amount, $txnId, $paymentGateway)
{
    return [
        'order_id'              => $orderId,
        'amount'                => $amount,
        'payment_reference_id'  => $txnId,
        'payment_gateway'        => $paymentGateway
    ];
}
 ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/payment/payment-response.blade.php ENDPATH**/ ?>