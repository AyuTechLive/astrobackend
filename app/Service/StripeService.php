<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\Customer as StripeCustomer;
use Stripe\Charge as StripeCharge;
use Exception;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * This MailService class for manage globally -
 * mail service in application.
 *---------------------------------------------------------------- */
class StripeService
{
    /**
     * @var configData - configData
     */
    protected $configData;

    /**
     * @var configItem - configItem
     */
    protected $configItem;

    /**
     * Constructor.
     *
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
        $this->configData = configItem();

        //collect stripe data in config array
        $configItem = $this->configItem = getArrayItem($this->configData, 'payments.gateway_configuration.stripe', []);

        //check test mode or product mode set stripeSecretKey or stripePublishKey
        if (!empty($configItem)) {
            if ($configItem['testMode'] == true) {
                $stripeSecretKey = $configItem['stripeTestingSecretKey'];
                $stripePublishKey = $configItem['stripeTestingPublishKey'];
            } else {
                $stripeSecretKey = $configItem['stripeLiveSecretKey'];
                $stripePublishKey = $configItem['stripeLivePublishKey'];
            }
            //set Stripe Api Secret Key in Stripe static method object
            Stripe::setApiKey($stripeSecretKey);
        }
    }

    /**

     * @param  array -$request - data

     * request to Stripe checkout
     *---------------------------------------------------------------- */
    public function processStripeRequest($request)
    {
        $session = new Session();
      $pay_id=$session->get('pay_id');

        $configItem = [];
        //check stripe configuration array exist
        if (isset($this->configData)) {
            //collect stripe data in config array
            $configItem = $this->configData['payments']['gateway_configuration']['stripe'];
        }

        if (empty($configItem)) {
            throw new Exception("Configuration Missing", 1);
        }

        $paymentMethodTypes = ['paymentMethodTypes'];

        if (
            isset($configItem['paymentMethodTypes'])
            and is_array($configItem['paymentMethodTypes'])
            and !empty($configItem['paymentMethodTypes'])
        ) {
            $paymentMethodTypes =  $configItem['paymentMethodTypes'];
        }

        $stripeChargeData = [];

        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => $paymentMethodTypes,
                'customer_email' => $request['payer_email'],
                'client_reference_id' => $request['order_id'],
                'line_items' => [[
                    'price_data' => [
                            'currency' => $configItem['currency'],
                            'unit_amount' => $this->calculateStripeAmount($request['amounts'][$configItem['currency']]),
                            'product_data' => [
                                    'name' => $request['item_name'],
                                    'description' => $request['description'],
                            ]
                    ],
                    'quantity' => $request['item_qty']
                ]],
                'mode' => 'payment',

                'success_url' => getAppUrl($configItem['callbackUrl']) . '?stripe_session_id={CHECKOUT_SESSION_ID}' . '&paymentOption=stripe&orderId=' . $request['order_id'].'&pay_id=' . $pay_id,
                'cancel_url' => getAppUrl($configItem['callbackUrl']) . '?stripe_session_id={CHECKOUT_SESSION_ID}' . '&paymentOption=stripe&orderId=' . $request['order_id'] .'&pay_id=' . $pay_id,
            ]);

            return $session;
        } catch (Exception $e) {
            //if payment failed set failed message
            $errorMessage['message'] = 'failed';

            //set error message if payment failed
            $errorMessage['errorMessage'] = $e->getMessage();

            //return error message array
            return (array) $errorMessage;
        }
    }

    /**
     * Retrieve Stripe data by session Id
     *
     * @param string $sessionId
     *
     * request to Stripe checkout
     *---------------------------------------------------------------- */
    public function retrieveStripeData($sessionId)
    {
        try {
            $sessionData = \Stripe\Checkout\Session::retrieve($sessionId);
            if (empty($sessionData)) {
                throw new Exception("Session data does not exist.");
            }
            if(!$sessionData->payment_intent) {
                $stripe = new \Stripe\StripeClient($this->configItem['stripeLiveSecretKey']);
                $cancelintent=$stripe->checkout->sessions->expire(
                  $sessionId,
                  []
                );
                return [
                    $cancelintent
                ];
            }

            $paymentIntentData = \Stripe\PaymentIntent::retrieve($sessionData->payment_intent);

            return $paymentIntentData;
        } catch (\Stripe\Error\InvalidRequest $err) {
            //set error message if payment failed
            $errorMessage['errorMessage'] = $err->getMessage();

            //return error message array
            return (array) $errorMessage;
        } catch (\Stripe\Error\Card $err) {
            //set error message if payment failed
            $errorMessage['errorMessage'] = $err->getMessage();

            //return error message array
            return (array) $errorMessage;
        }
    }

    /**
     * Calculate Stripe Amount
     *
     * @param int|float|string $amount - Stripe Amount
     *
     * request to Stripe checkout
     *---------------------------------------------------------------- */
    protected function calculateStripeAmount($amount)
    {
        return $amount * 100;
    }
}
